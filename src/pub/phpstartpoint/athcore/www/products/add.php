<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Products.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$productsNew = new Products();
	$productsNew->setName($_POST['name']);
	$productsNew->setPrice($_POST['price']);
	$productsNew->setSetup($_POST['setup']);
	$productsNew->setDiscount($_POST['discount']);
	$productsNew->setOption($_POST['option']);

	$productsNew->insertIntoDB();
		
	header("Location: /products/?ItemAdded=y");

}
$pageTitle = "Products Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="productsid" id="productsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="name">name</label>
	<input type="text" name="name" id="name" value="<?php echo $_POST[name];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="price">price</label>
	<input type="text" name="price" id="price" value="<?php echo $_POST[price];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="setup">setup</label>
	<input type="text" name="setup" id="setup" value="<?php echo $_POST[setup];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="discount">discount</label>
	<input type="text" name="discount" id="discount" value="<?php echo $_POST[discount];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="option">option</label>
	<input type="text" name="option" id="option" value="<?php echo $_POST[option];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
