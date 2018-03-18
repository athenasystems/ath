<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Iitems.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$iitemsNew = new Iitems();
	$iitemsNew->setInvoicesid($_POST['invoicesid']);
	$iitemsNew->setQuantity($_POST['quantity']);
	$iitemsNew->setJobsid($_POST['jobsid']);
	$iitemsNew->setContent($_POST['content']);
	$iitemsNew->setPrice($_POST['price']);
	$iitemsNew->setHours($_POST['hours']);
	$iitemsNew->setRate($_POST['rate']);

	$iitemsNew->insertIntoDB();
		
	header("Location: /iitems/?ItemAdded=y");

}
$pageTitle = "Iitems Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="iitemsid" id="iitemsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="invoicesid">invoicesid</label>
	<input type="text" name="invoicesid" id="invoicesid" value="<?php echo $_POST[invoicesid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="quantity">quantity</label>
	<input type="text" name="quantity" id="quantity" value="<?php echo $_POST[quantity];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="jobsid">jobsid</label>
	<input type="text" name="jobsid" id="jobsid" value="<?php echo $_POST[jobsid];?>" class="form-control">
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
