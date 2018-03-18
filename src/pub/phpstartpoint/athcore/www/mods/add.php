<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Mods.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$modsNew = new Mods();
	$modsNew->setSitesid($_POST['sitesid']);
	$modsNew->setModulesid($_POST['modulesid']);

	$modsNew->insertIntoDB();
		
	header("Location: /mods/?ItemAdded=y");

}
$pageTitle = "Mods Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="modsid" id="modsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="sitesid">sitesid</label>
	<input type="text" name="sitesid" id="sitesid" value="<?php echo $_POST[sitesid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="modulesid">modulesid</label>
	<input type="text" name="modulesid" id="modulesid" value="<?php echo $_POST[modulesid];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
