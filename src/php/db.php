<?php
include '/srv/ath/src/php/lib/DB.php';

$dbsys = new DB();

if (!$dbsys) {
	printf ( "Connect failed: %s\n", mysqli_connect_error () );
	exit ();
}
function sitedbconnect($sid) {

	$dbsite =  new DB($sid);

	if (!isset($dbsite)) {
		printf ( "Connect failed: %s\n", mysqli_connect_error () );
		exit ();
	} else {
		return $dbsite;
	}
}

// GRANT ALL ON athcore.* TO 'athena'@'localhost' IDENTIFIED BY '';
// hyt6Res_edfGtFRET863£
