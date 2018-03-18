<?php

$section = "Contacts";
$page = "Staff";

include "/srv/ath/src/php/mng/common.php";

$staff = new Staff();
// Load DB data into object
$staff->setStaffid($_GET['id']);
$staff->loadStaff();

$addsid = $staff->getAddsid();

$errors = array();

if(isset($_GET['remove']) && $_GET['remove'] == "y" && isset($_GET['id']) && is_numeric($_GET['id'])){
	$staffDelete = new Staff();
	$staffDelete->setStaffid($_GET['id']);
	$staffDelete->deleteFromDB();

	header("Location: /staff/");
	exit();

}


if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

	$required = array("fname");
	$errors = check_required($required, $_POST);

	if((isset($_POST['pw']))&&($_POST['pw']!='')&&(strlen($_POST['pw'])<7)){
		$errors[] = 'pw';
	}

	if(empty($errors)){

		# Add to Address table
		$addsid = updateDBAddress($_POST,$addsid);



		$staffUpdate = new Staff();

		$staffUpdate->setStaffid($_GET['id']);
		$staffUpdate->setFname($_POST['fname']);
		$staffUpdate->setSname($_POST['sname']);
		$staffUpdate->setJobtitle($_POST['jobtitle']);
		$staffUpdate->setStatus($_POST['status']);

		$staffUpdate->updateDB();



		header("Location: /staff/");

		exit();


	}

}

$pagetitle = "Edit Staff Member";
$pagescript = array();
$pagestyle = array();



// if(($seclevel>3)&&($r->staffid!=$staffid)){
// 	header("Location: /staff/?Oooopppsss=1");
// 	exit();
// }


include "/srv/ath/pub/mng/tmpl/header.php";


?>
<script type="text/javascript">
<!--
function confirmation() {
	var answer = confirm("Sure you want to delete this Staff Member-<?php echo $staff->getFname();?> <?php echo $staff->getSname();?> ?");
	if (answer){
		window.location = "/staff/edit?id=<?php echo $_GET['id']?>&remove=y";
	}

}
//-->
</script>
<h2>Edit Staff Members Details</h2>

<form
	action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $_GET['id']?>&amp;go=y"
	enctype="multipart/form-data" method="post">
	<?php echo form_fail(); ?>
	<fieldset class="form-group">
		<?php
		html_button("Save changes");
		?>


	</fieldset>
	<fieldset class="form-group">


		<?php
		#	id, fname, sname, add1, add2, city, county, dob

		echo '<h3>Personal Details</h3>';

		html_text("First Name *", "fname", $staff->getFname());

		html_text("Family Name", "sname", $staff->getSname());

		html_text("Job Title", "jobtitle", $staff->getJobtitle());

		employee_status_select('Status','status',$staff->getStatus());

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
if($staffid<1001){
	?>
<span><a href="javascript:void(0);" title="Delete Staff Member"
	class="cancel" onclick="confirmation();">Delete Staff Member</a> </span>
<?php
}
?>

<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
