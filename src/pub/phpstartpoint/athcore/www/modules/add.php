<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Modules.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$modulesNew = new Modules();
	$modulesNew->setName($_POST['name']);
	$modulesNew->setSection($_POST['section']);
	$modulesNew->setPrice($_POST['price']);
	$modulesNew->setDisplay($_POST['display']);
	$modulesNew->setBase($_POST['base']);
	$modulesNew->setUrl($_POST['url']);
	$modulesNew->setOrdernum($_POST['ordernum']);
	$modulesNew->setLevel($_POST['level']);
	$modulesNew->setDescription($_POST['description']);

	$modulesNew->insertIntoDB();
		
	header("Location: /modules/?ItemAdded=y");

}
$pageTitle = "Modules Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="modulesid" id="modulesid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="name">name</label>
	<input type="text" name="name" id="name" value="<?php echo $_POST[name];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="section">section</label>
	<input type="text" name="section" id="section" value="<?php echo $_POST[section];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="price">price</label>
	<input type="text" name="price" id="price" value="<?php echo $_POST[price];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="display">display</label>
	<input type="text" name="display" id="display" value="<?php echo $_POST[display];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="base">base</label>
	<input type="text" name="base" id="base" value="<?php echo $_POST[base];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="url">url</label>
	<input type="text" name="url" id="url" value="<?php echo $_POST[url];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="ordernum">ordernum</label>
	<input type="text" name="ordernum" id="ordernum" value="<?php echo $_POST[ordernum];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="level">level</label>
	<input type="text" name="level" id="level" value="<?php echo $_POST[level];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="description">description</label>
	<input type="text" name="description" id="description" value="<?php echo $_POST[description];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
