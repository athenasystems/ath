<?php

function getSuppDets($suppID){
	global $dbsite;
	$sqltext = "SELECT * FROM supp WHERE suppid=" .$suppID;
	#print $sqltext;
	$res = $dbsite->query($sqltext); # or die("Cant get suppid");
	$r = $res[0];

	return $r;
}






?>
