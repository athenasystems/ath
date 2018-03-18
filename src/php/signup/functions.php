<?php

function getUserByLogin($usr) {
	global $dbsite;
	$sqltext = "SELECT staffid,custid,suppid,usr from pwd WHERE
	usr='" . $usr . "'";
	$res = $dbsite->query($sqltext); // or die("Cant get itemsid jobno");
	if (! empty($res)) {
		$r = $res[0];
		if ((isset($r->staffid)) && ($r->staffid > 0)) {
			$ret['t'] = 'staff';
			$ret['id'] = $r->staffid;
		} elseif ((isset($r->custid)) && ($r->custid > 0)) {
			$ret['t'] = 'cust';
			$ret['id'] = $r->custid;
		} elseif ((isset($r->suppid)) && ($r->suppid > 0)) {
			$ret['t'] = 'supp';
			$ret['id'] = $r->suppid;
		} else {
			return 0;
		}

		return $ret;
	} else {
		return 0;
	}
}

function getUserByEmail($email) {
	global $dbsite;

	$login = getStaffByEmail($email);
	if (isset($login['id'])) {
		$ret['t'] = 'staff';
		$ret['id'] = $login['id'];
		$ret['usr'] = $login['usr'];
		return $ret;
	} else {
		$login = getCustByEmail($email);
		if (isset($login['id'])) {
			$ret['t'] = 'cust';
			$ret['id'] = $login['id'];
			$ret['usr'] = $login['usr'];
			return $ret;
		} else {
			$login = getSuppByEmail($email);
			if (isset($login['id'])) {
				$ret['t'] = 'supp';
				$ret['id'] = $login['id'];
				$ret['usr'] = $login['usr'];
				return $ret;
			}
		}
	}
	return 0;
}

function getStaffByEmail($email) {
	global $dbsite;
	$sqltext = "SELECT staff.staffid,pwd.usr from staff,adds,pwd WHERE
	staff.staffid=adds.staffid AND
	staff.staffid=pwd.staffid AND
	adds.email='" . $email . "'";
	$res = $dbsite->query($sqltext); // or die("Cant get itemsid jobno");
	if (! empty($res)) {
		$r = $res[0];
		$ret['id'] = $r->staffid;
		$ret['usr'] = $r->usr;
		return $ret;
	} else {
		return 0;
	}
}

function getCustByEmail($email) {
	global $dbsite;
	$sqltext = "SELECT cust.custid,pwd.usr from cust,adds WHERE
	cust.custid=adds.custid AND
	staff.staffid=pwd.staffid AND
	adds.email='" . $email . "'";
	$res = $dbsite->query($sqltext); // or die("Cant get itemsid jobno");
	if (! empty($res)) {
		$r = $res[0];
		$ret['id'] = $r->custid;
		$ret['usr'] = $r->usr;
		return $ret;
	} else {
		return 0;
	}
}

function getSuppByEmail($email) {
	global $dbsite;
	$sqltext = "SELECT supp.suppid,pwd.usr from supp,adds WHERE
	supp.suppid=adds.suppid AND
	staff.staffid=pwd.staffid AND
	adds.email='" . $email . "'";
	$res = $dbsite->query($sqltext); // or die("Cant get itemsid jobno");
	if (! empty($res)) {
		$r = $res[0];
		$ret['id'] = $r->suppid;
		$ret['usr'] = $r->usr;
		return $ret;
	} else {
		return 0;
	}
}

