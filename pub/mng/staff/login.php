<?php
$section = "staff";
$page = "Staff";

include "/srv/ath/src/php/mng/common.php";

// if (($seclevel>3) && ($_GET['id']!=$staffid)){
// header("Location: /staff/");
// exit;
// }

if (($seclevel > 1) && ($staffid < 2)) {
    header("Location: /staff/");
    exit();
}
$sqltext = "SELECT usr,pw from pwd where staffid=" . $_GET['id'];
// print "<br/>$sqltext";
$res = $dbsite->query($sqltext); # or die("Cant get staff");
$r = $res[0];

$errors = array();
$pwhelp = '';

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

    if ($seclevel > 1) {
        $required = array(
            "opw",
            "npw1",
            "npw2",
            "usr"
        );
        $errors = check_required($required, $_POST);

        if ((! isset($_POST['opw'])) || (strlen($_POST['opw']) < 7) || (crypt($_POST['opw'], $r->pw) != $r->pw)) {
            $oldpwwrong = 'Old password is wrong';
            $errors[] = 'opw';
        }
    } else {
        $required = array(
            "npw1",
            "npw2",
            "usr"
        );
        $errors = check_required($required, $_POST);
    }

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

    $stfid = $_POST['stfid'];

    if (empty($errors)) {

        $pwdUpdate = new Pwd();
        $pwdUpdate->setUsr($_POST['usr']);
        $pwdUpdate->setPw(crypt($_POST['npw1']));
		$pwdUpdate->setInit(encrypt($_POST['npw1']));
        $pwdUpdate->updateDB();

        // $logresult = logEvent(15,$logContent);
        $done = 1;
    }
}

$pagetitle = "staff";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";
?>

<h2>Staff Log In</h2>
<?php
if ((isset($done)) && ($done)) {
	$msg = 'The password has been changed';
	wereGood($msg);

} else {

    ?>
<h3>Username</h3>
<ul>
	<li><label>Your Athena Login Username is:</label>
	<strong><?php echo $r->usr?></strong>
	</li>
</ul>

<h3>New Password</h3>
<h4>Password must contain at least ...</h4>
<ul style="margin-left: 40px;">
	<li>A minimum of 7 Characters</li>
	<li style="list-style: disc;">One lower case letter</li>
	<li style="list-style: disc;">One upper case letter</li>
	<li style="list-style: disc;">One number</li>
</ul>

<form
	action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $_GET['id']?>&amp;go=y"
	enctype="multipart/form-data" method="post">
	<?php echo form_fail(); ?>

	<fieldset class="form-group">

		<?php
    html_hidden('usr', $r->usr);
    html_hidden('stfid', $_GET['id']);
    if ($seclevel > 1) {
        if ($oldpwwrong) {
            echo $oldpwwrong;
        }
        html_pw("Old Password", "opw", $_POST['opw']);
    }
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

include "/srv/ath/pub/mng/tmpl/footer.php";
?>
