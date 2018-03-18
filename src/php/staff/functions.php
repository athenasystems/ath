<?php

function getStageName($stagesid){

	$sqltext = "SELECT name FROM stages WHERE stagesid=" . $stagesid;
	$res = $dbsite->query($sqltext); # or die("Cant get stage name");
if (! empty($res)) {
	$r = $res[0];
		$ret = $r->name;

	}

	return $ret;
}

function getSuppExtName($contactsid){

	if($contactsid){
		$sqltext = "SELECT fname,sname FROM contacts WHERE contactsid=" . $contactsid;
		$res = $dbsite->query($sqltext); # or die("Cant get contact name");
if (! empty($res)) {
	$r = $res[0];
			$ret = $r->fname . ' ' . $r->sname;

		}
	}else{
		$ret = '';
	}
	return $ret;
}

function cleanPhoneNumber($no){

	$no = preg_replace("/\D/",'',$no);
	if(preg_match("/^0/",$no)){
		$no = preg_replace("/^0/",'',$no);
		$no = '+44' . $no;
	}
	return $no;

}

function getHolidayData($staffid){
	//	global $holiday;
	//	$holiday_limit_hours = $holiday['limit'] * 8 ;
	//	$holiday_limit_days = $holiday['limit'] * 8 / 24;

	$sqltext = "SELECT SUM((finish-start)-(lfinish-lstart)),holiday
	FROM times,staff where times.staffid=staff.staffid
	AND times_typesid=3 and times.staffid=$staffid
	GROUP BY holiday" ;
	$res = $dbsite->query($sqltext); # or die("Cant get Staff Holiday Times");

	$holiday_taken = 0;

	foreach($res as $r) {

		$holiday['limit'] = $r->holiday;
		$holiday_taken = $holiday_taken + $r['SUM((finish-start)-(lfinish-lstart))'];
	}


	$holiday_limit_hours = $holiday['limit'] * 8 ;
	$holiday_limit_days = $holiday['limit'] * 8 / 24;

	$holiday['taken'] = $holiday_taken/(60*60);
	$holiday['taken_days'] = round($holiday['taken']/8,2) ;
	$holiday['left'] = $holiday_limit_hours - $holiday['taken'] ;
	$holiday['left_days'] = round($holiday['left']/8,2) ;

	$holHTML = <<<EOF
	Holiday Taken: {$holiday['taken']} Hours ({$holiday['taken_days']} Days) -
	Holiday Left: {$holiday['left']} Hours ({$holiday['left_days']} Days)
EOF;

	return $holHTML;

}

function findLastMonMidnight($t=0){

	if((!isset($t))||($t==0)){
		$t = time();
	}

	$startat = $t;# - ( 24 * 60 * 60 ); # One day ago

	for ($i = 0; $i < 7; $i++) {

		if(date("N",$startat) == 1){

			$lastMonday = $startat;		# + (60*60*2);

			$day = mktime( 0, 0, 0, date("m",$lastMonday), date("d",$lastMonday), date("Y",$lastMonday) );
			return $day;
		}
		### HACK ALERT !!! should be 24 below ...
		### Fails on spring clock change so change to 23
		if(($startat>1332640800)&&($startat<1332727200)){
			$startat = $startat + (60*60);
		}

		$startat = $startat - ( 24 * 60 * 60 );

	}
}

