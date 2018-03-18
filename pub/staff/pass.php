<?php
# THIS IS STAFF
include '/srv/ath/src/php/db.php';
include '/srv/ath/src/php/common.php';
include "/srv/ath/src/php/staff/functions.php";

if(isset($_GET['pg'])&&($_GET['pg'] == 'logout')){
	#logEvent("30",$loggedin);
	$sid=$_GET['s'];
	killCookie();
	header("Location: https://$sid.$domain/login");
	exit;
}

$t = (isset($_POST['t'])) ? $_POST['t'] : '0';

$token = decrypt(base64_decode($t));
$parts = preg_split('/\t/', $token);
$user =$parts[0];
$pw =$parts[1];
$sid =$parts[2];

$custid = 0;

$staffid = pass($sid,$user,$pw,'staff');


if($staffid){

	dropCookie($sid,$staffid,$user);

	$dbsite = sitedbconnect($sid);

	logEvent("26","Staff Site Login Username:".$user);
	
	# Update DB
	$pwdUpdate = new Pwd();	
	$pwdUpdate->setUsr($user);
	$pwdUpdate->setLastlogin(time());	
	$pwdUpdate->updateDB();

	$url = ((isset($_POST['passurl']))&&($_POST['passurl']!='')) ? base64_decode($_POST['passurl']) : 'index.php';

	$fl = (isset($_POST['fl'])) ? $_POST['fl'] : '0';
	if ($fl) {
	    $url .= '?fl=1';
	}
	
	header("Location: $url");

}else{
	//print "got here ";
	//exit;
	killCookie();

	$dbsite = sitedbconnect($sid);

	logEvent("30","Failed Login Username:".$user);

	failOut('NoStaffID');

}

?>
