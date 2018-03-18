<?php
include '/srv/ath/src/php/db.php';
include '/srv/ath/src/php/common.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require '/srv/ath/src/pub/phpmailer/src/Exception.php';
require '/srv/ath/src/pub/phpmailer/src/PHPMailer.php';
require '/srv/ath/src/pub/phpmailer/src/SMTP.php';



$sids = getSiteIDs();

foreach ($sids as $sitesid) {

	// Get Site DB Handle
	$dbsite = sitedbconnect($sitesid);
	// print $sitesid ."\n";

	$ret = sendDBEmail();
}

exit();

// print $ret . "\n";

// This function picks up an unsent mail from the Database and sends it.
// This is desgined to be run from CRON
// Returns:
// 1 on No mail,
// 2 on Sent a Mail Successfully
// 3 on failed sending mail, i.e. there was an error
//
function sendDBEmail() {
	global $dbsys;
	global $dbsite;
	global $sitesid;
	global $athenaEmailPwd;
	global $athenaEmail;

print $athenaEmail . "\n" . $athenaEmailPwd . "\n";

#	require_once ("/srv/ath/src/pub/phpmailer/class.phpmailer.php");
	$mail = new PHPMailer;
	$mail->isSMTP(); // send via SMTP
	$mail->SMTPDebug = 1;
	$mail->Port = 587;
	$mail->Host = "smtp.gmail.com";
	$mail->SMTPSecure = "tls";
	$mail->SMTPAuth = true; // turn on SMTP authentication
	$mail->Username = $athenaEmail; // SMTP username
	$mail->Password = $athenaEmailPwd; // SMTP password

	$mail->setFrom($athenaEmail, 'Athena Systems No Reply');

	$sqltext = "SELECT * FROM mail WHERE sent=0 AND body<>'' LIMIT 1;";
	// print $sqltext. "\n";
	$res = $dbsite->query($sqltext); // or die("Cant get items to mail");

	if (! empty($res)) {
		$r = $res[0];

		$mailid = $r->mailid;
		$name = stripslashes($r->addname);
		if($sitesid<103){
			$email = 'petelock@gmail.com';
		}else{
			$email = stripslashes($r->addto);
		}
		$esubject = stripslashes($r->subject);
		$htmlBody = stripcslashes($r->body);
		$docName = $r->docname;
		$docTitle = $r->doctitle;
		$kind = $r->kind;

print $kind . "\n";
#return;


		$owner = siteDets();

		$company_email = $owner->email; // Reply to this email ID

#		if($kind == 'athena'){
#			$mail->From = $athenaEmail;
#			$mail->FromName = 'Athena';
#		}else{
#			$mail->From = $company_email;
#			$mail->FromName = $owner->co_name;
#		}
		$mail->addAddress($email, $name);
		$mail->addReplyTo($company_email, $owner->co_name);
		$mail->WordWrap = 50; // set word wrap
		$mail->isHTML(true); // send as HTML
		$mail->Subject = $esubject;
		$mail->Body = $htmlBody; // HTML Body
		$htmlTextBody = 'Please see the HTML version of this mail to read the contents.';
		$mail->AltBody = $htmlTextBody; // Text Body

		// PDF Attachment
		if (file_exists($docName)) {
			$mail->addAttachment($docName, $docTitle); // attachment
		}

		$email_done = '';
		if (! $mail->send()) {
			$email_done = "Mailer Error: " . $mail->ErrorInfo;
		} else {
			$now = time();
			$sqltext = "UPDATE mail SET sent=$now WHERE mailid=$mailid;";
			// print $sqltext. "\n";
			$dbsite->db->query($sqltext); // or die("Cant add to mail");
		}

		return 2;
	} else {
		// No Mail
		return 1;
	}
}
