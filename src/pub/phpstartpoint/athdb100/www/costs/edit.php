<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Costs.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$costsUpdate = new Costs();

	$costsUpdate->setCostsid($_POST['costsid']);
	$costsUpdate->setExpsid($_POST['expsid']);
	$costsUpdate->setDescription($_POST['description']);
	$costsUpdate->setPrice($_POST['price']);
	$costsUpdate->setIncept($_POST['incept']);
	$costsUpdate->setSupplier($_POST['supplier']);

	$costsUpdate->updateDB();
}
$pageTitle = "Costs Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";


$costs = new Costs();
// Load DB data into object
$costs->setCostsid($_GET['id']);
$costs->loadCosts();
$all = $costs->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="costsid" id="costsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="expsid">expsid</label>
	<input type="text" name="expsid" id="expsid" value="<?php echo $costs->getExpsid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="description">description</label>
	<input type="text" name="description" id="description" value="<?php echo $costs->getDescription();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="price">price</label>
	<input type="text" name="price" id="price" value="<?php echo $costs->getPrice();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $costs->getIncept();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="supplier">supplier</label>
	<input type="text" name="supplier" id="supplier" value="<?php echo $costs->getSupplier();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
