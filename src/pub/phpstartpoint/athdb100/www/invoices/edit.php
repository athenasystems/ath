<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Invoices.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$invoicesUpdate = new Invoices();

	$invoicesUpdate->setInvoicesid($_POST['invoicesid']);
	$invoicesUpdate->setCustid($_POST['custid']);
	$invoicesUpdate->setInvoiceno($_POST['invoiceno']);
	$invoicesUpdate->setIncept($_POST['incept']);
	$invoicesUpdate->setPaid($_POST['paid']);
	$invoicesUpdate->setContent($_POST['content']);
	$invoicesUpdate->setNotes($_POST['notes']);
	$invoicesUpdate->setSent($_POST['sent']);

	$invoicesUpdate->updateDB();
}
$pageTitle = "Invoices Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";


$invoices = new Invoices();
// Load DB data into object
$invoices->setInvoicesid($_GET['id']);
$invoices->loadInvoices();
$all = $invoices->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="invoicesid" id="invoicesid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="custid">custid</label>
	<input type="text" name="custid" id="custid" value="<?php echo $invoices->getCustid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="invoiceno">invoiceno</label>
	<input type="text" name="invoiceno" id="invoiceno" value="<?php echo $invoices->getInvoiceno();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $invoices->getIncept();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="paid">paid</label>
	<input type="text" name="paid" id="paid" value="<?php echo $invoices->getPaid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="content">content</label>
	<input type="text" name="content" id="content" value="<?php echo $invoices->getContent();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="notes">notes</label>
	<input type="text" name="notes" id="notes" value="<?php echo $invoices->getNotes();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="sent">sent</label>
	<input type="text" name="sent" id="sent" value="<?php echo $invoices->getSent();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
