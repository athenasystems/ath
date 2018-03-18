<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Sitelog.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$sitelogUpdate = new Sitelog();

	$sitelogUpdate->setSitelogid($_POST['sitelogid']);
	$sitelogUpdate->setIncept($_POST['incept']);
	$sitelogUpdate->setStaffid($_POST['staffid']);
	$sitelogUpdate->setContactsid($_POST['contactsid']);
	$sitelogUpdate->setLevel($_POST['level']);
	$sitelogUpdate->setContent($_POST['content']);
	$sitelogUpdate->setEventsid($_POST['eventsid']);

	$sitelogUpdate->updateDB();
}
$pageTitle = "Sitelog Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";


$sitelog = new Sitelog();
// Load DB data into object
$sitelog->setSitelogid($_GET['id']);
$sitelog->loadSitelog();
$all = $sitelog->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="sitelogid" id="sitelogid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $sitelog->getIncept();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="staffid">staffid</label>
	<input type="text" name="staffid" id="staffid" value="<?php echo $sitelog->getStaffid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="contactsid">contactsid</label>
	<input type="text" name="contactsid" id="contactsid" value="<?php echo $sitelog->getContactsid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="level">level</label>
	<input type="text" name="level" id="level" value="<?php echo $sitelog->getLevel();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="content">content</label>
	<input type="text" name="content" id="content" value="<?php echo $sitelog->getContent();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="eventsid">eventsid</label>
	<input type="text" name="eventsid" id="eventsid" value="<?php echo $sitelog->getEventsid();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
