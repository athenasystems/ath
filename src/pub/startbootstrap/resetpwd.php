<?php
$section = "staff";
$page = "Staff";

include "/srv/ath/src/php/www/common.php";

$dbsite = sitedbconnect(SITESID);

$errors = array();
$pwhelp = '';

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	$required = array("npw1","npw2","usr");

	$errors = check_required($required, $_POST);

	if (empty($errors)) {

		if ((! isset($_POST['npw1'])) || (! isset($_POST['npw2']))) {
			$pwhelp = 'Please type your new password twice';
			$errors[] = 'npw1';
		} elseif (strlen($_POST['npw1']) < 7) {
			$pwhelp = 'New password is too short';
			$errors[] = 'npw1';
		} elseif (! chkLowercase($_POST['npw1'])) {
			$pwhelp = 'No lower case letters in password';
			$errors[] = 'npw1';
		} elseif (! chkUppercase($_POST['npw1'])) {
			$pwhelp = 'No upper case letters in password';
			$errors[] = 'npw1';
		} elseif (! chkDigit($_POST['npw1'])) {
			$pwhelp = 'No numbers in password';
			$errors[] = 'npw1';
		} elseif ($_POST['npw1'] != $_POST['npw2']) {
			$pwhelp = 'New passwords are not the same';
			$errors[] = 'npw1';
		}

		$pwdUpdate = new Pwd();
		$pwdUpdate->setUsr($_POST['usr']);
		$pwdUpdate->setPw(crypt($_POST['npw1']));
		$pwdUpdate->setInit(encrypt($_POST['npw1']));
		$pwdUpdate->updateDB();

		// $logresult = logEvent(15,$logContent);
		$done = 1;
	}
}
$token = $_GET['r'];

$tok = decrypt(base64_decode($token));

$t = preg_split('/\|/', $tok);

$id = $t[1];
$type =  $t[2];

if($type=='staff'){
	$sqltext = "SELECT usr,pw from pwd where staffid=" . $id;
	$res = $dbsite->query($sqltext);
}elseif($type=='cust'){
	$sqltext = "SELECT usr,pw from pwd where custid=" . $id;
	$res = $dbsite->query($sqltext);
}elseif($type=='supp'){
	$sqltext = "SELECT usr,pw from pwd where suppid=" . $id;
	$res = $dbsite->query($sqltext);
}else{
	exit;
}

$r = $res[0];

$pagetitle = "staff";
$pagescript = array();
$pagestyle = array();

include "head.php";
?>

<h2>Password Reset</h2>
<?php
if ((isset($done)) && ($done)) {

	?>
<div class="alert alert-success" role="alert">
	<strong>Success</strong> <br> The password has been changed
</div>
<?php

} else {
	?>

<h4>Password must contain at least ...</h4>
<ul style="margin-left: 40px;">
	<li>A minimum of 7 Characters</li>
	<li style="list-style: disc;">One lower case letter</li>
	<li style="list-style: disc;">One upper case letter</li>
	<li style="list-style: disc;">One number</li>
</ul>

<form
	action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $_GET['id']?>&amp;go=y&r=<?php echo $_GET['r']?>"
	enctype="multipart/form-data" method="post">
	<?php echo form_fail(); ?>

	<fieldset class="form-group">

		<?php
		html_hidden('usr', $r->usr);

		if ($pwhelp != '') {
			echo 'There is a problem with the new password: ' . $pwhelp;
		}

		html_pw("New Password", "npw1", $_POST['npw1']);
		html_pw("Repeat New Password", "npw2", $_POST['npw2']);

		?>

	</fieldset>

	<fieldset class="form-group">
		<?php
		html_button("Save changes");
		?>


	</fieldset>

</form>

<?php
}

include "foot.php";
?>
