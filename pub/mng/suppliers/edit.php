<?php
$section = "Contacts";
$page = "edit";

include "/srv/ath/src/php/mng/common.php";

$sqltext = "SELECT * FROM supp WHERE suppid='" . $_GET['id'] . "'";
// print "<br/>$sqltext";
$res = $dbsite->query($sqltext); # or die("Cant get supplier");
$r = $res[0];
$co_name = $r->co_name;
$addsid = $r->addsid;
$colour = $r->colour;
$errors = array();

if (isset($_GET['remove']) && $_GET['remove'] == "y" && isset($_GET['id']) && is_numeric($_GET['id'])) {

	$suppDelete = new Supp();
	$suppDelete->setSuppid($_GET['id']);
	$suppDelete->deleteFromDB();

	header("Location: /suppliers/");
	exit();
}

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	$required = array(
			"co_name"
	);
	$errors = check_required($required, $_POST);

	if (empty($errors)) {

		// Update Address table
		$addsid = updateDBAddress($_POST, $addsid);

		$suppUpdate = new Supp();

		$suppUpdate->setSuppid($_POST['suppid']);
		$suppUpdate->setCo_name($_POST['co_name']);
		#$suppUpdate->setInv_contact($_POST['inv_contact']);
		$suppUpdate->setColour($_POST['colour']);
		$suppUpdate->updateDB();

		header("Location: /suppliers/");

		exit();
	}
}

$pagetitle = "Edit supplier";
$pagescript = array(
		"/pub/js/picker.js"
);
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";

?>

<h2>Edit Supplier</h2>
<a href="?id=<?php echo $_GET['id']?>&amp;remove=y"
	title="Remove this item" class="cancel">Delete Supplier</a>
<form
	action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $_GET['id']?>&amp;go=y"
	enctype="multipart/form-data" method="post" name="editsupp">
	<?php echo form_fail(); ?>

	<fieldset class="form-group">
		<h3>Company Details</h3>
		<?php

		html_text("Company Name", "co_name", $co_name);

		#suppliercontact_select("Invoice Contact", "contactsid", $r->inv_contact, $_GET['id']);
		?>
		<label for="colour">Colour&nbsp; <span style="width:10px;background-color:<?php echo $colour; ?>;float:right;margin-right:5px;">&nbsp;</span>&nbsp;
		</label> <input type="text" name="colour"
			value="<?php echo $colour;?>"> <a
			href="javascript:TCP.popup(document.forms['editsupp'].elements['colour'])">
			<img width="15" height="13" border="0"
			alt="Click Here to Pick up the color" src="/img/sel.gif">
		</a>

		<?php

		include '/srv/ath/src/php/tmpl/adds.edit.form.php';

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
