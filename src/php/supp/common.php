<?php

include "/srv/ath/src/php/common.php";
include "/srv/ath/src/php/db.php";
include "/srv/ath/src/php/supp/functions.php";
include "/srv/ath/src/php/supp/blocks.php";
include "/srv/ath/src/php/supp/functions_form.php";

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

# Get the suppliers details
$sqltext = "SELECT suppid FROM contacts WHERE contactsid=" . $contactsID ;
#print $sqltext;exit;
$res = $dbsite->query($sqltext); # or die("Cant get suppid");
$r = $res[0];
$suppID = $r->suppid;
#print $contactsID;
#print $suppID;
$suppDets = getSuppDets($suppID);

$dataDir = '/srv/ath/var/data/'.$sitesid;

# Get Site Owner Details
$owner = siteDets();

$ppage = 4;


?>