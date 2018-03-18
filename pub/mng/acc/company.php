<?php
$section = "Home";
$page = "edit";

include "/srv/ath/src/php/mng/common.php";

$sites = new Sites();
// Load DB data into object
$sites->setSitesid($sitesid);
$sites->loadSites();

$addsid = $sites->getAddsid();

$errors = array();

$done =0;
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	$required = array(
			"email",
			"co_name"
	);
	$errors = check_required($required, $_POST);

	if (empty($errors)) {

		// Update Address table
		updateDBAddress($_POST, $addsid);

		$sitesUpdate = new Sites();

		$sitesUpdate->setSitesid($sitesid);
		$sitesUpdate->setCo_name($_POST['co_name']);
		$sitesUpdate->setInv_email($_POST['email']);
		$sitesUpdate->setVat_no($_POST['vat_no']);
		$sitesUpdate->setCo_no($_POST['co_no']);
		$sitesUpdate->setEoyday($_POST['eoyday']);
		$sitesUpdate->setEoymonth($_POST['eoymonth']);
		$sitesUpdate->updateDB();

		$done = 1;
		//         header("Location: /?highlight=" . $result['id']);
		//         exit();
	}
}

$pagetitle = "Edit Your Company Details";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {
	$sites->loadSites();
}
?>

<h3>Edit Your Company Details</h3>
<?php
if($done){
	$msg = 'That\'s been saved';
	wereGood($msg);
}
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?go=y"
	enctype="multipart/form-data" method="post" name="editcust">
	<?php echo form_fail(); ?>

	<fieldset class="form-group">
		<?php
		html_button("Save changes");
		?>
	</fieldset>
<h3>Company Details</h3>
	<fieldset class="form-group">
		<?php
		$coname=$sites->getCo_name();
		if(isset($_POST['co_name'])){
			$coname=$_POST['co_name'];
		}
		html_text("Company Name *", "co_name",$coname );

		$vatno=$sites->getVat_no();
		if(isset($_POST['vat_no'])){
			$vatno=$_POST['vat_no'];
		}
		html_text("Company Vat Number", "vat_no", $vatno);

		$cono=$sites->getCo_no();
		if(isset($_POST['co_no'])){
			$cono=$_POST['co_no'];
		}
		html_text("Company Number", "co_no", $cono);

		?>
		<div class="form-group row">
			<label for="co_name" class="col-sm-2 form-control-label">End of
				Financial Year</label>
			<div class="col-sm-10">

				<input name="eoyday" id="eoyday"
					value="<?php echo $sites->getEoyday();?>" class="" placeholder="D"
					type="text" style="width: 40px;"> / <input name="eoymonth"
					id="eoymonth" value="<?php echo $sites->getEoymonth();?>" class=""
					placeholder="M" type="text" style="width: 40px;">
			</div>
		</div>


		<?php
		$emailMand = ' *';
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
