<?php

include "/srv/ath/src/php/mng/common.php";


$sqltext = "SELECT jobno,stagesid FROM jobs WHERE stagesid<8 ";

#print $sqltext;

$res = $dbsite->query($sqltext); # or die("Cant get jobs");

if (! empty($res)) {
	foreach($res as $r) {

		$delno = preg_replace('/J/', 'D', $r->jobno);

		$from = getPathToFilesReal($r->jobno) . '/other_info/' .$delno . '_singature.pdf';

		if(file_exists($from)){


		print $from ."\n";

		}

	}

}