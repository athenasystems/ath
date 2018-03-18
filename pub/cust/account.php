<?php
$section = "Staff";
$page = "Staff";

include "/srv/ath/src/php/cust/common.php";

$sqltext = "SELECT usr,pw FROM pwd where custid=" . $custID;
// print "<br/>$sqltext";
$res = $dbsite->query($sqltext); # or die("Cant get the cust!");
$r = $res[0];

$errors = array();

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

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

    elseif ((! isset($_POST['npw1'])) || (strlen($_POST['npw1']) < 8)) {
        $errors[] = 'npw1';
    } elseif ((! isset($_POST['npw2'])) || (strlen($_POST['npw2']) < 8)) {
        $errors[] = 'npw2';
    } elseif ($_POST['npw1'] != $_POST['npw2']) {
        $pwnotmatch = 1;
        $errors[] = 'npw1';
    }

    if (empty($errors)) {

        $pwdUpdate = new Pwd();
        $pwdUpdate->setUsr($_POST['usr']);
        $pwdUpdate->setPw(crypt($_POST['npw1']));
        $pwdUpdate->updateDB();

        // $logresult = logEvent(15,$logContent);
        $done = 1;
        $_POST['npw1'] = '';
        $_POST['npw2'] = '';
    }
}

$pagetitle = "staff";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/cust/tmpl/header.php";
?>

<h2>Staff Log In</h2>
<?php
if ((isset($done)) && ($done)) {
	$msg='Password has been changed';
	wereGood($msg);
}

?>
<h2>Password must be a minimum of 7 Characters</h2>

<form action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">
	<?php echo form_fail(); ?>

	<fieldset class="form-group">

		<ol>
			<li><label>Log in Username</label> <span
				style="line-height: 1.8em; font-weight: bold;"><?php echo $r->usr;?>
			</span></li>
			<?php
html_hidden('usr', $r->usr);

if ($oldpwwrong) {
    echo '<li>' . $oldpwwrong . '</li>';
}
html_pw("Old Password", "opw", $_POST['opw']);

if ($pwnotmatch) {
    echo '<li>New passwords are not the same</li>';
}
html_pw("New Password", "npw1", $_POST['npw1']);
html_pw("Repeat New Password", "npw2", $_POST['npw2']);

?>

		</ol>

	</fieldset>

	<fieldset class="form-group">
		<?php
html_button("Save changes");
?>


	</fieldset>

</form>

<?php

include "/srv/ath/pub/cust/tmpl/footer.php";
?>
