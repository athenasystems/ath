<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Sales.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$salesUpdate = new Sales();

	$salesUpdate->setSalesid($_POST['salesid']);
	$salesUpdate->setSitesid($_POST['sitesid']);
	$salesUpdate->setProductsid($_POST['productsid']);
	$salesUpdate->setIncept($_POST['incept']);

	$salesUpdate->updateDB();
}
$pageTitle = "Sales Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php";


$sales = new Sales();
// Load DB data into object
$sales->setSalesid($_GET['id']);
$sales->loadSales();
$all = $sales->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="salesid" id="salesid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="sitesid">sitesid</label>
	<input type="text" name="sitesid" id="sitesid" value="<?php echo $sales->getSitesid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="productsid">productsid</label>
	<input type="text" name="productsid" id="productsid" value="<?php echo $sales->getProductsid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $sales->getIncept();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
