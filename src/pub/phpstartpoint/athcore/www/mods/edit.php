<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Mods.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$modsUpdate = new Mods();

	$modsUpdate->setModsid($_POST['modsid']);
	$modsUpdate->setSitesid($_POST['sitesid']);
	$modsUpdate->setModulesid($_POST['modulesid']);

	$modsUpdate->updateDB();
}
$pageTitle = "Mods Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php";


$mods = new Mods();
// Load DB data into object
$mods->setModsid($_GET['id']);
$mods->loadMods();
$all = $mods->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="modsid" id="modsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="sitesid">sitesid</label>
	<input type="text" name="sitesid" id="sitesid" value="<?php echo $mods->getSitesid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="modulesid">modulesid</label>
	<input type="text" name="modulesid" id="modulesid" value="<?php echo $mods->getModulesid();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
