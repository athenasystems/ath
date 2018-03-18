<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Costs.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$costsNew = new Costs();
	$costsNew->setExpsid($_POST['expsid']);
	$costsNew->setDescription($_POST['description']);
	$costsNew->setPrice($_POST['price']);
	$costsNew->setIncept($_POST['incept']);
	$costsNew->setSupplier($_POST['supplier']);

	$costsNew->insertIntoDB();
		
	header("Location: /costs/?ItemAdded=y");

}
$pageTitle = "Costs Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="costsid" id="costsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="expsid">expsid</label>
	<input type="text" name="expsid" id="expsid" value="<?php echo $_POST[expsid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="description">description</label>
	<input type="text" name="description" id="description" value="<?php echo $_POST[description];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="price">price</label>
	<input type="text" name="price" id="price" value="<?php echo $_POST[price];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $_POST[incept];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="supplier">supplier</label>
	<input type="text" name="supplier" id="supplier" value="<?php echo $_POST[supplier];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
