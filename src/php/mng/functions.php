<?php

function getStageName($stagesid) {
	global $dbsite;

	$sqltext = "SELECT name FROM stages WHERE stagesid=" . $stagesid;
	$res = $dbsite->query($sqltext); // or die("Cant get stage name");

	if (! empty($res)) {
		$r = $res[0];
		$ret = $r->name;
	}

	return $ret;
}

function getSuppExtName($contactsid) {
	global $dbsite;

	if ($contactsid) {
		$sqltext = "SELECT fname,sname FROM contacts WHERE contactsid=" . $contactsid;
		$res = $dbsite->query($sqltext); // or die("Cant get contact name");

		if (! empty($res)) {
			$r = $res[0];
			$ret = $r->fname . ' ' . $r->sname;
		}
	} else {
		$ret = '';
	}
	return $ret;
}

function cleanPhoneNumber($no) {
	$no = preg_replace("/\D/", '', $no);
	if (preg_match("/^0/", $no)) {
		$no = preg_replace("/^0/", '', $no);
		$no = '+44' . $no;
	}
	return $no;
}

function getHolidayData($staffid) {
	global $dbsite;
	global $holiday;
	$holiday_limit_hours = $holiday['limit'] * 8;
	$holiday_limit_days = $holiday['limit'] * 8 / 24;

	$sqltext = "SELECT SUM((finish-start)-(lfinish-lstart)),holiday
	FROM times,staff where times.staffid=staff.staffid
	AND times_typesid=3 and times.staffid=$staffid
	GROUP BY holiday";
	// echo $sqltext;
	$res = $dbsite->query($sqltext); // or die("Cant get Staff Holiday Times");

	$holiday_taken = 0;

	foreach ($res as $r) {

		$holiday['limit'] = $r->holiday;
		$holiday_taken = $holiday_taken + $r['SUM((finish-start)-(lfinish-lstart))'];
	}

	$holiday_limit_hours = $holiday['limit'] * 8;
	$holiday_limit_days = $holiday['limit'] * 8 / 24;

	$holiday['taken'] = $holiday_taken / (60 * 60);
	$holiday['taken_days'] = round($holiday['taken'] / 8, 2);
	$holiday['left'] = $holiday_limit_hours - $holiday['taken'];
	$holiday['left_days'] = round($holiday['left'] / 8, 2);

	$holHTML = <<<EOF
	Annual Holiday is {$holiday['limit']} Days<br><br>

	Holiday Taken: {$holiday['taken_days']} Days ({$holiday['taken']} Hours) <br><br>
	Holiday Left: {$holiday['left_days']} Days ({$holiday['left']} Hours)
EOF;

	return $holHTML;
}

function findLastMonMidnight($t = 0) {
	if ((! isset($t)) || ($t == 0)) {
		$t = time();
	}

	$startat = $t; // - ( 24 * 60 * 60 ); # One day ago

	for ($i = 0; $i < 7; $i ++) {

		if (date("N", $startat) == 1) {

			$lastMonday = $startat; // + (60*60*2);

			$day = mktime(0, 0, 0, date("m", $lastMonday), date("d", $lastMonday), date("Y", $lastMonday));
			return $day;
		}
		// ## HACK ALERT !!! should be 24 below ...
		// ## Fails on spring clock change so change to 23
		// if(($startat>1332640800)&&($startat<1332727200)){
		// $startat = $startat + (60*60);
		// }

		$startat = mktime(0, 0, 0, date("m", $startat), date("d", $startat) - 1, date("Y", $startat));
	}
}

