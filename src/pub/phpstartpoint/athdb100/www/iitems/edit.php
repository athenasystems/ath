<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Iitems.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$iitemsUpdate = new Iitems();

	$iitemsUpdate->setIitemsid($_POST['iitemsid']);
	$iitemsUpdate->setInvoicesid($_POST['invoicesid']);
	$iitemsUpdate->setQuantity($_POST['quantity']);
	$iitemsUpdate->setJobsid($_POST['jobsid']);
	$iitemsUpdate->setContent($_POST['content']);
	$iitemsUpdate->setPrice($_POST['price']);
	$iitemsUpdate->setHours($_POST['hours']);
	$iitemsUpdate->setRate($_POST['rate']);

	$iitemsUpdate->updateDB();
}
$pageTitle = "Iitems Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";


$iitems = new Iitems();
// Load DB data into object
$iitems->setIitemsid($_GET['id']);
$iitems->loadIitems();
$all = $iitems->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="iitemsid" id="iitemsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="invoicesid">invoicesid</label>
	<input type="text" name="invoicesid" id="invoicesid" value="<?php echo $iitems->getInvoicesid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="quantity">quantity</label>
	<input type="text" name="quantity" id="quantity" value="<?php echo $iitems->getQuantity();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="jobsid">jobsid</label>
	<input type="text" name="jobsid" id="jobsid" value="<?php echo $iitems->getJobsid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="content">content</label>
	<input type="text" name="content" id="content" value="<?php echo $iitems->getContent();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="price">price</label>
	<input type="text" name="price" id="price" value="<?php echo $iitems->getPrice();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="hours">hours</label>
	<input type="text" name="hours" id="hours" value="<?php echo $iitems->getHours();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="rate">rate</label>
	<input type="text" name="rate" id="rate" value="<?php echo $iitems->getRate();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
