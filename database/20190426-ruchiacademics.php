<?php
// CLI based tool to compare FeesClub schemas between school shards
(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('cli only');

// Get DB credentials
define('BASEPATH', TRUE);
define('ENVIRONMENT', 'development');
//require '../application/config/development/database.php';
//if (file_exists('/var/www/erp.feesclub.com/application/config/development/database.php')) {
//	require '/var/www/erp.feesclub.com/application/config/database.php';
//} else {
	require '/var/www/erp.feesclub.com/application/config/database.php';
//}
$verbose = 1;

//$schema_patch_name = '20190219-nehaacademics1';
$schema_patch_name = basename(__FILE__);

$one_off_queries = array(
);

$per_school_queries = array(
        "CREATE TABLE `exam_room_detail` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `exam_room_head_id` int(11) NOT NULL,
		  `class_id` int(11) NOT NULL,
		  `section_id` int(11) NOT NULL,
		  `from_roll` varchar(100) NOT NULL,
		  `to_roll` varchar(100) DEFAULT NULL,
		  `status` varchar(2) NOT NULL DEFAULT 'Y',
		  `academic_year_id` int(11) DEFAULT NULL,
		  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `created_by` int(11) NOT NULL,
		  `date_modified` datetime NOT NULL,
		  `modified_by` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8;",
		"CREATE TABLE `exam_room_head` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `exam_id` int(11) DEFAULT NULL,
		  `room_no` varchar(100) NOT NULL,
		  `no_of_seats` int(11) NOT NULL,
		  `invigilator1` varchar(100) NOT NULL,
		  `invigilator2` varchar(100) NOT NULL,
		  `status` varchar(2) NOT NULL DEFAULT 'Y',
		  `academic_year_id` int(11) DEFAULT NULL,
		  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `created_by` int(11) NOT NULL,
		  `date_modified` datetime NOT NULL,
		  `modified_by` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8;",
		"alter table mark add column section_id int(11) after class_id;"
       

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

