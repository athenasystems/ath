<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Items.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$itemsUpdate = new Items();

	$itemsUpdate->setItemsid($_POST['itemsid']);
	$itemsUpdate->setPrice($_POST['price']);
	$itemsUpdate->setIncept($_POST['incept']);
	$itemsUpdate->setCurrency($_POST['currency']);
	$itemsUpdate->setContent($_POST['content']);
	$itemsUpdate->setQitemsid($_POST['qitemsid']);

	$itemsUpdate->updateDB();
}
$pageTitle = "Items Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";


$items = new Items();
// Load DB data into object
$items->setItemsid($_GET['id']);
$items->loadItems();
$all = $items->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="itemsid" id="itemsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="price">price</label>
	<input type="text" name="price" id="price" value="<?php echo $items->getPrice();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $items->getIncept();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="currency">currency</label>
	<input type="text" name="currency" id="currency" value="<?php echo $items->getCurrency();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="content">content</label>
	<input type="text" name="content" id="content" value="<?php echo $items->getContent();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="qitemsid">qitemsid</label>
	<input type="text" name="qitemsid" id="qitemsid" value="<?php echo $items->getQitemsid();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
