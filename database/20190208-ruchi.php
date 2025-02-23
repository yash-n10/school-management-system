<?php
// CLI based tool to compare FeesClub schemas between school shards
(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('cli only');

// Get DB credentials
define('BASEPATH', TRUE);
define('ENVIRONMENT', 'development');
//if (file_exists('c:/xamp/htdocs/erp/application/config/development/database.php')) {
//	require 'c:/xamp/htdocs/erp/application/config/development/database.php';
//} else {
//	require 'c:/xamp/htdocs/erp/application/config/database.php';
//}

if (file_exists('/var/www/erp.feesclub.com/application/config/development/database.php')) {
	require '/var/www/erp.feesclub.com/application/config/database.php';
} else {
	require '/var/www/erp.feesclub.com/application/config/database.php';
}

$verbose = 1;

$schema_patch_name = '20190208-ruchi';

$one_off_queries = array(
//    "
//CREATE TABLE IF NOT EXISTS `crmfeesclub`.`payment_gateway_list` (
// pymt_gw_code varchar(30) NOT NULL,
// pymt_gw_description varchar(50) NOT NULL,
// PRIMARY KEY (pymt_gw_code)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

//"ALTER TABLE `crmfeesclub`.`school`
// ADD stop_transaction varchar(4) NOT NULL Default 'NO';",
);

$per_school_queries = array(
	"alter table library_books add column lib_book_code varchar(50) after book_code;" ,//except vivek vidyalaya school
	"alter table library_books add column vendor varchar(50),add column entry_date varchar(50),add column page_no varchar(50) after edition;", //except vivek vidyalaya school
	"CREATE TABLE `resale` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `resale_cust_detail_id` int(11) DEFAULT NULL,
	  `pro` varchar(200) DEFAULT NULL,
	  `cat` varchar(100) DEFAULT NULL,
	  `group` varchar(50) DEFAULT NULL,
	  `comp` varchar(50) DEFAULT NULL,
	  `uqc` varchar(50) DEFAULT NULL,
	  `price` int(11) DEFAULT NULL,
	  `qty` int(11) DEFAULT NULL,
	  `tot_price` int(11) DEFAULT NULL,
	  `created_by` varchar(191) DEFAULT NULL,
	  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	  `last_date_modified` datetime DEFAULT NULL,
	  `last_modified_by` varchar(191) DEFAULT NULL,
	  `created_ip` varchar(191) DEFAULT NULL,
	  `modified_ip` varchar(191) DEFAULT NULL,
	  `status` varchar(2) NOT NULL DEFAULT 'Y',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
	"CREATE TABLE `resale_cust_detail` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `inv_no` varchar(100) DEFAULT NULL,
	  `customer_id` int(11) DEFAULT NULL,
	  `net_tot` int(11) DEFAULT NULL,
	  `created_by` varchar(191) DEFAULT NULL,
	  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	  `last_date_modified` datetime DEFAULT NULL,
	  `last_modified_by` varchar(191) DEFAULT NULL,
	  `created_ip` varchar(191) DEFAULT NULL,
	  `modified_ip` varchar(191) DEFAULT NULL,
	  `status` varchar(2) NOT NULL DEFAULT 'Y',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
	"alter table student add column student_ledger_id int(11);",
	"alter table employee add column emp_ledger_id int (11);",


);


// Connect to DB
$dblink = mysqli_connect($db[$active_group]['hostname'], $db[$active_group]['username'], $db[$active_group]['password'], $db[$active_group]['database']);
if (!$dblink) {
	echo "Error: Unable to connect to MySQL.\n";
	echo "Debugging errno: " . mysqli_connect_errno() . "\n";
	echo "Debugging error: " . mysqli_connect_error() . "\n";
	exit(1);
}

// Check if we have been already applied
$dbquery = "SELECT count(*) FROM `crmfeesclub`.`schema_patches` WHERE name='$schema_patch_name';";
$dbresult = mysqli_query($dblink, $dbquery);
if (!$dbresult) {
	printf("ERROR: MySQL Error fetching schema_patches: %s\n", mysqli_error($link));
	exit(2);
}
list($patch_count) = mysqli_fetch_row($dbresult);
if ($patch_count != 0) {
	echo "ERROR: This patch ($schema_patch_name) has already been applied\nAborting.\n";
	exit(4);
}

// Get list of schools
$dbquery = "SELECT id, description, school_code FROM school";
$dbresult = mysqli_query($dblink, $dbquery);
if (!$dbresult) {
	printf("Error fetching school list: %s\n", mysqli_error($link));
	exit(2);
}
if (mysqli_num_rows($dbresult) == 0) {
	echo "No Schools Found.\n";
	exit(3);
}

$schools = array(0 => array('description' => 'Base School'));
if ($verbose) echo "Schools:\n";
while ($row = mysqli_fetch_assoc($dbresult)) {
	$schools[$row['id']] = $row;
	if ($verbose) echo "\t{$row['id']} - {$row['school_code']} - {$row['description']}\n";
}

/*
 * Start applying changes
 */

// Apply one off modifications
foreach ($one_off_queries AS $one_off_query) {
	$dbresult = mysqli_query($dblink, $one_off_query);
	if (!$dbresult) {
		printf("ERROR: MySQL error applying one off patch: %s\n", mysqli_error($dblink));
		echo "Query: $one_off_query\n";
	}
}

foreach ($schools AS $sid => $school_info) {
	if ($verbose) echo "Processing School $sid - {$school_info['description']}:\n";
	if (!mysqli_select_db($dblink, 'crmfeesclub_' . $sid)) {
		echo "ERROR: Could not access school DB as crmfeesclub_$sid. Skipping...\n";
		continue;
	}

	foreach ($per_school_queries AS $per_school_query) {
		$dbresult = mysqli_query($dblink, $per_school_query);
		if (!$dbresult) {
			printf("ERROR: MySQL error applying one off patch: %s\n", mysqli_error($dblink));
			echo "Query: $per_school_query\n";
		}
	}
}

$dbquery = "INSERT INTO `crmfeesclub`.`schema_patches` SET name='$schema_patch_name', applied_datetime=NOW();";
$dbresult = mysqli_query($dblink, $dbquery);

