<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Mail.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$mailNew = new Mail();
	$mailNew->setAddto($_POST['addto']);
	$mailNew->setAddname($_POST['addname']);
	$mailNew->setSubject($_POST['subject']);
	$mailNew->setBody($_POST['body']);
	$mailNew->setSent($_POST['sent']);
	$mailNew->setIncept($_POST['incept']);
	$mailNew->setTimesent($_POST['timesent']);
	$mailNew->setDocname($_POST['docname']);
	$mailNew->setDoctitle($_POST['doctitle']);
	$mailNew->setKind($_POST['kind']);

	$mailNew->insertIntoDB();
		
	header("Location: /mail/?ItemAdded=y");

}
$pageTitle = "Mail Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="mailid" id="mailid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="addto">addto</label>
	<input type="text" name="addto" id="addto" value="<?php echo $_POST[addto];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="addname">addname</label>
	<input type="text" name="addname" id="addname" value="<?php echo $_POST[addname];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="subject">subject</label>
	<input type="text" name="subject" id="subject" value="<?php echo $_POST[subject];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="body">body</label>
	<input type="text" name="body" id="body" value="<?php echo $_POST[body];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="sent">sent</label>
	<input type="text" name="sent" id="sent" value="<?php echo $_POST[sent];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $_POST[incept];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="timesent">timesent</label>
	<input type="text" name="timesent" id="timesent" value="<?php echo $_POST[timesent];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="docname">docname</label>
	<input type="text" name="docname" id="docname" value="<?php echo $_POST[docname];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="doctitle">doctitle</label>
	<input type="text" name="doctitle" id="doctitle" value="<?php echo $_POST[doctitle];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="kind">kind</label>
	<input type="text" name="kind" id="kind" value="<?php echo $_POST[kind];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
