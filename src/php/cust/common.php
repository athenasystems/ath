<?php

include "/srv/ath/src/php/common.php";
include "/srv/ath/src/php/db.php";
include "/srv/ath/src/php/cust/functions.php";
include "/srv/ath/src/php/cust/blocks.php";
include "/srv/ath/src/php/cust/functions_form.php";

$loggedin = chkCookie('contacts');
if
(		(!isset($loggedin['contactsid']))||
		(!$loggedin['contactsid']>0)||
		(!isset($loggedin['sitesid']))||
		(!$loggedin['sitesid']>0)
)
{
	failOut();
}

# Get the site details
$sitesid = $loggedin['sitesid'];
# Get Site DB Handle
$dbsite = sitedbconnect($sitesid);

# Get the Contact details
$contactsID = $loggedin['contactsid'];
$contactDets = getContactDets($contactsID);

$siteMods = getSiteMods();

# Get the customer details
$sqltext = "SELECT custid FROM contacts WHERE contactsid='" . $contactsID . "'";
#print $sqltext;exit;
$res = $dbsite->query($sqltext); # or die("Cant get custid");
$r = $res[0];
$custID = $r->custid;

$custDets = getCustDets($custID);

#$custDets = getCustDets($custID);

# Get the site details
$owner = siteDets();

$dataDir = '/srv/ath/var/data/'. $owner->filestr;


$ppage = 4;

function getCustDets($custID){
	global $dbsite;

	$sqltext = "SELECT cust.custid, cust.co_name, cust.contact, cust.inv_contact, cust.colour ,cust.filestr ,
	adds.add1, adds.add2, adds.add3, adds.city, adds.county, adds.country,
	adds.postcode, adds.tel, adds.fax, adds.email, adds.web, cust.inv_email
	FROM cust,adds
	WHERE cust.addsid=adds.addsid
	AND cust.custid=" .  $custID;
	#print $sqltext;
	$res = $dbsite->query($sqltext); # or die("Cant get cust id");

	$r = $res[0];

	return $r;
}
