<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Staff.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$staffNew = new Staff();
	$staffNew->setFname($_POST['fname']);
	$staffNew->setSname($_POST['sname']);
	$staffNew->setAddsid($_POST['addsid']);
	$staffNew->setNotes($_POST['notes']);
	$staffNew->setJobtitle($_POST['jobtitle']);
	$staffNew->setContent($_POST['content']);
	$staffNew->setStatus($_POST['status']);
	$staffNew->setLevel($_POST['level']);
	$staffNew->setTeamsid($_POST['teamsid']);
	$staffNew->setTimesheet($_POST['timesheet']);
	$staffNew->setHoliday($_POST['holiday']);
	$staffNew->setTheme($_POST['theme']);

	$staffNew->insertIntoDB();
		
	header("Location: /staff/?ItemAdded=y");

}
$pageTitle = "Staff Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="staffid" id="staffid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="fname">fname</label>
	<input type="text" name="fname" id="fname" value="<?php echo $_POST[fname];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="sname">sname</label>
	<input type="text" name="sname" id="sname" value="<?php echo $_POST[sname];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="addsid">addsid</label>
	<input type="text" name="addsid" id="addsid" value="<?php echo $_POST[addsid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="notes">notes</label>
	<input type="text" name="notes" id="notes" value="<?php echo $_POST[notes];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="jobtitle">jobtitle</label>
	<input type="text" name="jobtitle" id="jobtitle" value="<?php echo $_POST[jobtitle];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="content">content</label>
	<input type="text" name="content" id="content" value="<?php echo $_POST[content];?>" class="form-control">
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
	<input type="text" name="level" id="level" value="<?php echo $_POST[level];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="teamsid">teamsid</label>
	<input type="text" name="teamsid" id="teamsid" value="<?php echo $_POST[teamsid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="timesheet">timesheet</label>
	<input type="text" name="timesheet" id="timesheet" value="<?php echo $_POST[timesheet];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="holiday">holiday</label>
	<input type="text" name="holiday" id="holiday" value="<?php echo $_POST[holiday];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="theme">theme</label>
	<input type="text" name="theme" id="theme" value="<?php echo $_POST[theme];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
