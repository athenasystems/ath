<?php

$sitesid = 100 ;

include "/srv/ath/src/php/db.php";
include "/srv/ath/src/php/common.php";

# Get Site DB Handle
$dbsite = sitedbconnect($sitesid);

$sqltext = "SELECT * FROM cust,adds where cust.addsid=adds.addsid";
$res = $dbsite->query($sqltext); # or die("Cant get ");

	foreach($res as $r) {


		$custid = $r->custid;

		$pw = generatePassword();

		$_POST['add1'] = $r->add1;
		$_POST['add2'] = $r->add2;
		$_POST['add3'] = $r->add3;
		$_POST['city'] = $r->city;
		$_POST['county'] = $r->county;
		$_POST['country'] = $r->country;
		$_POST['postcode'] = $r->postcode;
		$_POST['email'] = $r->email;
		$_POST['tel'] = $r->tel;

		echo 'Address: ' . join(', ', $_POST) . "\n";

		# Add to Address table
		$addsid = addDBAddress($_POST);

		$logon = 'CA'.$custid;

		# Add Admin contact
		$dbvaluesContact['custid'] = $custid;
		$dbvaluesContact['fname'] = 'System';
		$dbvaluesContact['sname'] = 'Administrator';
		$dbvaluesContact['logon'] = $logon;
		$dbvaluesContact['init_pw'] = $pw;
		$dbvaluesContact['addsid'] = $addsid;

		echo 'Contact : ' . join(', ', $dbvaluesContact) . "\n";

		$result = db_add("contacts", $dbvaluesContact);



		# Add to password table
		$dbvaluesPwd['contactsid'] = $result['id'];
		$dbvaluesPwd['custid'] = $custid;
		$dbvaluesPwd['usr'] = $logon;
		$dbvaluesPwd['pw'] = crypt($pw);
		$dbvaluesPwd['seclev'] = 1;

		echo 'Password : ' . join(', ', $dbvaluesPwd) . "\n";

		$resultPwd = db_add("pwd", $dbvaluesPwd);

}


?>