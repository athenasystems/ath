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

		$custid = addCustomer($_POST);


		#mkdir('/srv/ath/var/files/' . $sitesid . '/cust/' . $filestr);

		$logresult = logEvent(13, $logContent);

		if($_POST['backto']=='quotes'){
			header("Location: /quotes/add?id=$custid");
		}elseif($_POST['backto']=='invoices'){
			header("Location: /invoices/add?id=$custid");
		}elseif($_POST['backto']=='jobs'){
			header("Location: /jobs/add?custid=$custid");
		}else{
			header("Location: /customers");
		}
		exit();
	}
}

$pagetitle = "Add a New Customer";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";
?>

<h1>
	Add a New Customer <span> </span>
</h1>

<?php echo form_fail(); ?>

<form action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">

	<fieldset class="form-group">

		<?php
		html_button("Add New Customer ");
		?>

	</fieldset>
	<fieldset class="form-group">

		<?php

		html_text("First Name", "fname", $_POST['fname']);

		html_text("Surname", "sname", $_POST['sname']);

		html_text("Company Name", "co_name", $_POST['co_name'], "co_name",'I need at least a first name or a company name, or both, here');
		include '/srv/ath/src/php/tmpl/adds.add.form.php';

		?>

	</fieldset>

	<fieldset class="form-group">

		<?php
		html_button("Add New Customer ");
		html_hidden('backto', $_GET['backto']);
		?>

	</fieldset>

</form>



<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
