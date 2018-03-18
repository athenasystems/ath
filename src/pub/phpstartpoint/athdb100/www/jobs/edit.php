<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Jobs.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$jobsUpdate = new Jobs();

	$jobsUpdate->setJobsid($_POST['jobsid']);
	$jobsUpdate->setCustid($_POST['custid']);
	$jobsUpdate->setItemsid($_POST['itemsid']);
	$jobsUpdate->setQuantity($_POST['quantity']);
	$jobsUpdate->setInvoicesid($_POST['invoicesid']);
	$jobsUpdate->setJobno($_POST['jobno']);
	$jobsUpdate->setIncept($_POST['incept']);
	$jobsUpdate->setDone($_POST['done']);
	$jobsUpdate->setNotes($_POST['notes']);
	$jobsUpdate->setCustref($_POST['custref']);
	$jobsUpdate->setDatedel($_POST['datedel']);
	$jobsUpdate->setDatereq($_POST['datereq']);

	$jobsUpdate->updateDB();
}
$pageTitle = "Jobs Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";


$jobs = new Jobs();
// Load DB data into object
$jobs->setJobsid($_GET['id']);
$jobs->loadJobs();
$all = $jobs->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="jobsid" id="jobsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="custid">custid</label>
	<input type="text" name="custid" id="custid" value="<?php echo $jobs->getCustid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="itemsid">itemsid</label>
	<input type="text" name="itemsid" id="itemsid" value="<?php echo $jobs->getItemsid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="quantity">quantity</label>
	<input type="text" name="quantity" id="quantity" value="<?php echo $jobs->getQuantity();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="invoicesid">invoicesid</label>
	<input type="text" name="invoicesid" id="invoicesid" value="<?php echo $jobs->getInvoicesid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="jobno">jobno</label>
	<input type="text" name="jobno" id="jobno" value="<?php echo $jobs->getJobno();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $jobs->getIncept();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="done">done</label>
	<input type="text" name="done" id="done" value="<?php echo $jobs->getDone();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="notes">notes</label>
	<input type="text" name="notes" id="notes" value="<?php echo $jobs->getNotes();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="custref">custref</label>
	<input type="text" name="custref" id="custref" value="<?php echo $jobs->getCustref();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="datedel">datedel</label>
	<input type="text" name="datedel" id="datedel" value="<?php echo $jobs->getDatedel();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="datereq">datereq</label>
	<input type="text" name="datereq" id="datereq" value="<?php echo $jobs->getDatereq();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
