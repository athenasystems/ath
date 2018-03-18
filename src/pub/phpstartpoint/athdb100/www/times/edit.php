<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Times.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$timesUpdate = new Times();

	$timesUpdate->setTimesid($_POST['timesid']);
	$timesUpdate->setStaffid($_POST['staffid']);
	$timesUpdate->setIncept($_POST['incept']);
	$timesUpdate->setStart($_POST['start']);
	$timesUpdate->setFinish($_POST['finish']);
	$timesUpdate->setNotes($_POST['notes']);
	$timesUpdate->setDay($_POST['day']);
	$timesUpdate->setTimes_typesid($_POST['times_typesid']);
	$timesUpdate->setLstart($_POST['lstart']);
	$timesUpdate->setLfinish($_POST['lfinish']);

	$timesUpdate->updateDB();
}
$pageTitle = "Times Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";


$times = new Times();
// Load DB data into object
$times->setTimesid($_GET['id']);
$times->loadTimes();
$all = $times->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="timesid" id="timesid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="staffid">staffid</label>
	<input type="text" name="staffid" id="staffid" value="<?php echo $times->getStaffid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $times->getIncept();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="start">start</label>
	<input type="text" name="start" id="start" value="<?php echo $times->getStart();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="finish">finish</label>
	<input type="text" name="finish" id="finish" value="<?php echo $times->getFinish();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="notes">notes</label>
	<input type="text" name="notes" id="notes" value="<?php echo $times->getNotes();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="day">day</label>
	<input type="text" name="day" id="day" value="<?php echo $times->getDay();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="times_typesid">times_typesid</label>
	<input type="text" name="times_typesid" id="times_typesid" value="<?php echo $times->getTimes_typesid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="lstart">lstart</label>
	<input type="text" name="lstart" id="lstart" value="<?php echo $times->getLstart();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="lfinish">lfinish</label>
	<input type="text" name="lfinish" id="lfinish" value="<?php echo $times->getLfinish();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
