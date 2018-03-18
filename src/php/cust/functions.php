<?php

function getJobIDFromNo($jobno){
	global $dbsite;

	$sqltext = "SELECT jobsid FROM jobs WHERE jobno='" . $jobno . "'";
	$res = $dbsite->query($sqltext); # or die("Cant get jobsid");

if (! empty($res)) {
	$r = $res[0];
		$ret = $r->jobsid;

	}

	return $ret;
}

function getQuoteIDFromNo($quoteno){
	global $dbsite;

	$sqltext = "SELECT quotesid FROM quotes WHERE quoteno='" . $quoteno . "'";
	$res = $dbsite->query($sqltext); # or die("Cant get quotesid");

if (! empty($res)) {
	$r = $res[0];
		$ret = $r->quotesid;

	}

	return $ret;
}

