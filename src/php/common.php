<?php

include "/srv/ath/src/php/lib/AthenaCore.php";
include "/srv/ath/src/php/lib/AthenaSite.php";
include '/srv/ath/src/php/common_form.php';
include '/srv/ath/src/php/common_sec.php';
include '/srv/ath/src/php/common_func.php';
 if(isDev()){
// 	error_reporting(E_ALL ^ E_NOTICE);
// 	error_reporting(E_ALL);
// 	ini_set("display_errors", 1);
 }

$athenaEmail = 'athena.systems.noreply@gmail.com';
$athenaEmailPwd = 'hyjuyET863.76-ui';

$domain = 'athena.systems';

$www_url = 'https://' . $domain;
$int_url = 'https://mng.' . $domain;
$staff_url = 'https://staff.' . $domain;
$cust_url = 'https://customers.' . $domain;
$supp_url = 'https://suppliers.' . $domain;
$login_url = 'https://login.' . $domain;
