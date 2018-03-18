<?php
$section = "signup";
$page = "signup";

include "/srv/ath/src/php/www/common.php";
include "/srv/ath/src/php/athena_mail.php";

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

		$dbsite = sitedbconnect(SITESID);

		if (isset($_POST['usr']) && ($_POST['usr'] != "")) {
			$usr = $_POST['usr'];
			$ret = getUserByLogin($usr);
			if (isset($ret['id'])) {
				$ret['usr']=$usr;
				sendResetMail($ret,SITESID);
				$msg = 'We have sent you an email with a link to reset your password.';
			} elseif ((isset($_POST['email'])) && ($_POST['email'] != "")) {
				$ret = getUserByEmail($email);
				if (isset($ret['id'])) {
					sendResetMail($ret,SITESID);
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

include 'head.php';

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

						<div class="form-group row">

							<label class="col-sm-3 form-control-label" for="id_username">Username</label>
							<div class="col-sm-9">
								<input id="id_username" type="text" name="usr" maxlength="30"
									size="20" style="width: 220px;" class="form-control">

							</div>

						</div>
					</fieldset>



					<div class="form-group row">

						<label class="col-sm-3 form-control-label" for="id_email">OR</label>

					</div>

					<div class="form-group row">

						<label class="col-sm-3 form-control-label" for="id_email">Email</label>
						<div class="col-sm-9">
							<input id="id_email" type="text" name="email" maxlength="30"
								size="20" style="width: 220px;" class="form-control">

						</div>

					</div>



					<fieldset class="buttons">

						<input type=submit value=Continue class="btn btn-primary">

					</fieldset>


				</form>

				<?php
				}
				?>

			</div>
		</div>
	</header>


<?php

include 'foot.php';
?>

