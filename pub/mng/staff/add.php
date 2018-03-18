<?php
$section = "Contacts";
$page = "Staff";

include "/srv/ath/src/php/mng/common.php";

$errors = array();
$done=0;
$usr = '';

if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

	$required = array("fname");
	$errors = check_required($required, $_POST);

	if(empty($errors)){

		$logContent = "\n";
		$pw = generatePassword();

		# Add to Address table
		$addsid = addDBAddress($_POST);
		$staffNew = new Staff();
		$staffNew->setFname($_POST['fname']);
		$staffNew->setSname($_POST['sname']);
		$staffNew->setAddsid($addsid);
		$staffNew->setJobtitle($_POST['jobtitle']);
		$staffNew->setLevel(10);
		$stfid = $staffNew->insertIntoDB();

        # Add to Pwd table
		$usr = generateStafflogon($_POST['fname'],$_POST['sname']);

		$salt = generatePassword(6);
		$pwdNew = new Pwd();
		$pwdNew->setUsr($usr);
		$pwdNew->setStaffid($stfid);
		$pwdNew->setPw(crypt($pw,$salt));
     	$pwdNew->setInit(encrypt($pw));
    	$pwdNew->insertIntoDB();

		$logresult = logEvent(15,$logContent);

		$done=1;
	}
}

$pagetitle = "Add staff";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";

if($done){
	$msg = 'New staff member has been added';
	wereGood($msg);
	?>
<h2>Write down the password now.<br>
It cannot be found anywhere else.</h2>
Username:
<?php echo $usr;?>
<br>
Password:
<?php

echo $pw;

}else{



	?>

<h2>
	Add a new member of staff <span> </span>
</h2>

	<?php
	$noofstaff = noOfStaff();
	if((noOfStaff()>2) || (isset($siteMods['staffport']))){
		?>

<form action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">

	<?php echo form_fail(); ?>

	<fieldset class="form-group">


		<?php

		#	id, fname, sname, add1, add2, city, county, dob

		echo '<h3>Personal Details</h3>';


		html_text("First Name *", "fname", $_POST['fname']);

		html_text("Second Name", "sname", $_POST['sname']);

		html_text("Job Title", "jobtitle", $_POST['jobtitle']);

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
	}else{
		wereBad('To add more staff you need to add the "Staff" Module');
	}


}
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
