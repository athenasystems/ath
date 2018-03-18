<?php
include "/srv/ath/src/php/www/common.php";

// Get a key from https://www.google.com/recaptcha/admin/create
$publickey = "6LeT-BsTAAAAAFCZG9R2lDFkx5I9rLbdl1PJa80n";
$privatekey = "6LeT-BsTAAAAAFd85UTtjRzqX_FBQiGadpO_ISAI";

$errors = array();
$brand = ((isset($_GET['b'])) && ($_GET['b'] != '')) ? $_GET['b'] : '';

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {
    
    $required = array(
        'fname',
        'sname',
        "co_name",
        "email",
        "tel"
    );
    $errors = check_required($required, $_POST);
    
    if (! isDev()) {
        require_once ('recaptchalib.php');
        // the response from reCAPTCHA
        $resp = null;
        // the error code from reCAPTCHA, if any
        $error = null;
        
        if ($_POST["recaptcha_response_field"]) {
            $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
            
            if ($resp->is_valid) {} else {
                // set the error code so that we can display it
                $errors[] = $resp->error;
            }
        }
    }
    
    if (empty($errors)) {
        
        // Add to Signups table
        $signupsNew = new Signups();
        $signupsNew->setIncept(time());
        $signupsNew->setFname($_POST['fname']);
        $signupsNew->setSname($_POST['sname']);
        $signupsNew->setCo_name($_POST['co_name']);
        $signupsNew->setEmail($_POST['email']);
        $signupsNew->setTel($_POST['tel']);
        $signupsNew->setStatus('new');
        $signupsNew->setBrand($_POST['brand']);
        $signupsNew->insertIntoDB();
        
        header("Location: done?WelcomeToAthena");
        exit();
    }
}

include '../www/inc/header.php';
?>

<!-- Global Page Section Start -->
<section class="global-page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="block">
					<h2>Register</h2>
					<ol class="breadcrumb">
						<li><a href="index.php"> <i class="ion-ios-home"></i> Home
						</a></li>
						<li class="active">Register</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Company Description Section Start -->
<section>
	<div class="container">
		<div class="col-md-12">

			<script src='https://www.google.com/recaptcha/api.js'></script>
			<h3>Sign Up</h3>

			<form action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
				enctype="multipart/form-data" method="post" name="editcust">
	<?php echo form_fail(); ?>

	<fieldset>
		<?php

html_text("First Name *", "fname", $_POST['fname']);

html_text("Surname *", "sname", $_POST['sname']);

html_text("Company Name *", "co_name", $_POST['co_name']);

html_text("Email *", "email", $_POST['email']);

html_text("Tel *", "tel", $_POST['tel']);

?>
	</fieldset>
	<?php

require_once ('recaptchalib.php');
echo recaptcha_get_html($publickey);
?>
	<div class="g-recaptcha"
					data-sitekey="6LeT-BsTAAAAAFCZG9R2lDFkx5I9rLbdl1PJa80n"></div>
				<fieldset class="buttons">
		<?php
html_button("Sign Up");
html_hidden('brand', $brand);
?>

	</fieldset>

			</form>

		</div>
	</div>
</section>
<br><br><br>
<?php #include '../inc/clients.php';?>
<?php include '../www/inc/footer.php';?>
