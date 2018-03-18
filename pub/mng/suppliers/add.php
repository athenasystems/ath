<?php
$section = "Contacts";
$page = "add";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {


	if(($_POST['fname'] == '')&& ($_POST['sname'] == '')&&($_POST['co_name'] == '')){
		$errors[] = 'fname';
		$errors[] = 'sname';
		$errors[] = 'co_name';
	}

	if (empty($errors)) {

		$logContent = "\n";

		if ((! isset($_POST['co_name'])) || ($_POST['co_name'] == '')) {
			$_POST['co_name'] = $_POST['fname'] . ' ' . $_POST['sname'];
		}


		$suppid = addSupplier($_POST);

		$logresult = logEvent(13, $logContent);

		header("Location: /suppliers");

		exit();
	}
}

$pagetitle = "Add a New Supplier";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";
?>

<h1>
	Add a New Supplier <span> </span>
</h1>

<form action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">
	<?php echo form_fail(); ?>

	<fieldset class="form-group">

			<?php

			// id, co_name, contact, add1, add2, add3, city, county, postcode, tel, fax, email

			echo '<h3>Company Details</h3>';

			html_text("First Name", "fname", $_POST['fname']);

			html_text("Surname", "sname", $_POST['sname']);

			html_text("Company Name", "co_name", $_POST['co_name'], "co_name",'I need at least a first name or a company name, or both, here');

			include '/srv/ath/src/php/tmpl/adds.add.form.php';

			?>

	</fieldset>

	<fieldset class="form-group">
		<?php
		html_button("Save changes");
		?>


	</fieldset>

</form>



<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
