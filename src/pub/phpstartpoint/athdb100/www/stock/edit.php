<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Stock.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$stockUpdate = new Stock();

	$stockUpdate->setStockid($_POST['stockid']);
	$stockUpdate->setSku($_POST['sku']);
	$stockUpdate->setName($_POST['name']);
	$stockUpdate->setDescription($_POST['description']);
	$stockUpdate->setStockq($_POST['stockq']);
	$stockUpdate->setPrice($_POST['price']);
	$stockUpdate->setCopytitle($_POST['copytitle']);
	$stockUpdate->setCopybody($_POST['copybody']);
	$stockUpdate->setCopyfeatures($_POST['copyfeatures']);
	$stockUpdate->setCopyterms($_POST['copyterms']);
	$stockUpdate->setCopyimage($_POST['copyimage']);

	$stockUpdate->updateDB();
}
$pageTitle = "Stock Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";


$stock = new Stock();
// Load DB data into object
$stock->setStockid($_GET['id']);
$stock->loadStock();
$all = $stock->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="stockid" id="stockid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="sku">sku</label>
	<input type="text" name="sku" id="sku" value="<?php echo $stock->getSku();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="name">name</label>
	<input type="text" name="name" id="name" value="<?php echo $stock->getName();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="description">description</label>
	<input type="text" name="description" id="description" value="<?php echo $stock->getDescription();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="stockq">stockq</label>
	<input type="text" name="stockq" id="stockq" value="<?php echo $stock->getStockq();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="price">price</label>
	<input type="text" name="price" id="price" value="<?php echo $stock->getPrice();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="copytitle">copytitle</label>
	<input type="text" name="copytitle" id="copytitle" value="<?php echo $stock->getCopytitle();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="copybody">copybody</label>
	<input type="text" name="copybody" id="copybody" value="<?php echo $stock->getCopybody();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="copyfeatures">copyfeatures</label>
	<input type="text" name="copyfeatures" id="copyfeatures" value="<?php echo $stock->getCopyfeatures();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="copyterms">copyterms</label>
	<input type="text" name="copyterms" id="copyterms" value="<?php echo $stock->getCopyterms();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="copyimage">copyimage</label>
	<input type="text" name="copyimage" id="copyimage" value="<?php echo $stock->getCopyimage();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
