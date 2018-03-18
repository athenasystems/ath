<?php


$section = "Contacts";
$page = "edit";

include "/srv/ath/src/php/mng/common.php";


$sqltext = "SELECT * FROM cust WHERE custid='". $_GET['id'] ."'";
#print "<br/>$sqltext";
$res = $dbsite->query($sqltext); # or die("Cant get customer");
$r = $res[0];

$addsid = $r->addsid;

$errors = array();

if(isset($_GET['remove']) && $_GET['remove'] == "y" && isset($_GET['id']) && is_numeric($_GET['id'])){

	$custUpdate = new Cust();
	$custUpdate->setCustid($_GET['id']);
	$custUpdate->setLive(0);
	$custUpdate->updateDB();

	header("Location: /customers/");
	exit();

}


if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

	$required = array("co_name");
	$errors = check_required($required, $_POST);

	if(empty($errors)){

		# Update Address table
		$addsid = updateDBAddress($_POST,$addsid);

		$custUpdate = new Cust();
		$custUpdate->setCustid($_POST['custid']);
		$custUpdate->setFname($_POST['fname']);
		$custUpdate->setSname($_POST['sname']);
		$custUpdate->setCo_name($_POST['co_name']);
		$custUpdate->setInv_contact($_POST['contactsid']);
		$custUpdate->setColour($_POST['colour']);
		$custUpdate->updateDB();

		header("Location: /customers/");

		exit();

	}

}

$pagetitle = "Edit customer";
$pagescript = array("/pub/js/picker.js");
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";


?>

<h1>Edit Customer</h1>
<span> <a href="?id=<?php echo $_GET['id']?>&amp;remove=y"
	title="Remove this Customer" class="cancel" onclick="confirmSubmit()">Delete
		Customer</a>

</span>
<form
	action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $_GET['id']?>&amp;go=y"
	enctype="multipart/form-data" method="post" name="editcust">

	<?php echo form_fail(); ?>

	<fieldset class="form-group">
		<h3>Company Details</h3>
		<?php

		html_text("First Name", "fname", $r->fname);

		html_text("Surname", "sname", $r->sname);

		html_text("Company Name", "co_name", $r->co_name);



		custcontact_select("Invoice Contact", "contactsid", $r->inv_contact, $_GET['id']);
		?>

		<div class="form-group row">
			<label for="co_name" class="col-sm-2 form-control-label">Colour&nbsp;<span style="width:10px;background-color:<?php echo $r->colour?>;float:right;margin-right:5px;">&nbsp;</span>
			</label>
			<div class="col-sm-10">
				<input type="text" name="colour" value="<?php echo $r->colour?>"> <a
					href="javascript:TCP.popup(document.forms['editcust'].elements['colour'])">
					<img width="15" height="13" border="0"
					alt="Click Here to Pick up the color" src="/img/sel.gif" />
				</a>
			</div>
		</div>
		<?php

		include '/srv/ath/src/php/tmpl/adds.edit.form.php';

		?>

	</fieldset>

	<fieldset class="form-group">

		<?php
		html_button("Save changes");
		html_hidden('custid', $_GET['id']);
		?>


	</fieldset>

</form>
<script>
<!--
function confirmSubmit()
{
var agree=confirm("Are you sure you wish to delete this Customer?");
if (agree){
location = "/customers/edit?id=<?php echo $_GET['id']?>&remove=y" ;
}else{
	return false ;
}
}
// -->
</script>



<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
