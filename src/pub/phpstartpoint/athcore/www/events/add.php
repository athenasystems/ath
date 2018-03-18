<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Events.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$eventsNew = new Events();
	$eventsNew->setName($_POST['name']);

	$eventsNew->insertIntoDB();
		
	header("Location: /events/?ItemAdded=y");

}
$pageTitle = "Events Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="eventsid" id="eventsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="name">name</label>
	<input type="text" name="name" id="name" value="<?php echo $_POST[name];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
