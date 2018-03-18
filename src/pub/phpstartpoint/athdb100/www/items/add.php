<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Items.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$itemsNew = new Items();
	$itemsNew->setPrice($_POST['price']);
	$itemsNew->setIncept($_POST['incept']);
	$itemsNew->setCurrency($_POST['currency']);
	$itemsNew->setContent($_POST['content']);
	$itemsNew->setQitemsid($_POST['qitemsid']);

	$itemsNew->insertIntoDB();
		
	header("Location: /items/?ItemAdded=y");

}
$pageTitle = "Items Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="itemsid" id="itemsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="price">price</label>
	<input type="text" name="price" id="price" value="<?php echo $_POST[price];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $_POST[incept];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="currency">currency</label>
	<input type="text" name="currency" id="currency" value="<?php echo $_POST[currency];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="content">content</label>
	<input type="text" name="content" id="content" value="<?php echo $_POST[content];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="qitemsid">qitemsid</label>
	<input type="text" name="qitemsid" id="qitemsid" value="<?php echo $_POST[qitemsid];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
