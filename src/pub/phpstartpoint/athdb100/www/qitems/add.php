<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Qitems.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$qitemsNew = new Qitems();
	$qitemsNew->setQuotesid($_POST['quotesid']);
	$qitemsNew->setItemno($_POST['itemno']);
	$qitemsNew->setAgreed($_POST['agreed']);
	$qitemsNew->setContent($_POST['content']);
	$qitemsNew->setPrice($_POST['price']);
	$qitemsNew->setQuantity($_POST['quantity']);
	$qitemsNew->setDatereq($_POST['datereq']);
	$qitemsNew->setHours($_POST['hours']);
	$qitemsNew->setRate($_POST['rate']);

	$qitemsNew->insertIntoDB();
		
	header("Location: /qitems/?ItemAdded=y");

}
$pageTitle = "Qitems Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="qitemsid" id="qitemsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="quotesid">quotesid</label>
	<input type="text" name="quotesid" id="quotesid" value="<?php echo $_POST[quotesid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="itemno">itemno</label>
	<input type="text" name="itemno" id="itemno" value="<?php echo $_POST[itemno];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="agreed">agreed</label>
	<input type="text" name="agreed" id="agreed" value="<?php echo $_POST[agreed];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="content">content</label>
	<input type="text" name="content" id="content" value="<?php echo $_POST[content];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="price">price</label>
	<input type="text" name="price" id="price" value="<?php echo $_POST[price];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="quantity">quantity</label>
	<input type="text" name="quantity" id="quantity" value="<?php echo $_POST[quantity];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="datereq">datereq</label>
	<input type="text" name="datereq" id="datereq" value="<?php echo $_POST[datereq];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="hours">hours</label>
	<input type="text" name="hours" id="hours" value="<?php echo $_POST[hours];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="rate">rate</label>
	<input type="text" name="rate" id="rate" value="<?php echo $_POST[rate];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