function getStaffTimesheet($id, $shiftday) {
	global $dbsys;
	global $sitesid;
	global $shift, $lunch;

	$sqltext = "SELECT start, finish,lstart, lfinish , name
	FROM athdb$sitesid.times,times_types
	WHERE athdb$sitesid.times.staffid='$id'
	AND athdb$sitesid.times.times_typesid=times_types.times_typesid
	AND day=" . $shiftday;

	// print $sqltext . '<br>';
	$res = $dbsys->query($sqltext); // or die("Cant get Staff Times");

	if (! empty($res)) {

		$shift_norm = $shift;
		$lunch_norm = $lunch;

		if (date("N", $shiftday) == 7) {

			$shift_norm['start_hour'] = 0;
			$shift_norm['start_min'] = 0;

			$lunch_norm['start_hour'] = 0;
			$lunch_norm['start_min'] = 0;

			$lunch_norm['finish_hour'] = 0;
			$lunch_norm['finish_min'] = 0;

			$shift_norm['finish_hour'] = 0;
			$shift_norm['finish_min'] = 0;
		}

		if (date("N", $shiftday) == 6) {

			$shift_norm['start_hour'] = 0;
			$shift_norm['start_min'] = 0;

			$lunch_norm['start_hour'] = 0;
			$lunch_norm['start_min'] = 0;

			$lunch_norm['finish_hour'] = 0;
			$lunch_norm['finish_min'] = 0;

			$shift_norm['finish_hour'] = 0;
			$shift_norm['finish_min'] = 0;
		}

		if (date("N", $shiftday) == 5) {

			// $shift_norm['start_hour'] = 7;
			// $shift_norm['start_min'] = 30;

			// $lunch_norm['start_hour'] = 13;
			// $lunch_norm['start_min'] = 0;

			// $lunch_norm['finish_hour'] = 13;
			// $lunch_norm['finish_min'] = 0;

			$shift_norm['finish_hour'] = 16;
			$shift_norm['finish_min'] = 30;
		}

		$shift_ret['year'] = date("Y", $shiftday);
		$shift_ret['month'] = date("m", $shiftday);
		$shift_ret['day'] = date("d", $shiftday);

		$r = $res[0];

		$shift_start_hour = date("H", $r->start);
		$shift_ret['shour'] = ($shift_start_hour == intval($shift_norm['start_hour'])) ? $shift_start_hour : '<span style="color:#f00;">' . $shift_start_hour . '</span>';
		$shift_start_min = date("i", $r->start);
		$shift_ret['sminute'] = ($shift_start_min == intval($shift_norm['start_min'])) ? $shift_start_min : '<span style="color:#f00;">' . $shift_start_min . '</span>';

		$lunch_start_hour = date("H", $r->lstart);
		$shift_ret['lshour'] = ($lunch_start_hour == intval($lunch_norm['start_hour'])) ? $lunch_start_hour : '<span style="color:#f00;">' . $lunch_start_hour . '</span>';
		$lunch_start_min = date("i", $r->lstart);
		$shift_ret['lsminute'] = ($lunch_start_min == intval($lunch_norm['start_min'])) ? $lunch_start_min : '<span style="color:#f00;">' . $lunch_start_min . '</span>';

		$lunch_finish_hour = date("H", $r->lfinish);
		$shift_ret['lfhour'] = ($lunch_finish_hour == intval($lunch_norm['finish_hour'])) ? $lunch_finish_hour : '<span style="color:#f00;">' . $lunch_finish_hour . '</span>';
		$lunch_finish_min = date("i", $r->lfinish);
		$shift_ret['lfminute'] = ($lunch_finish_min == intval($lunch_norm['finish_min'])) ? $lunch_finish_min : '<span style="color:#f00;">' . $lunch_finish_min . '</span>';

		$shift_finish_hour = date("H", $r->finish);
		$shift_ret['fhour'] = ($shift_finish_hour == intval($shift_norm['finish_hour'])) ? $shift_finish_hour : '<span style="color:#f00;">' . $shift_finish_hour . '</span>';
		$shift_finish_min = date("i", $r->finish);
		$shift_ret['fminute'] = ($shift_finish_min == intval($shift_norm['finish_min'])) ? $shift_finish_min : '<span style="color:#f00;">' . $shift_finish_min . '</span>';

		$shift_ret['type_name'] = $r->name;
	}

	return $shift_ret;
}

function getRecurringDates($r, $from, $to) {
	$rows = array();

	$min = date("i", $r->incept);
	$hour = date("H", $r->incept);
	$day = date("d", $r->incept);
	$month = date("m", $r->incept);
	$year = date("Y", $r->incept);

	switch ($r->every) {
		case 'd':
			$start = $r->incept;
			while ($start <= $r->end) {
				if ($start >= $from && $start <= $to) {
					$row = mkDiaryRow($r, $start);
					$rows[] = $row;
				}
				$start = $start + (60 * 60 * 24);
			}

			break;
		case 'w':
			$start = $r->incept;
			while ($start <= $r->end) {
				if ($start >= $from && $start <= $to) {
					$row = mkDiaryRow($r, $start);
					$rows[] = $row;
				}
				$start = $start + (60 * 60 * 24 * 7);
			}
			break;
		case 'm':
			$start = $r->incept;
			while ($start <= $r->end) {
				if ($start >= $from && $start <= $to) {
					$row = mkDiaryRow($r, $start);
					$rows[] = $row;
				}
				$month ++;
				$start = mktime($hour, $min, 0, $month, $day, $year);
			}
			break;
		case 'q':
			$start = $r->incept;
			while ($start <= $r->end) {
				if ($start >= $from && $start <= $to) {
					$row = mkDiaryRow($r, $start);
					$rows[] = $row;
				}
				$month = $month + 3;
				$start = mktime($hour, $min, 0, $month, $day, $year);
			}
			break;
		case 'y':
			$start = $r->incept;
			while ($start <= $r->end) {
				if ($start >= $from && $start <= $to) {
					$row = mkDiaryRow($r, $start);
					$rows[] = $row;
				}
				$year ++;
				$start = mktime($hour, $min, 0, $month, $day, $year);
			}
			break;
	}

	return $rows;
}

