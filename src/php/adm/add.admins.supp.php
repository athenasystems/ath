<?php

$sitesid = 100 ;

include "/srv/ath/src/php/db.php";
include "/srv/ath/src/php/common.php";

# Get Site DB Handle
$dbsite = sitedbconnect($sitesid);

$sqltext = "SELECT * FROM supp,adds where supp.addsid=adds.addsid";
$res = $dbsite->query($sqltext); # or die("Cant get Suppliers");

	foreach($res as $r) {


		$suppid = $r->suppid;

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

		$logon = 'SA'.$suppid;

		# Add Admin contact
		$dbvaluesContact['suppid'] = $suppid;
		$dbvaluesContact['fname'] = 'System';
		$dbvaluesContact['sname'] = 'Administrator';
		$dbvaluesContact['logon'] = $logon;
		$dbvaluesContact['init_pw'] = $pw;
		$dbvaluesContact['addsid'] = $addsid;

		echo 'Contact : ' . join(', ', $dbvaluesContact) . "\n";

		$result = db_add("contacts", $dbvaluesContact);



		# Add to password table
		$dbvaluesPwd['contactsid'] = $result['id'];
		$dbvaluesPwd['suppid'] = $suppid;
		$dbvaluesPwd['usr'] = $logon;
		$dbvaluesPwd['pw'] = crypt($pw);
		$dbvaluesPwd['suppid'] = $result['id'];

		echo 'Password : ' . join(', ', $dbvaluesPwd) . "\n";

		$resultPwd = db_add("pwd", $dbvaluesPwd);

}


?>