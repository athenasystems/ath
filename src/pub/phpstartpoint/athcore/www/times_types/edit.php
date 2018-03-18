<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Times_types.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$times_typesUpdate = new Times_types();

	$times_typesUpdate->setTimes_typesid($_POST['times_typesid']);
	$times_typesUpdate->setSitesid($_POST['sitesid']);
	$times_typesUpdate->setName($_POST['name']);

	$times_typesUpdate->updateDB();
}
$pageTitle = "Times_types Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php";


$times_types = new Times_types();
// Load DB data into object
$times_types->setTimes_typesid($_GET['id']);
$times_types->loadTimes_types();
$all = $times_types->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="times_typesid" id="times_typesid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="sitesid">sitesid</label>
	<input type="text" name="sitesid" id="sitesid" value="<?php echo $times_types->getSitesid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="name">name</label>
	<input type="text" name="name" id="name" value="<?php echo $times_types->getName();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
