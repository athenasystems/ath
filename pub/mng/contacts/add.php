<?php

$section = "Contacts";
$page = "add";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

	$required = array("fname");
	$errors = check_required($required, $_POST);

	if(empty($errors)){

		$logContent = "\n";
		$pw = generatePassword();
		$logon = generateContactlogon( $_POST['fname'],$_POST['sname']);

		# Add to Address table
		$addsid = addDBAddress($_POST);

		$contactsNew = new Contacts();
		$contactsNew->setFname($_POST['fname']);
		$contactsNew->setSname($_POST['sname']);
		$contactsNew->setCo_name($_POST['co_name']);
		$contactsNew->setRole($_POST['role']);
		if(($_POST['custid']!='')&&(is_numeric($_POST['custid']))){
			$contactsNew->setCustid($_POST['custid']);
		}elseif(($_POST['suppid']!='')&&(is_numeric($_POST['suppid']))){
			$contactsNew->setSuppid($_POST['suppid']);
		}
		$contactsNew->setAddsid($addsid);
		$contactsid = $contactsNew->insertIntoDB();

		// Add to password table
		$salt = generatePassword(6);
		$pwdNew = new Pwd();
		$pwdNew->setUsr($logon);
		$pwdNew->setContactsid($contactsid);
		$pwdNew->setPw(crypt($pw,$salt));
		$pwdNew->setInit(encrypt($pw));

		# Dont add to the Password table unless they have a custid or a suppid
		if((isset($_POST['custid'])) && ($_POST['custid']>0)){
			$pwdNew->setCustid($_POST['custid']);
			$pwdNew->insertIntoDB();
		}elseif((isset($_POST['suppid'])) && ($_POST['suppid']>0)){
			$pwdNew->setSuppid($_POST['suppid']);
			$pwdNew->insertIntoDB();
		}else{
			# Not adding to passwd table
			# i.e contacts not associated with a customer or supplier cant log in
		}

		$logresult = logEvent(6,$logContent);

		header("Location: /contacts/?Added=". $result['id']);
		exit();

	}

}

$pagetitle = "Add a New Contact";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";


if(isset($_GET['custid'])){
	$custid = $_GET['custid'];
}
if(isset($_GET['suppid'])){
	$suppid = $_GET['suppid'];
}

if(isset($custid)){
	$co_name = getCustName($_GET['custid']);
}

if(isset($suppid)){
	$co_name = getSuppName($_GET['suppid']);
}

?>
<?php

if(isset($_GET['FromAddCustomer'])){
	?>
<div class="alert alert-success" role="alert">
	<strong>Saved</strong> Your new Customer has been saved. You can now
	Add a Contact for this Customer
</div>
<?php
}

if(isset($_GET['FromAddSupplier'])){
	?>
<div class="alert alert-success" role="alert">
	<strong>Saved</strong> Your new Supplier has been saved. You can now
	Add a Contact for this Supplier
</div>
<?php
}
?>
<h2>Add a New Contact</h2>

<form action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">

	<?php echo form_fail(); ?>

	<fieldset class="form-group">


		<?php
		echo '<h3>Personal Details</h3>';

		html_text("First Name *", "fname", $_POST['fname']);

		html_text("Surname", "sname", $_POST['sname']);

		if(!isset($custid)){

			echo '<h3>Company Details</h3>';

			html_text("Company Name", "co_name", $_POST['co_name']);

			if(!isset($_POST['custid'])){
				$_POST['custid']=$_GET['custid'];
			}
			customer_select("Or", "custid", $_POST['custid']);

		}else{
			html_hidden('custid', $custid);
		}
		if(!isset($_POST['suppid'])){
			$_POST['suppid']=$_GET['suppid'];
		}
		supplier_select("Or", "suppid", $_POST['suppid']);

		html_text("Role", "role", $_POST['role']);


		include '/srv/ath/src/php/tmpl/adds.add.form.php';



		html_textarea("Notes", "notes", $_POST['notes'], "body", "y");

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
