<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Diary.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$diaryNew = new Diary();
	$diaryNew->setIncept($_POST['incept']);
	$diaryNew->setDuration($_POST['duration']);
	$diaryNew->setTitle($_POST['title']);
	$diaryNew->setContent($_POST['content']);
	$diaryNew->setLocation($_POST['location']);
	$diaryNew->setStaffid($_POST['staffid']);
	$diaryNew->setDone($_POST['done']);
	$diaryNew->setEvery($_POST['every']);
	$diaryNew->setEnd($_POST['end']);
	$diaryNew->setOrigin($_POST['origin']);

	$diaryNew->insertIntoDB();
		
	header("Location: /diary/?ItemAdded=y");

}
$pageTitle = "Diary Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="diaryid" id="diaryid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $_POST[incept];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="duration">duration</label>
	<input type="text" name="duration" id="duration" value="<?php echo $_POST[duration];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="title">title</label>
	<input type="text" name="title" id="title" value="<?php echo $_POST[title];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="content">content</label>
	<input type="text" name="content" id="content" value="<?php echo $_POST[content];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="location">location</label>
	<input type="text" name="location" id="location" value="<?php echo $_POST[location];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="staffid">staffid</label>
	<input type="text" name="staffid" id="staffid" value="<?php echo $_POST[staffid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="done">done</label>
	<input type="text" name="done" id="done" value="<?php echo $_POST[done];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="every">every</label>
	<input type="text" name="every" id="every" value="<?php echo $_POST[every];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="end">end</label>
	<input type="text" name="end" id="end" value="<?php echo $_POST[end];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="origin">origin</label>
	<input type="text" name="origin" id="origin" value="<?php echo $_POST[origin];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
