<?php
// CLI based tool to compare FeesClub schemas between school shards
(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('cli only');

// Get DB credentials
define('BASEPATH', TRUE);
define('ENVIRONMENT', 'development');
if (file_exists('/var/www/erp.feesclub.com/application/config/development/database.php')) {
	require '/var/www/erp.feesclub.com/application/config/development/database.php';
} else {
	require '/var/www/erp.feesclub.com/application/config/development/database.php';
}

$verbose = 1;

$schema_patch_name = '20171124-nehasalry';

$one_off_queries = array(
//    "
//CREATE TABLE IF NOT EXISTS `crmfeesclub`.`payment_gateway_list` (
// pymt_gw_code varchar(30) NOT NULL,
// pymt_gw_description varchar(50) NOT NULL,
// PRIMARY KEY (pymt_gw_code)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

//"ALTER TABLE `crmfeesclub`.`school`
// ADD start_pay_date int(3) NOT NULL AFTER fee_type2,
// ADD transc_freeze_status int(2) NOT NULL AFTER last_pay_date,
// ADD fine_monthly_segregation varchar(4) NOT NULL DEFAULT 'NO' AFTER transc_freeze_status,
// ADD payment_gateway varchar(30) NOT NULL AFTER school_code,
// ADD pgw_mid varchar(50) NOT NULL AFTER payment_gateway,
// ADD pgw_enckey varchar(100) NOT NULL AFTER pgw_mid;",
);

$per_school_queries = array(
"ALTER TABLE salary_head ADD COLUMN start_date date AFTER year;",
"ALTER TABLE salary_head ADD COLUMN end_date date AFTER start_date;",
"ALTER TABLE salary_calculation ADD column sal_pay_date datetime AFTER paid_status;",
"ALTER TABLE salary_calculation ADD column pay_slipno varchar(50) AFTER sal_pay_date;",

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

//$dbquery = "INSERT INTO `crmfeesclub`.`schema_patches` SET name='$schema_patch_name', applied_datetime=NOW();";
//$dbresult = mysqli_query($dblink, $dbquery);