function mkDiaryRow($r, $start) {
	$row = array(
			'diaryid' => $r->diaryid,
			'title' => $r->title,
			'content' => $r->content,
			'location' => $r->location,
			'duration' => $r->duration,
			'incept' => $start,
			'done' => $r->done,
			'staffid' => $r->staffid,
			'every' => $r->every,
			'end' => $r->end,
			'origin' => $r->origin
	);
	return $row;
}

function generateStafflogon($fname, $sname) {
	$initial1 = substr($fname, 0, 1);
	$initial2 = substr($sname, 0, 1);
	$logon = strtolower($initial1 . $initial2);
	$cnt = 1;
	while (! chkLogonNameIsUnique($logon)) {
		if ($cnt > 100) {
			$logon = substr($logon, 0, - 3);
		} elseif ($cnt > 10) {
			$logon = substr($logon, 0, - 2);
		} elseif ($cnt > 1) {
			$logon = substr($logon, 0, - 1);
		} else {}
		$logon = $logon . $cnt;
		$cnt ++;
	}

	return $logon;
}

function generateContactlogon($fname, $sname) {
	$fname=preg_replace('/\W/', '', $fname);
	$sname=preg_replace('/\W/', '', $sname);
	$initial1 = substr($fname, 0, 2);
	$initial2 = substr($sname, 0, 2);
	$logon = strtolower($initial1 . $initial2);
	$cnt = 1;
	while (! chkLogonNameIsUnique($logon)) {
		if ($cnt > 100) {
			$logon = substr($logon, 0, - 3);
		} elseif ($cnt > 10) {
			$logon = substr($logon, 0, - 2);
		} elseif ($cnt > 1) {
			$logon = substr($logon, 0, - 1);
		} else {}
		$logon = $logon . $cnt;
		$cnt ++;
	}

	return $logon;
}

function generateCompanylogon($co_name) {
	$logonUsr = preg_replace('/\W/', '', $co_name);

	$logon = strtolower($logonUsr);
	$cnt = 1;
	while (! chkLogonNameIsUnique($logon)) {
		if ($cnt > 100) {
			$logon = substr($logon, 0, - 3);
		} elseif ($cnt > 10) {
			$logon = substr($logon, 0, - 2);
		} elseif ($cnt > 1) {
			$logon = substr($logon, 0, - 1);
		} else {}
		$logon = $logon . $cnt;
		$cnt ++;
	}

	return $logon;
}

function chkLogonNameIsUnique($login) {
	global $dbsite;

	$sqltext = "SELECT usr FROM pwd WHERE usr='" . $login . "'";
	// print $sqltext;

	$res = $dbsite->query($sqltext); // or die("Cant get Logon details");

	if (isset($res[0])) {
		return false;
	} else {
		return true;
	}
}

function getTotalInvoiceTotals($from = '', $to = '') {
	global $dbsite;

	$sqltext = "SELECT sum(quantity*price) as total
	FROM jobs,items,invoices
	WHERE jobs.itemsid=items.itemsid
	AND invoices.invoicesid=jobs.invoicesid";
	if ($from != '') {
		$sqltext .= " AND invoices.incept>=$from
		AND invoices.incept<=$to";
	}

	$res = $dbsite->query($sqltext);

	if (! empty($res)) {
		$r = $res[0];
		$ret = $r->total;
	} else {
		$ret = '';
	}
	return $ret;
}

function getNoOfInvoice($from = '', $to = '') {
	global $dbsite;

	$sqltext = "SELECT count(invoices.invoicesid) as total
	FROM jobs,items,invoices
	WHERE jobs.itemsid=items.itemsid
	AND invoices.invoicesid=jobs.invoicesid";
	if ($from != '') {
		$sqltext .= " AND invoices.incept>=$from
		AND invoices.incept<=$to";
	}

	$res = $dbsite->query($sqltext);

	if (! empty($res)) {
		$r = $res[0];
		$ret = $r->total;
	} else {
		$ret = '';
	}
	return $ret;
}

