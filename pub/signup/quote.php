<?php

$section = "signup";
$page = "signup";

include "/srv/ath/src/php/www/common.php";

$errors = array();

if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

	$required = array("co_name", "email", "tel");
	$errors = check_required($required, $_POST);

	if(empty($errors)){

		$rfqNew = new Rfq();
		$rfqNew->setContent($_POST['content']);
	#	$rfqNew->setQuantity($_POST['quantity']);
		$rfqNew->setFname($_POST['fname']);
		$rfqNew->setSname($_POST['sname']);
		$rfqNew->setEmail($_POST['email']);
		$rfqNew->setTel($_POST['tel']);
	#	$rfqNew->setCo_name($_POST['co_name']);

		$rfqNew->insertIntoDB();

		header("Location: done");
		exit();

	}
}

$pagetitle = "Sign up to Athena Online";
$pagescript = array();
$pagestyle = array();

include "head.php";

?>

<h3>Request for Quote</h3>

<form action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post" name="editcust">
	<?php echo form_fail(); ?>

	<fieldset>


		<?php

		html_textarea('Description *', 'content', $_POST['content']);

		#html_text('Quantity *', 'quantity', $_POST['quantity']);

		html_text("First Name *", "fname", $_POST['fname']);

		html_text("Surname", "sname", $_POST['sname']);

		html_text("Email", "email", $_POST['email']);

		#html_text("Company Name", "co_name", $_POST['co_name']);

		html_text("Tel", "tel", $_POST['tel']);

		?>


	</fieldset>

	<fieldset class="buttons">
		<?php
		html_button("Request Quote");
		?>

	</fieldset>

</form>

<?php
include "foot.php";
?>
