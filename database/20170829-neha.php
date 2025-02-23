<?php
// CLI based tool to compare FeesClub schemas between school shards
(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('cli only');

// Get DB credentials
define('BASEPATH', TRUE);
define('ENVIRONMENT', 'development');
require '../application/config/development/database.php';

$verbose = 1;

$schema_patch_name = '20170829-neha';

$one_off_queries = array("
CREATE TABLE IF NOT EXISTS `crmfeesclub`.`payment_gateway_list` (
 pymt_gw_code varchar(30) NOT NULL,
 pymt_gw_description varchar(50) NOT NULL,
 PRIMARY KEY (pymt_gw_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

"ALTER TABLE `crmfeesclub`.`school`
 ADD start_pay_date int(3) NOT NULL AFTER fee_type2,
 ADD transc_freeze_status int(2) NOT NULL AFTER last_pay_date,
 ADD fine_monthly_segregation varchar(4) NOT NULL DEFAULT 'NO' AFTER transc_freeze_status,
 ADD payment_gateway varchar(30) NOT NULL AFTER school_code,
 ADD pgw_mid varchar(50) NOT NULL AFTER payment_gateway,
 ADD pgw_enckey varchar(100) NOT NULL AFTER pgw_mid;",
);

$per_school_queries = array("
ALTER TABLE fee_transaction_head
 MODIFY payment_date TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP ;",

"ALTER TABLE fee_transaction_head 
 ADD request_status int(2) NOT NULL AFTER student_id,
 ADD response_status int(2) NOT NULL AFTER request_status,
 ADD chargeback_status int(2) NOT NULL AFTER response_status,
 ADD req_ipaddr_str varchar(45) NOT NULL AFTER collection_centre,
 ADD full_pgw_response_json text AFTER req_ipaddr_str,
 ADD date_created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 ADD created_by int(11) NOT NULL,
 ADD date_modified datetime NULL,
 ADD modified_by int(11) NOT NULL,
 MODIFY status int(2) NOT NULL,
 MODIFY paid_status int(2) NOT NULL DEFAULT '0';",
 
"ALTER TABLE fee_transaction_det
 ADD class_fee_head_id int(11) NOT NULL,
 ADD stud_category int(11) NOT NULL,
 ADD month_desc varchar(20) NOT NULL,
 ADD due_month_no int(2) NOT NULL,
 ADD halfyearly_fee_id int(11) DEFAULT NULL,
 ADD date_created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 ADD created_by int(11) NOT NULL,
 ADD date_modified datetime NULL,
 ADD modified_by int(11) NOT NULL,
 MODIFY other_fee_id int(11) DEFAULT NULL;",
  
"CREATE TABLE IF NOT EXISTS `fee_transaction_action` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `fee_transaction_head_id` int(11) NOT NULL,
 `action_description` varchar(100) NOT NULL,
 `full_pymt_description` text NOT NULL,
 `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `created_by` int(11) NOT NULL,
 `date_modified` datetime NULL,
 `modified_by` int(11) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;",
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

