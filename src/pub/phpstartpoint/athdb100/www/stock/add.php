<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Stock.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$stockNew = new Stock();
	$stockNew->setSku($_POST['sku']);
	$stockNew->setName($_POST['name']);
	$stockNew->setDescription($_POST['description']);
	$stockNew->setStockq($_POST['stockq']);
	$stockNew->setPrice($_POST['price']);
	$stockNew->setCopytitle($_POST['copytitle']);
	$stockNew->setCopybody($_POST['copybody']);
	$stockNew->setCopyfeatures($_POST['copyfeatures']);
	$stockNew->setCopyterms($_POST['copyterms']);
	$stockNew->setCopyimage($_POST['copyimage']);

	$stockNew->insertIntoDB();
		
	header("Location: /stock/?ItemAdded=y");

}
$pageTitle = "Stock Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="stockid" id="stockid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="sku">sku</label>
	<input type="text" name="sku" id="sku" value="<?php echo $_POST[sku];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="name">name</label>
	<input type="text" name="name" id="name" value="<?php echo $_POST[name];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="description">description</label>
	<input type="text" name="description" id="description" value="<?php echo $_POST[description];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="stockq">stockq</label>
	<input type="text" name="stockq" id="stockq" value="<?php echo $_POST[stockq];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="price">price</label>
	<input type="text" name="price" id="price" value="<?php echo $_POST[price];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="copytitle">copytitle</label>
	<input type="text" name="copytitle" id="copytitle" value="<?php echo $_POST[copytitle];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="copybody">copybody</label>
	<input type="text" name="copybody" id="copybody" value="<?php echo $_POST[copybody];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="copyfeatures">copyfeatures</label>
	<input type="text" name="copyfeatures" id="copyfeatures" value="<?php echo $_POST[copyfeatures];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="copyterms">copyterms</label>
	<input type="text" name="copyterms" id="copyterms" value="<?php echo $_POST[copyterms];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="copyimage">copyimage</label>
	<input type="text" name="copyimage" id="copyimage" value="<?php echo $_POST[copyimage];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
