<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Sitelog.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$sitelogNew = new Sitelog();
	$sitelogNew->setIncept($_POST['incept']);
	$sitelogNew->setStaffid($_POST['staffid']);
	$sitelogNew->setContactsid($_POST['contactsid']);
	$sitelogNew->setLevel($_POST['level']);
	$sitelogNew->setContent($_POST['content']);
	$sitelogNew->setEventsid($_POST['eventsid']);

	$sitelogNew->insertIntoDB();
		
	header("Location: /sitelog/?ItemAdded=y");

}
$pageTitle = "Sitelog Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="sitelogid" id="sitelogid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $_POST[incept];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="staffid">staffid</label>
	<input type="text" name="staffid" id="staffid" value="<?php echo $_POST[staffid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="contactsid">contactsid</label>
	<input type="text" name="contactsid" id="contactsid" value="<?php echo $_POST[contactsid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="level">level</label>
	<input type="text" name="level" id="level" value="<?php echo $_POST[level];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="content">content</label>
	<input type="text" name="content" id="content" value="<?php echo $_POST[content];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="eventsid">eventsid</label>
	<input type="text" name="eventsid" id="eventsid" value="<?php echo $_POST[eventsid];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
