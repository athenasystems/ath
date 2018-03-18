<?php
include "/srv/ath/src/php/db.php";
include "/srv/ath/src/php/common.php";
include "/srv/ath/src/php/athena_mail.php";

// Get the New Signups data
$sqltext = "SELECT * FROM athcore.signups WHERE status='new' LIMIT 1";
$res = $dbsys->query($sqltext);# or die("Cant get new sites");
$logon='';
if (! empty($res)) {
	$r = $res[0];

	$newSite['co_name'] = $r->co_name;
	$newSite['email'] = $r->email;
	$newSite['tel'] = $r->tel;
	$newSite['brand'] = $r->brand;
	$newSite['fname'] = $r->fname;
	$newSite['sname'] = $r->sname;
	$signupsid = $r->signupsid;

	$errors = array();

	$required = array(
			"co_name",
			"email",
			"tel"
	);
	$errors = check_required($required, $newSite);

	if (empty($errors)) {

		$adminpw = generatePassword(16);
		$pw = generatePassword(10);
		file_put_contents('/srv/ath/etc/admins',$adminpw . "\n" . $pw ."\n\n" , FILE_APPEND | LOCK_EX);
		$incept = time();

		// Add to site table
		$sitesNew = new Sites();
		$sitesNew->setCo_name($newSite['co_name']);
		$sitesNew->setEmail($newSite['email']);
		$sitesNew->setInv_email($newSite['email']);
		$sitesNew->setColour(getRandonHTMLColour());
		$sitesNew->setIncept($incept);
		$sitesNew->setStatus('new');
		$sitesNew->setBrand($newSite['brand']);
		$sitesNew->setFilestr(generateFileStr());
		$sitesNew->setEoyday(5);
		$sitesNew->setEoymonth(4);
		$sitesid = $sitesNew->insertIntoDB();

		// Make temporary Domain Names
		$sitesUpdate = new Sites();
		#$sitesUpdate->setSitesid($sitesid);
		$sitesUpdate->setSubdom( $sitesid);
		$sitesUpdate->setDomain( $sitesid . '.athena.systems');
		$sitesUpdate->updateDB();

		// Initialize athdb$sitesid
		passthru("perl /srv/ath/src/perl/cron/build.athena.site.db.pl");

		// Get Site DB Handle
		$dbsite = sitedbconnect($sitesid);

		// Add to Address table
		$addsNew = new Adds();
		$addsNew->setTel($newSite['tel']);
		$addsNew->setEmail($newSite['email']);
		$addsid = $addsNew->insertIntoDB();

		$sitesUpdate = new Sites();
		$sitesUpdate->setSitesid($sitesid);
		$sitesUpdate->setAddsid($addsid);
		$sitesUpdate->updateDB();


		// Add Admin

		// Add Admin to Address table
		$addsNew = new Adds();
		$addsNew->setEmail('support@athena.systems');
		$addsidAdmin = $addsNew->insertIntoDB();
		// Add Admin to Staff table
		$staffNew = new Staff();
		$staffNew->setFname('Athena');
		$staffNew->setSname('Admin');
		$staffNew->setAddsid($addsidAdmin);
		$staffNew->setStatus('active');
		$staffNew->setLevel(1);
		$staffid = $staffNew->insertIntoDB();
		// Add Admin to Pwd table
		$salt = generatePassword(6);
		$pwdNew = new Pwd();
		$pwdNew->setUsr('sysadmin');
		$pwdNew->setStaffid($staffid);
		$pwdNew->setSeclev(1);
		$pwdNew->setPw(crypt($adminpw,$salt));
		$pwdNew->setInit(encrypt($adminpw));
		$pwdNew->insertIntoDB();

		// Add User

		$logon = strtolower (preg_replace('/\W/', '', $newSite['fname'] ));

		// Add User to Address table
		$addsNew = new Adds();
		$addsNew->setEmail($newSite['email']);
		$addsidUser = $addsNew->insertIntoDB();
		// Add User to Staff table
		$staffNew = new Staff();
		$staffNew->setFname($newSite['fname']);
		$staffNew->setSname($newSite['sname']);
		$staffNew->setAddsid($addsidUser);
		$staffNew->setStatus('active');
		$staffNew->setLevel(1);
		$staffid = $staffNew->insertIntoDB();
		// Add User to Pwd table
		$salt = generatePassword(6);
		$pwdNew = new Pwd();
		$pwdNew->setUsr($logon);
		$pwdNew->setStaffid($staffid);
		$pwdNew->setSeclev(1);
		$pwdNew->setPw(crypt($pw,$salt));
		$pwdNew->setInit(encrypt($pw));
		$pwdNew->insertIntoDB();

		// Update Signups table to mark as added
		$signupsUpdate = new Signups();

		$signupsUpdate->setSignupsid($signupsid);
		$signupsUpdate->setStatus('active');
		$signupsUpdate->updateDB();

		// Build Web Site + Set Up Apache
		passthru("perl /srv/ath/src/perl/cron/build.web.site.pl $sitesid");

		// Send a mail to new owner

		$newsite = new Sites();
		// Load DB data into object
		$newsite->setSitesid($sitesid);
		$newsite->loadSites();
		$subdomain = $newsite->getSubdom();

		$htmlBody = <<<EOF

		Hi {$newSite['fname']},<br><br>

Welcome to Athena Online<br><br>

You can log in at:-<br><br>

<a href="http://$subdomain.athena.systems/login">
http://$subdomain.athena.systems/login
</a><br><br>

User: $logon<br>
Pass: $pw<br><br>

We hope it helps you do, whatever it is you do.<br><br>

Athena

EOF;

		sendGmailEmail($newSite['co_name'], $newSite['email'], 'Welcome to Athena Online', $htmlBody,'','','athena');

		exit();
	} else {
		echo "There were errors\n";
	}
} else {
	// echo "There were no new\n";
	exit();
}

?>
