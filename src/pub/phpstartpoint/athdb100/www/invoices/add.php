<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Invoices.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$invoicesNew = new Invoices();
	$invoicesNew->setCustid($_POST['custid']);
	$invoicesNew->setInvoiceno($_POST['invoiceno']);
	$invoicesNew->setIncept($_POST['incept']);
	$invoicesNew->setPaid($_POST['paid']);
	$invoicesNew->setContent($_POST['content']);
	$invoicesNew->setNotes($_POST['notes']);
	$invoicesNew->setSent($_POST['sent']);

	$invoicesNew->insertIntoDB();
		
	header("Location: /invoices/?ItemAdded=y");

}
$pageTitle = "Invoices Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="invoicesid" id="invoicesid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="custid">custid</label>
	<input type="text" name="custid" id="custid" value="<?php echo $_POST[custid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="invoiceno">invoiceno</label>
	<input type="text" name="invoiceno" id="invoiceno" value="<?php echo $_POST[invoiceno];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $_POST[incept];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="paid">paid</label>
	<input type="text" name="paid" id="paid" value="<?php echo $_POST[paid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="content">content</label>
	<input type="text" name="content" id="content" value="<?php echo $_POST[content];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="notes">notes</label>
	<input type="text" name="notes" id="notes" value="<?php echo $_POST[notes];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="sent">sent</label>
	<input type="text" name="sent" id="sent" value="<?php echo $_POST[sent];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
