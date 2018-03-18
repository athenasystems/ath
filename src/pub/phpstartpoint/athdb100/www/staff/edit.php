<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Staff.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$staffUpdate = new Staff();

	$staffUpdate->setStaffid($_POST['staffid']);
	$staffUpdate->setFname($_POST['fname']);
	$staffUpdate->setSname($_POST['sname']);
	$staffUpdate->setAddsid($_POST['addsid']);
	$staffUpdate->setNotes($_POST['notes']);
	$staffUpdate->setJobtitle($_POST['jobtitle']);
	$staffUpdate->setContent($_POST['content']);
	$staffUpdate->setStatus($_POST['status']);
	$staffUpdate->setLevel($_POST['level']);
	$staffUpdate->setTeamsid($_POST['teamsid']);
	$staffUpdate->setTimesheet($_POST['timesheet']);
	$staffUpdate->setHoliday($_POST['holiday']);
	$staffUpdate->setTheme($_POST['theme']);

	$staffUpdate->updateDB();
}
$pageTitle = "Staff Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";


$staff = new Staff();
// Load DB data into object
$staff->setStaffid($_GET['id']);
$staff->loadStaff();
$all = $staff->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="staffid" id="staffid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="fname">fname</label>
	<input type="text" name="fname" id="fname" value="<?php echo $staff->getFname();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="sname">sname</label>
	<input type="text" name="sname" id="sname" value="<?php echo $staff->getSname();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="addsid">addsid</label>
	<input type="text" name="addsid" id="addsid" value="<?php echo $staff->getAddsid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="notes">notes</label>
	<input type="text" name="notes" id="notes" value="<?php echo $staff->getNotes();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="jobtitle">jobtitle</label>
	<input type="text" name="jobtitle" id="jobtitle" value="<?php echo $staff->getJobtitle();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="content">content</label>
	<input type="text" name="content" id="content" value="<?php echo $staff->getContent();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="status">status</label>
	<select name="status" id="status" class="form-control">
	
<option value="active">active</option>
<option value="retired">retired</option>
<option value="left">left</option>
<option value="temp">temp</option>
</select></div>
	
	<div class="form-group">
	<label for="level">level</label>
	<input type="text" name="level" id="level" value="<?php echo $staff->getLevel();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="teamsid">teamsid</label>
	<input type="text" name="teamsid" id="teamsid" value="<?php echo $staff->getTeamsid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="timesheet">timesheet</label>
	<input type="text" name="timesheet" id="timesheet" value="<?php echo $staff->getTimesheet();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="holiday">holiday</label>
	<input type="text" name="holiday" id="holiday" value="<?php echo $staff->getHoliday();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="theme">theme</label>
	<input type="text" name="theme" id="theme" value="<?php echo $staff->getTheme();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
