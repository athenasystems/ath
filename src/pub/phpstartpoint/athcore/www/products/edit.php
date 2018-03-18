<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Products.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$productsUpdate = new Products();

	$productsUpdate->setProductsid($_POST['productsid']);
	$productsUpdate->setName($_POST['name']);
	$productsUpdate->setPrice($_POST['price']);
	$productsUpdate->setSetup($_POST['setup']);
	$productsUpdate->setDiscount($_POST['discount']);
	$productsUpdate->setOption($_POST['option']);

	$productsUpdate->updateDB();
}
$pageTitle = "Products Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php";


$products = new Products();
// Load DB data into object
$products->setProductsid($_GET['id']);
$products->loadProducts();
$all = $products->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="productsid" id="productsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="name">name</label>
	<input type="text" name="name" id="name" value="<?php echo $products->getName();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="price">price</label>
	<input type="text" name="price" id="price" value="<?php echo $products->getPrice();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="setup">setup</label>
	<input type="text" name="setup" id="setup" value="<?php echo $products->getSetup();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="discount">discount</label>
	<input type="text" name="discount" id="discount" value="<?php echo $products->getDiscount();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="option">option</label>
	<input type="text" name="option" id="option" value="<?php echo $products->getOption();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
