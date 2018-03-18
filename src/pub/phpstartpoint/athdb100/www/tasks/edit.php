<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Tasks.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$tasksUpdate = new Tasks();

	$tasksUpdate->setTasksid($_POST['tasksid']);
	$tasksUpdate->setCustid($_POST['custid']);
	$tasksUpdate->setJobsid($_POST['jobsid']);
	$tasksUpdate->setNotes($_POST['notes']);
	$tasksUpdate->setIncept($_POST['incept']);
	$tasksUpdate->setStaffid($_POST['staffid']);
	$tasksUpdate->setHours($_POST['hours']);
	$tasksUpdate->setRate($_POST['rate']);
	$tasksUpdate->setInvoicesid($_POST['invoicesid']);
	$tasksUpdate->setContactsid($_POST['contactsid']);

	$tasksUpdate->updateDB();
}
$pageTitle = "Tasks Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";


$tasks = new Tasks();
// Load DB data into object
$tasks->setTasksid($_GET['id']);
$tasks->loadTasks();
$all = $tasks->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="tasksid" id="tasksid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="custid">custid</label>
	<input type="text" name="custid" id="custid" value="<?php echo $tasks->getCustid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="jobsid">jobsid</label>
	<input type="text" name="jobsid" id="jobsid" value="<?php echo $tasks->getJobsid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="notes">notes</label>
	<input type="text" name="notes" id="notes" value="<?php echo $tasks->getNotes();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $tasks->getIncept();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="staffid">staffid</label>
	<input type="text" name="staffid" id="staffid" value="<?php echo $tasks->getStaffid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="hours">hours</label>
	<input type="text" name="hours" id="hours" value="<?php echo $tasks->getHours();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="rate">rate</label>
	<input type="text" name="rate" id="rate" value="<?php echo $tasks->getRate();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="invoicesid">invoicesid</label>
	<input type="text" name="invoicesid" id="invoicesid" value="<?php echo $tasks->getInvoicesid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="contactsid">contactsid</label>
	<input type="text" name="contactsid" id="contactsid" value="<?php echo $tasks->getContactsid();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
