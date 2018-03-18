<?php
include "/srv/ath/src/php/common.php";
include '/srv/ath/src/php/db.php';
include "/srv/ath/src/php/mng/functions.php";
include "/srv/ath/src/php/mng/blocks.php";
include "/srv/ath/src/php/mng/functions_form.php";

$loggedin = chkCookie('staff');
if
(		(!isset($loggedin['staffid']))||
		(!$loggedin['staffid']>0)||
		(!isset($loggedin['sitesid']))||
		(!$loggedin['sitesid']>0)
		)
{
	failOut('failed_staff_cookie');
}

$staffid = $loggedin['staffid'];
$sitesid = $loggedin['sitesid'];

# Get Site DB Handle
$dbsite = sitedbconnect($sitesid);

# Get Staff details
$dets = getStaffDets($staffid);
$fname = $dets->fname;
$sname = $dets->sname;
$seclevel = $dets->level;

# Get Site Owner Details
$owner = siteDets();

# Get Live Modules for this site
$siteMods = getSiteMods();

# Set Data folder
$dataDir = '/srv/ath/var/data/'.$sitesid;


$vat_rate1 = 0.175;
$vat_rate2 = 0.2;

$holiday['limit'] = 35; # 8 hour days
$holiday['year_start_day'] = 1; # day/month
$holiday['year_start_month'] = 1; # day/month

$ppage = 16; # Use powers of 2 only

$shift['start_hour'] = 9;
$shift['start_min'] = '00';

$shift['finish_hour'] = 17;
$shift['finish_min'] = '30';

$lunch['start_hour'] = 13;
$lunch['start_min'] = '00';

$lunch['finish_hour'] = 14;
$lunch['finish_min'] = '00';
