<?php
#
include '/srv/ath/src/php/common.php';
include "/srv/ath/src/php/db.php";
?>
<!DOCTYPE html>
<html>
<title></title>
<body onload='document.forms[0].submit()'>
	<?php

	$id='';

	if((isset($_GET['sid'])) && ($_GET['sid']!='')){

		# Get Site DB Handle
		$sitesid = $_GET['sid'];
		$dbsite = sitedbconnect($_GET['sid']);
		$url = "https://$sitesid.athena.systems/bin/pass.pl";
		$id = $_GET['sid'];

		$user = getIntAdminLogin($id);

		$sid = $_GET['sid'];
		$staffid = $user['staffid'];
		$usr=$user['usr'];
		$pw=decrypt($user['pw']);

	}

	$int_cookie = $sid.  '.' .  $staffid  .'.' .$usr . '.' . $pw. '.ATHENASECCHK';
	#print $url . ' ' . $int_cookie;	exit;
	$thing = base64_encode($int_cookie);

	?>

	<form action="<?php echo $url; ?>" method="post">

		<input type="hidden" name="sid" value="<?php echo $sitesid; ?>">
		<input type="hidden" name="pw" value="<?php echo $pw; ?>">
		<input type="hidden" name="nick" value="<?php echo $usr; ?>">
	</form>
</body>
</html>
