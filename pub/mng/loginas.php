<?php

include "/srv/ath/src/php/mng/common.php";
?>
<!DOCTYPE html>
<html>
<title></title>
<body onload='document.forms[0].submit()'>
	<?php

	#include "/srv/ath/src/php/db.php";

	$sid=$sitesid;

	# Get Site DB Handle
	$dbsite = sitedbconnect($sid);

	$id='';

	if((isset($_GET['stid'])) && ($_GET['stid']!='')){

		$url = "$staff_url/pass.php";
		$id = $_GET['stid'];

		$user = getStaffLogin($id);

		$usr_id = $user['staffid'];
		$usr=$user['usr'];
		$pw=decrypt($user['pw']);


	}
	elseif((isset($_GET['cid'])) && ($_GET['cid']!='')){

		$url = "$cust_url/pass.php";
		$id = $_GET['cid'];

		$user = getCustAdminLogin($id);

		$usr_id = $user['contactsid'];
		$usr=$user['usr'];
		$pw=decrypt($user['pw']);

	}

	elseif((isset($_GET['sid'])) && ($_GET['sid']!='')){

		$url = "$supp_url/pass.php";
		$id = $_GET['sid'];

		$user = getSuppAdminLogin($id);

		$usr_id = $user['contactsid'];
		$usr=$user['usr'];
		$pw=decrypt($user['pw']);


	}


	$url = "https://$sid.athena.systems/bin/pass.pl";

	#$int_cookie = $sid. '.' .$id.  '.' .  $usr_id  .'.' .$usr . '.' . $pw. '.ATHENASECCHK';
	#print $sid. '.' .$usr . '.' . $pw;	exit;
	#$pt = base64_encode($int_cookie);
	?>
	<form action="<?php echo $url; ?>" method="post">

		<input type="hidden" name="sid" value="<?php echo $sid; ?>"> <input
			type="hidden" name="pw" value="<?php echo $pw; ?>"> <input
			type="hidden" name="nick" value="<?php echo $usr; ?>">

		<?php if((isset($_GET['passurl']))&&($_GET['passurl']!='')){
			?>
		<input type="hidden" name="purl"
			value="<?php echo $_GET['passurl']; ?>">
		<?php
		}

		if((isset($_GET['as_staff'])) && ($_GET['as_staff']!='')){
			?>
		<input type="hidden" name="as_staff" value="1">
		<?php
		}
		?>


	</form>
</body>
</html>
