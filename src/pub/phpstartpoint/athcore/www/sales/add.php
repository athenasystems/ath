<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Sales.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$salesNew = new Sales();
	$salesNew->setSitesid($_POST['sitesid']);
	$salesNew->setProductsid($_POST['productsid']);
	$salesNew->setIncept($_POST['incept']);

	$salesNew->insertIntoDB();
		
	header("Location: /sales/?ItemAdded=y");

}
$pageTitle = "Sales Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="salesid" id="salesid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="sitesid">sitesid</label>
	<input type="text" name="sitesid" id="sitesid" value="<?php echo $_POST[sitesid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="productsid">productsid</label>
	<input type="text" name="productsid" id="productsid" value="<?php echo $_POST[productsid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $_POST[incept];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
