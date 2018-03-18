<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Modules.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$modulesUpdate = new Modules();

	$modulesUpdate->setModulesid($_POST['modulesid']);
	$modulesUpdate->setName($_POST['name']);
	$modulesUpdate->setSection($_POST['section']);
	$modulesUpdate->setPrice($_POST['price']);
	$modulesUpdate->setDisplay($_POST['display']);
	$modulesUpdate->setBase($_POST['base']);
	$modulesUpdate->setUrl($_POST['url']);
	$modulesUpdate->setOrdernum($_POST['ordernum']);
	$modulesUpdate->setLevel($_POST['level']);
	$modulesUpdate->setDescription($_POST['description']);

	$modulesUpdate->updateDB();
}
$pageTitle = "Modules Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php";


$modules = new Modules();
// Load DB data into object
$modules->setModulesid($_GET['id']);
$modules->loadModules();
$all = $modules->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="modulesid" id="modulesid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="name">name</label>
	<input type="text" name="name" id="name" value="<?php echo $modules->getName();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="section">section</label>
	<input type="text" name="section" id="section" value="<?php echo $modules->getSection();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="price">price</label>
	<input type="text" name="price" id="price" value="<?php echo $modules->getPrice();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="display">display</label>
	<input type="text" name="display" id="display" value="<?php echo $modules->getDisplay();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="base">base</label>
	<input type="text" name="base" id="base" value="<?php echo $modules->getBase();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="url">url</label>
	<input type="text" name="url" id="url" value="<?php echo $modules->getUrl();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="ordernum">ordernum</label>
	<input type="text" name="ordernum" id="ordernum" value="<?php echo $modules->getOrdernum();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="level">level</label>
	<input type="text" name="level" id="level" value="<?php echo $modules->getLevel();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="description">description</label>
	<input type="text" name="description" id="description" value="<?php echo $modules->getDescription();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
