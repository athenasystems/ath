<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Events.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$eventsUpdate = new Events();

	$eventsUpdate->setEventsid($_POST['eventsid']);
	$eventsUpdate->setName($_POST['name']);

	$eventsUpdate->updateDB();
}
$pageTitle = "Events Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php";


$events = new Events();
// Load DB data into object
$events->setEventsid($_GET['id']);
$events->loadEvents();
$all = $events->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="eventsid" id="eventsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="name">name</label>
	<input type="text" name="name" id="name" value="<?php echo $events->getName();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
