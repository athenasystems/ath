<?php
function sendGmailEmail($name,$email,$esubject,$htmlBody,$docName='',$docTitle='',$kind='owner'){

	global $dbsite;
	global $sitesid;

	$mailNew = new Mail();
	$mailNew->setAddto($email);
	$mailNew->setAddname($name);
	$mailNew->setSubject(addslashes($esubject));
	$mailNew->setBody(addslashes($htmlBody));
	$mailNew->setIncept(time());
	$mailNew->setDocname($docName);
	$mailNew->setDoctitle($docTitle);
	$mailNew->setKind($kind);
	$mailNew->insertIntoDB();

	$email_done = "Sending email to $name - $email<br>" ;

	return $email_done;

}

function sendResetMail($ret,$sitesid){

    $t = time() . '|' . $ret['id'] . '|' . $ret['t'];
    $token = base64_encode(encrypt($t));
    // Send a mail to new owner

    $newsite = new Sites();
    // Load DB data into object
    $newsite->setSitesid($sitesid);
    $newsite->loadSites();
    $subdomain = $newsite->getSubdom();

    $htmlBody = <<<EOF

Athena Password reset<br><br>

Follow the link below to reset your password:-<br><br>

<a href="https://$sitesid.athena.systems/r?r=$token">
https://$sitesid.athena.systems/r?r=$token
</a><br><br>

Your Username: {$ret['usr']}<br>

Pete

EOF;

    sendGmailEmail($newSite['co_name'], $newSite['email'], 'Athena Account Reset', $htmlBody);

}
