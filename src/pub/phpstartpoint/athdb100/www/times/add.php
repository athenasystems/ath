<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Times.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$timesNew = new Times();
	$timesNew->setStaffid($_POST['staffid']);
	$timesNew->setIncept($_POST['incept']);
	$timesNew->setStart($_POST['start']);
	$timesNew->setFinish($_POST['finish']);
	$timesNew->setNotes($_POST['notes']);
	$timesNew->setDay($_POST['day']);
	$timesNew->setTimes_typesid($_POST['times_typesid']);
	$timesNew->setLstart($_POST['lstart']);
	$timesNew->setLfinish($_POST['lfinish']);

	$timesNew->insertIntoDB();
		
	header("Location: /times/?ItemAdded=y");

}
$pageTitle = "Times Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="timesid" id="timesid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="staffid">staffid</label>
	<input type="text" name="staffid" id="staffid" value="<?php echo $_POST[staffid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $_POST[incept];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="start">start</label>
	<input type="text" name="start" id="start" value="<?php echo $_POST[start];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="finish">finish</label>
	<input type="text" name="finish" id="finish" value="<?php echo $_POST[finish];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="notes">notes</label>
	<input type="text" name="notes" id="notes" value="<?php echo $_POST[notes];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="day">day</label>
	<input type="text" name="day" id="day" value="<?php echo $_POST[day];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="times_typesid">times_typesid</label>
	<input type="text" name="times_typesid" id="times_typesid" value="<?php echo $_POST[times_typesid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="lstart">lstart</label>
	<input type="text" name="lstart" id="lstart" value="<?php echo $_POST[lstart];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="lfinish">lfinish</label>
	<input type="text" name="lfinish" id="lfinish" value="<?php echo $_POST[lfinish];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
