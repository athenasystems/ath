<?php

$section = "staff";
$page = "Staff";

include "/srv/ath/src/php/staff/common.php";

$sqltext = "SELECT * from staff WHERE staffid=" . $staffid;

#print "<br/>$sqltext";

$res = $dbsite->query($sqltext); # or die("Cant get staff");

$r = $res[0];

$addsid = $r->addsid;

$errors = array();

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

		header("Location: /");

		exit();


	}

}

$pagetitle = "Edit Staff Member";
$pagescript = array();
$pagestyle = array();



if(($seclevel>3)&&($r->staffid!=$staffid)){
	header("Location: /staff/?Oooopppsss=1");
	exit();
}



include "/srv/ath/pub/staff/tmpl/header.php";

$r = $res[0];

if(!isset($siteMods['staff'])){
	?>
	<h2>This Athena Module has not been activated</h2>
	<?php
	include "/srv/ath/pub/mng/tmpl/footer.php";
	exit;
	}


?>

<h2>Edit Staff Members Details</h2>

<form
	action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $staffid?>&amp;go=y"
	enctype="multipart/form-data" method="post">
	<?php echo form_fail(); ?>

	<fieldset class="form-group">


			<?php
			#	id, fname, sname, add1, add2, city, county, dob

			echo '<h3>Personal Details</h3>';

			html_text("First Name *", "fname", $r->fname);

			html_text("Surname", "sname", $r->sname);

			html_text("Job Title", "jobtitle", $r->jobtitle);

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
include "/srv/ath/pub/staff/tmpl/footer.php";
?>
