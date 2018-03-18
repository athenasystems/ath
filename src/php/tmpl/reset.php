<?php
$section = "signup";
$page = "signup";

include "/srv/ath/src/php/www/common.php";

$errors = array();

$msg = '';

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {
	if ((isset($_POST['usr'])) && ($_POST['usr'] != "")) {
		$required = array(
				"usr"
		);
		$errors = check_required($required, $_POST);
	} elseif ((isset($_POST['email'])) && ($_POST['email'] != "")) {
		$required = array(
				"email"
		);
		$errors = check_required($required, $_POST);
	} else {
		$errors[] = 'No Username or Email';
	}

	if (empty($errors)) {
		if (isset($_POST['usr']) && ($_POST['usr'] != "")) {
			$usr = $_POST['usr'];
			$ret = getUserByLogin($usr);
			if (isset($ret['id'])) {
				sendResetMail($ret);
				$msg = 'We have sent you an email with a link to reset your password.';
			} elseif ((isset($_POST['email'])) && ($_POST['email'] != "")) {
				$ret = getUserByEmail($email);
				if (isset($ret['id'])) {
					sendResetMail($ret);
					$msg = 'We have sent you an email with a link to reset your password.';
				} else {
					$msg = 'We cannot find that email in our system.';
				}
				header("Location: done");
				exit();
			}
		}
	}
}
$pagetitle = "Password Reset";
$pagescript = array();
$pagestyle = array();

include "head.php";

?>

<h3>Password Reset</h3>

<?php
if ($msg != '') {
	?>
<div class="alert alert-warning" role="alert">
	<strong></strong>
	<?php echo $msg; ?>
</div>
<?php
} else {
	?>

<form action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post" name="editcust">
	<?php echo form_fail(); ?>

	<fieldset>

		<?php
		if (isset($_GET['e'])) {

			?>

		<div class="form-group row">

			<label class="col-sm-3 form-control-label" for="id_email">Email</label>
			<div class="col-sm-9">
				<input id="id_email" type="text" name="email" maxlength="30"
					size="20" style="width: 120px;" class="form-control">

			</div>
			<?php


		} elseif (isset($_GET['u'])) {
			?>

			<div class="form-group row">

				<label class="col-sm-3 form-control-label" for="id_username">Username</label>
				<div class="col-sm-9">
					<input id="id_username" type="text" name="usr" maxlength="30"
						size="20" style="width: 120px;" class="form-control">

				</div>
				<?php

		}else{
			?>

				<a href="<?php echo $_SERVER['PHP_SELF']?>?u=1">I know my Username</a>
				<br>Or<br> <a href="<?php echo $_SERVER['PHP_SELF']?>?e=1">I know my
					Email Address</a>

				<?php
		}
		?>

	</fieldset>

	<fieldset class="buttons">
		<?php
		html_button("Continue");
		?>

	</fieldset>

</form>

<?php
}
?>

<?php
include "foot.php";
?>
