<?php

include "/srv/ath/src/php/adm/common.php";

$sid =$argv[1];

$type =$argv[2];

$dbsite = sitedbconnect($sid);

$url = "$staff_url/pass.php";
$id = 1000;
if($type=='staff'){
	$user = getStaffLogin($id);
}elseif($type == 'cust'){
	$user = getCustAdminLogin($id);
}elseif($type == 'supp'){
	$user = getSuppAdminLogin($id);
}
$pw=decrypt($user['pw']);

print $pw;
exit;

?>
