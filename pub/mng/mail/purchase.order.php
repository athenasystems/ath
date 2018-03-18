<?php
include "/srv/ath/src/php/mng/common.php";
include ("/srv/ath/src/php/athena_mail.php");
include ("/srv/ath/src/php/mng/functions_email.php");
include ("/srv/ath/pub/mng/tmpl/header_no_nav.php");

$htmlBody = getPurchaseOrderMailBody($_GET['id']);

$sqltext = "SELECT supp.suppid,supp.co_name,supp.email as coemail
FROM supp,orders
WHERE orders.suppid=supp.suppid
AND ordersid='". $_GET['id'] ."' LIMIT 1";

#print $sqltext;

$res = $dbsite->query($sqltext); # or die("Cant get supplier email");
if (! empty($res)) {
	$r = $res[0];
}else{
	return 0;
}

$suppid = $r->suppid;
$coemail = $r->coemail;

$name = $r->co_name;

$email = $r->coemail;

# For Testing
if( isDev()){
	$email="admin@athena.systems"; // Recipients email ID
	$name="Athena Systems"; // Recipient's name
}


if( (!isset($email)) || ($email=='') ){
	echo "Mailer Error: Customer has No Email address on the system";
	exit;
}



$esubject = "Purchase Order from ".$owner->co_name;

sendGmailEmail($name,$email,$esubject ,$htmlBody);


$logContent= "QuoteID: " . $_GET['id'] . " sent to $name - $email";
$logresult = logEvent(2,$logContent);



include "/srv/ath/pub/mng/tmpl/footer.php";


?>
