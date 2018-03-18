<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Tasks.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$tasksNew = new Tasks();
	$tasksNew->setCustid($_POST['custid']);
	$tasksNew->setJobsid($_POST['jobsid']);
	$tasksNew->setNotes($_POST['notes']);
	$tasksNew->setIncept($_POST['incept']);
	$tasksNew->setStaffid($_POST['staffid']);
	$tasksNew->setHours($_POST['hours']);
	$tasksNew->setRate($_POST['rate']);
	$tasksNew->setInvoicesid($_POST['invoicesid']);
	$tasksNew->setContactsid($_POST['contactsid']);

	$tasksNew->insertIntoDB();
		
	header("Location: /tasks/?ItemAdded=y");

}
$pageTitle = "Tasks Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="tasksid" id="tasksid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="custid">custid</label>
	<input type="text" name="custid" id="custid" value="<?php echo $_POST[custid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="jobsid">jobsid</label>
	<input type="text" name="jobsid" id="jobsid" value="<?php echo $_POST[jobsid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="notes">notes</label>
	<input type="text" name="notes" id="notes" value="<?php echo $_POST[notes];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $_POST[incept];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="staffid">staffid</label>
	<input type="text" name="staffid" id="staffid" value="<?php echo $_POST[staffid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="hours">hours</label>
	<input type="text" name="hours" id="hours" value="<?php echo $_POST[hours];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="rate">rate</label>
	<input type="text" name="rate" id="rate" value="<?php echo $_POST[rate];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="invoicesid">invoicesid</label>
	<input type="text" name="invoicesid" id="invoicesid" value="<?php echo $_POST[invoicesid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="contactsid">contactsid</label>
	<input type="text" name="contactsid" id="contactsid" value="<?php echo $_POST[contactsid];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