function getTotalCosts($from = '', $to = '', $expsid = '') {
	global $dbsite;

	$sqltext = "SELECT sum(price) as total FROM costs";
	if ($from != '') {
		$sqltext .= " WHERE costs.incept>=$from
		AND costs.incept<=$to";
	}
	if ($expsid != '') {
		$sqltext .= ' AND expsid=' . $expsid;
	}

	$res = $dbsite->query($sqltext);
	if (! empty($res)) {
		$r = $res[0];
		$ret = $r->total;
	} else {
		$ret = '';
	}
	return $ret;
}

function getExpensesName($expsid) {
	global $dbsys;

	$sqltext = "SELECT name FROM exps WHERE expsid=" . $expsid;
	$res = $dbsys->query($sqltext); // or die("Cant get exps name");

	if (! empty($res)) {
		$r = $res[0];
		$ret = $r->name;
	}

	return $ret;
}

function getExpensesIDs() {
	global $dbsys;

	$sqltext = "SELECT expsid FROM exps ORDER BY expsid";
	$res = $dbsys->query($sqltext); // or die("Cant get exps name");
	$ids = array();
	if (! empty($res)) {
		foreach ($res as $r) {
			$ids[] = $r->expsid;
		}
	}

	return $ids;
}

function addPasswd(){

}

function addCustomer($post) {
	global $dbsite;
	global $owner;
	$adminpw = generatePassword();
	$filestr = generatePassword(140);

	// Add to Address table
	$addsid = addDBAddress($_POST);

	// Add new customer
	$custNew = new Cust();
	$custNew->setCo_name($_POST['co_name']);
	$custNew->setFname($_POST['fname']);
	$custNew->setSname($_POST['sname']);
	$custNew->setContact($_POST['contact']);
	$custNew->setAddsid($addsid);
	$custNew->setInv_email($_POST['email']);
	$custNew->setColour(getRandonHTMLColour());
	$custNew->setFilestr($filestr);
	$custid = $custNew->insertIntoDB();

	// Add Admin contact
	$contactsNew = new Contacts();
	$contactsNew->setFname('Company');
	$contactsNew->setSname('Admin');
	$contactsNew->setCustid($custid);
	$contactsNew->setAddsid($addsid);
	$contactIDAdmin = $contactsNew->insertIntoDB();

	file_put_contents('/srv/ath/etc/custs', "ca.$custid\t$adminpw\n", FILE_APPEND | LOCK_EX);

	if(($_POST['fname']=='')&&($_POST['sname']='')){
		$_POST['fname']=$_POST['co_name'];
	}

	$logon = generateContactlogon($_POST['fname'], $_POST['sname']);
	// Add to password table
	$salt = generatePassword(6);
	$pwdNew = new Pwd();
	$pwdNew->setUsr($logon);
	$pwdNew->setCustid($custid);
	$pwdNew->setContactsid($contactIDAdmin);
	$pwdNew->setPw(crypt($adminpw,$salt));
	$pwdNew->setInit(encrypt($adminpw));
	$pwdNew->insertIntoDB();

	#echo 'ca' . $custid . ' '.$adminpw;

	// 	// Add to Address table
	// 	$addsid = addDBAddress($_POST);

	// 	$pw = generatePassword();
	// 	if (($_POST['fname'] == '') && ($_POST['sname'] == '')) {
	// 		$_POST['fname'] = $_POST['co_name'];
	// 	}
	// 	$logon = generateContactlogon($_POST['fname'], $_POST['sname']);

	// 	file_put_contents('/srv/ath/etc/custs', "$logon\t$pw\n", FILE_APPEND | LOCK_EX);

	// 	// Add Company Logon

	// 	// Add Cust contact
	// 	$contactsNew->setFname($_POST['fname']);
	// 	$contactsNew->setSname($_POST['sname']);
	// 	$contactsNew->setCustid($custid);
	// 	$contactsNew->setAddsid($addsid);
	// 	$contactID = $contactsNew->insertIntoDB();

	// 	// Add to password table
	// 	$salt = generatePassword(6);
	// 	$pwdNew = new Pwd();
	// 	$pwdNew->setUsr($logon);
	// 	$pwdNew->setContactsid($contactID);
	// 	$pwdNew->setPw(crypt($pw, $salt));
	// 	$pwdNew->setInit(encrypt($pw));
	// 	$pwdNew->insertIntoDB();
	$chatFile = '/srv/ath/var/data/'.$owner->filestr.'/chat/c'.$custid;

	file_put_contents($chatFile, "", FILE_APPEND | LOCK_EX);

	return $custid;
}

