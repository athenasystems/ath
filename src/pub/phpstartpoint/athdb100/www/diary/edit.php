<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Diary.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$diaryUpdate = new Diary();

	$diaryUpdate->setDiaryid($_POST['diaryid']);
	$diaryUpdate->setIncept($_POST['incept']);
	$diaryUpdate->setDuration($_POST['duration']);
	$diaryUpdate->setTitle($_POST['title']);
	$diaryUpdate->setContent($_POST['content']);
	$diaryUpdate->setLocation($_POST['location']);
	$diaryUpdate->setStaffid($_POST['staffid']);
	$diaryUpdate->setDone($_POST['done']);
	$diaryUpdate->setEvery($_POST['every']);
	$diaryUpdate->setEnd($_POST['end']);
	$diaryUpdate->setOrigin($_POST['origin']);

	$diaryUpdate->updateDB();
}
$pageTitle = "Diary Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";


$diary = new Diary();
// Load DB data into object
$diary->setDiaryid($_GET['id']);
$diary->loadDiary();
$all = $diary->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="diaryid" id="diaryid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $diary->getIncept();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="duration">duration</label>
	<input type="text" name="duration" id="duration" value="<?php echo $diary->getDuration();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="title">title</label>
	<input type="text" name="title" id="title" value="<?php echo $diary->getTitle();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="content">content</label>
	<input type="text" name="content" id="content" value="<?php echo $diary->getContent();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="location">location</label>
	<input type="text" name="location" id="location" value="<?php echo $diary->getLocation();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="staffid">staffid</label>
	<input type="text" name="staffid" id="staffid" value="<?php echo $diary->getStaffid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="done">done</label>
	<input type="text" name="done" id="done" value="<?php echo $diary->getDone();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="every">every</label>
	<input type="text" name="every" id="every" value="<?php echo $diary->getEvery();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="end">end</label>
	<input type="text" name="end" id="end" value="<?php echo $diary->getEnd();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="origin">origin</label>
	<input type="text" name="origin" id="origin" value="<?php echo $diary->getOrigin();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
