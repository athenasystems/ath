<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Qitems.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$qitemsUpdate = new Qitems();

	$qitemsUpdate->setQitemsid($_POST['qitemsid']);
	$qitemsUpdate->setQuotesid($_POST['quotesid']);
	$qitemsUpdate->setItemno($_POST['itemno']);
	$qitemsUpdate->setAgreed($_POST['agreed']);
	$qitemsUpdate->setContent($_POST['content']);
	$qitemsUpdate->setPrice($_POST['price']);
	$qitemsUpdate->setQuantity($_POST['quantity']);
	$qitemsUpdate->setDatereq($_POST['datereq']);
	$qitemsUpdate->setHours($_POST['hours']);
	$qitemsUpdate->setRate($_POST['rate']);

	$qitemsUpdate->updateDB();
}
$pageTitle = "Qitems Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";


$qitems = new Qitems();
// Load DB data into object
$qitems->setQitemsid($_GET['id']);
$qitems->loadQitems();
$all = $qitems->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="qitemsid" id="qitemsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="quotesid">quotesid</label>
	<input type="text" name="quotesid" id="quotesid" value="<?php echo $qitems->getQuotesid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="itemno">itemno</label>
	<input type="text" name="itemno" id="itemno" value="<?php echo $qitems->getItemno();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="agreed">agreed</label>
	<input type="text" name="agreed" id="agreed" value="<?php echo $qitems->getAgreed();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="content">content</label>
	<input type="text" name="content" id="content" value="<?php echo $qitems->getContent();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="price">price</label>
	<input type="text" name="price" id="price" value="<?php echo $qitems->getPrice();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="quantity">quantity</label>
	<input type="text" name="quantity" id="quantity" value="<?php echo $qitems->getQuantity();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="datereq">datereq</label>
	<input type="text" name="datereq" id="datereq" value="<?php echo $qitems->getDatereq();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="hours">hours</label>
	<input type="text" name="hours" id="hours" value="<?php echo $qitems->getHours();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="rate">rate</label>
	<input type="text" name="rate" id="rate" value="<?php echo $qitems->getRate();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