function addSupplier($post) {


	$adminpw = generatePassword();
	$filestr = generatePassword(140);

	// Add to Address table
	$addsid = addDBAddress($_POST);

	// Add new supplier
	$suppNew = new Supp();
	$suppNew->setFname($_POST['fname']);
	$suppNew->setSname($_POST['sname']);
	$suppNew->setCo_name($_POST['co_name']);
	$suppNew->setAddsid($addsid);
	$suppNew->setInv_email($_POST['email']);
	$suppid = $suppNew->insertIntoDB();

	file_put_contents('/srv/ath/etc/supps',"sa.$suppid\t$adminpw\n" , FILE_APPEND | LOCK_EX);

	// Add Admin contact
	$contactsNew = new Contacts();
	$contactsNew->setFname('Company');
	$contactsNew->setSname('Admin');
	$contactsNew->setSuppid($suppid);
	$contactsNew->setAddsid($addsid);
	$contactIDAdmin = $contactsNew->insertIntoDB();
	$salt = generatePassword(6);


	if(
			((!isset($_POST['fname']))||($_POST['fname']==''))
			&&
			((!isset($_POST['sname']))||($_POST['sname']=''))

	){
		$_POST['fname']=$_POST['co_name'];
	}

	$logon = generateContactlogon($_POST['fname'], $_POST['sname']);

	// Add to password table
	$salt = generatePassword(6);
	$pwdNew = new Pwd();
	$pwdNew->setUsr($logon);
	$pwdNew->setSuppid($suppid);
	$pwdNew->setContactsid($contactIDAdmin);
	$pwdNew->setPw(crypt($adminpw,$salt));
	$pwdNew->setInit(encrypt($adminpw));
	$pwdNew->insertIntoDB();


	// 	$pw = generatePassword();
	// 	if (($_POST['fname'] == '') && ($_POST['sname'] == '')) {
	// 		$_POST['fname'] = $_POST['co_name'];
	// 	}

	// 	$logon = generateContactlogon($_POST['fname'], $_POST['sname']);

	// 	file_put_contents('/srv/ath/etc/supps',"$logon\t$pw\n" , FILE_APPEND | LOCK_EX);
	// 	// Add Company Logon
	// 	// Add to Address table
	// 	$addsid = addDBAddress($_POST);
	// 	// Add Supplier contact
	// 	$contactsNew->setFname($_POST['fname']);
	// 	$contactsNew->setSname($_POST['sname']);
	// 	$contactsNew->setSuppid($suppid);
	// 	$contactsNew->setAddsid($addsid);
	// 	$contactID = $contactsNew->insertIntoDB();
	// 	$salt = generatePassword(6);

	// 	// Add to password table
	// 	$salt = generatePassword(6);
	// 	$pwdNew = new Pwd();
	// 	$pwdNew->setUsr($logon);
	// 	$pwdNew->setContactsid($contactID);
	// 	$pwdNew->setPw(crypt($pw,$salt));
	// 	$pwdNew->setInit(encrypt($pw));
	// 	$pwdNew->insertIntoDB();

	return $suppid;

}

function updateIitems($invoicesid, $clear = 0) {
	global $dbsite;

	if ($clear) {
		// Clear iitems table of jobs with this invoice no
		$query = "DELETE FROM iitems
		WHERE invoicesid=$invoicesid
		AND iitemsid>0";
		$resJobs = $dbsite->db->query($query);
	}
	$query = "SELECT items.itemsid, items.content,items.price,
	jobs.quantity,jobs.jobsid
	FROM items,jobs
	WHERE jobs.itemsid=items.itemsid
	AND jobs.invoicesid=$invoicesid
	ORDER BY items.incept DESC";

	$resJobs = $dbsite->query($query); // or die("Cant get Completed Items");

	if (! empty($resJobs)) {
		foreach ($resJobs as $rJob) {
			$iitemsNew = new Iitems();
			$iitemsNew->setInvoicesid($invoicesid);
			$iitemsNew->setQuantity($rJob->quantity);
			$iitemsNew->setJobsid($rJob->jobsid);
			$iitemsNew->setContent($rJob->content);
			$iitemsNew->setPrice($rJob->price);
			$iitemsNew->insertIntoDB();
		}
	}
	return count($resJobs);
}