function getStaffTimesheet($id,$shiftday){
	global $shift,$lunch;

	$sqltext = "SELECT start, finish,lstart, lfinish FROM times WHERE staffid='$id' AND day=" . $shiftday ;
	#print $sqltext . '<br>';
	$res = $dbsite->query($sqltext); # or die("Cant get Staff Times");

	if (! empty($res)) {
$r = $res[0];


		$shift_norm = $shift;
		$lunch_norm = $lunch;


		if(date("N", $shiftday)==7){

			$shift_norm['start_hour'] = 0;
			$shift_norm['start_min'] = 0;

			$lunch_norm['start_hour'] = 0;
			$lunch_norm['start_min'] = 0;

			$lunch_norm['finish_hour'] = 0;
			$lunch_norm['finish_min'] = 0;

			$shift_norm['finish_hour'] = 0;
			$shift_norm['finish_min'] = 0;

		}

		if(date("N", $shiftday)==6){

			$shift_norm['start_hour'] = 0;
			$shift_norm['start_min'] = 0;

			$lunch_norm['start_hour'] = 0;
			$lunch_norm['start_min'] = 0;

			$lunch_norm['finish_hour'] = 0;
			$lunch_norm['finish_min'] = 0;

			$shift_norm['finish_hour'] = 0;
			$shift_norm['finish_min'] = 0;

		}

		if(date("N", $shiftday)==5){

			$shift_norm['start_hour'] = 7;
			$shift_norm['start_min'] = 30;

			$lunch_norm['start_hour'] = 13;
			$lunch_norm['start_min'] = 0;

			$lunch_norm['finish_hour'] = 13;
			$lunch_norm['finish_min'] = 0;

			$shift_norm['finish_hour'] = 14;
			$shift_norm['finish_min'] = 30;

		}


		$shift['year'] =  date("Y", $shiftday);
		$shift['month'] = date("m", $shiftday);
		$shift['day'] = date("d", $shiftday);


		$shift_start_hour = date("H", $r->start);
		$shift['shour'] = ($shift_start_hour==intval($shift_norm['start_hour'])) ? $shift_start_hour : '<span style="color:#f00;">'.$shift_start_hour.'</span>';
		$shift_start_min = date("i", $r->start);
		$shift['sminute'] = ($shift_start_min==intval($shift_norm['start_min'])) ? $shift_start_min : '<span style="color:#f00;">'.$shift_start_min.'</span>';

		$lunch_start_hour = date("H", $r->lstart);
		$shift['lshour'] = ($lunch_start_hour==intval($lunch_norm['start_hour'])) ? $lunch_start_hour : '<span style="color:#f00;">'.$lunch_start_hour.'</span>';
		$lunch_start_min = date("i", $r->lstart);
		$shift['lsminute'] = ($lunch_start_min==intval($lunch_norm['start_min'])) ? $lunch_start_min : '<span style="color:#f00;">'.$lunch_start_min.'</span>';

		$lunch_finish_hour = date("H", $r->lfinish);
		$shift['lfhour'] = ($lunch_finish_hour==intval($lunch_norm['finish_hour'])) ? $lunch_finish_hour : '<span style="color:#f00;">'.$lunch_finish_hour.'</span>';
		$lunch_finish_min = date("i", $r->lfinish);
		$shift['lfminute'] = ($lunch_finish_min==intval($lunch_norm['finish_min'])) ? $lunch_finish_min : '<span style="color:#f00;">'.$lunch_finish_min.'</span>';


		$shift_finish_hour = date("H", $r->finish);
		$shift['fhour'] = ($shift_finish_hour==intval($shift_norm['finish_hour'])) ? $shift_finish_hour : '<span style="color:#f00;">'.$shift_finish_hour.'</span>';
		$shift_finish_min = date("i", $r->finish);
		$shift['fminute'] = ($shift_finish_min==intval($shift_norm['finish_min'])) ? $shift_finish_min : '<span style="color:#f00;">'.$shift_finish_min.'</span>';

	}

	return $shift;

}

function getRecurringDates($r,$from,$to){
	$rows = array();

	$min = date("i",$r->incept);
	$hour = date("H",$r->incept);
	$day = date("d",$r->incept);
	$month = date("m",$r->incept);
	$year = date("Y",$r->incept);

	switch ($r->every) {
		case 'd':
			$start = $r->incept;
			while($start<=$r->end){
				if($start>=$from && $start<=$to){
					$row = mkDiaryRow($r,$start);
					$rows[] = $row;
				}
				$start = $start + (60 * 60 * 24);
			}

			break;
		case 'w':
			$start = $r->incept;
			while($start<=$r->end){
				if($start>=$from && $start<=$to){
					$row = mkDiaryRow($r,$start);
					$rows[] = $row;
				}
				$start = $start + (60 * 60 * 24 * 7);
			}
			break;
		case 'm':
			$start = $r->incept;
			while($start<=$r->end){
				if($start>=$from && $start<=$to){
					$row = mkDiaryRow($r,$start);
					$rows[] = $row;
				}
				$month++;
				$start = mktime($hour, $min, 0, $month, $day, $year);
			}
			break;
		case 'q':
			$start = $r->incept;
			while($start<=$r->end){
				if($start>=$from && $start<=$to){
					$row = mkDiaryRow($r,$start);
					$rows[] = $row;
				}
				$month = $month+3;
				$start = mktime($hour, $min, 0, $month, $day, $year);
			}
			break;
		case 'y':
			$start = $r->incept;
			while($start<=$r->end){
				if($start>=$from && $start<=$to){
					$row =  mkDiaryRow($r,$start);
					$rows[] = $row;
				}
				$year++;
				$start = mktime($hour, $min, 0, $month, $day, $year);
			}
			break;
	}

	return $rows;
}

function mkDiaryRow($r,$start){

	$row = array(	'diaryid'	=> $r->diaryid,
			'title' 	=> $r->title,
			'content' 	=> $r->content,
			'location' 	=> $r->location,
			'duration' 	=> $r->duration,
			'incept' 	=> $start,
			'done' 		=> $r->done,
			'staffid' 	=> $r->staffid,
			'every' 	=> $r->every,
			'end' 		=> $r->end,
			'origin' 	=> $r->origin
	);
	return $row;

}

function generateStafflogon($fname,$sname){


	$initial1 = substr($fname, 0,1);
	$initial2 = substr($sname, 0,1);
	$logon = strtolower($initial1.$initial2);
	$cnt=1;
	while(!chkLogonNameIsUnique($logon)){
		if($cnt>1 ){
			$logon = substr($logon,0, -1);
		}
		$logon = $logon . $cnt;
		$cnt++;
	}

	return $logon;


}

function chkLogonNameIsUnique($login){

	$sqltext = "SELECT usr FROM pwd WHERE usr='" . $login . "'";
	#print $sqltext;

	$res = $dbsite->query($sqltext); # or die("Cant get Logon details");
	if (! empty($res)) {
		return false;
	}else{
		return true;
	}
}


