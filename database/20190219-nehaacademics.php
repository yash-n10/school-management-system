<?php
// CLI based tool to compare FeesClub schemas between school shards
(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('cli only');

// Get DB credentials
define('BASEPATH', TRUE);
define('ENVIRONMENT', 'development');
//require '../application/config/development/database.php';
if (file_exists('/var/www/erp.feesclub.com/application/config/development/database.php')) {
	require '/var/www/erp.feesclub.com/application/config/database.php';
} else {
	require '/var/www/erp.feesclub.com/application/config/database.php';
}
$verbose = 1;

$schema_patch_name = '20190219-nehaacademics1';
//$schema_patch_name = basename(__FILE__);

$one_off_queries = array(
);

$per_school_queries = array(
	"CREATE TABLE `exam_routine_head` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `academic_year_id` int(11) NOT NULL DEFAULT 0,
            `class_id` int(11) NOT NULL,
            `section_id` int(11) NOT NULL,
            `course_id` int(11) NOT NULL,
            `exam_id` int(11) NOT NULL,
            `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `created_by` int(11) NOT NULL,
            `date_modified` datetime DEFAULT NULL,
            `modified_by` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `class_id_indx` (`class_id`),
            KEY `section_id_indx` (`section_id`),
            KEY `exam_id_indx` (`exam_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8"   ,
        "CREATE TABLE `exam_routine_det` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `exam_routine_head_id` int(11) NOT NULL,
            `date` date NOT NULL,
            `subject_id` int(11) NOT NULL,
            `total_marks` varchar(5) NOT NULL,
            `pass_marks` varchar(5) NOT NULL,
            `start_timing` varchar(20) NOT NULL,
            `end_timing` varchar(20) NOT NULL,
            `created_by` int(11) NOT NULL,
            `date_modified` datetime DEFAULT NULL,
            `modified_by` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `exam_routine_head_id_indx` (`exam_routine_head_id`),
            KEY `subject_id_indx` (`subject_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8"
       

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

