<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Jobs.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$jobsNew = new Jobs();
	$jobsNew->setCustid($_POST['custid']);
	$jobsNew->setItemsid($_POST['itemsid']);
	$jobsNew->setQuantity($_POST['quantity']);
	$jobsNew->setInvoicesid($_POST['invoicesid']);
	$jobsNew->setJobno($_POST['jobno']);
	$jobsNew->setIncept($_POST['incept']);
	$jobsNew->setDone($_POST['done']);
	$jobsNew->setNotes($_POST['notes']);
	$jobsNew->setCustref($_POST['custref']);
	$jobsNew->setDatedel($_POST['datedel']);
	$jobsNew->setDatereq($_POST['datereq']);

	$jobsNew->insertIntoDB();
		
	header("Location: /jobs/?ItemAdded=y");

}
$pageTitle = "Jobs Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="jobsid" id="jobsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="custid">custid</label>
	<input type="text" name="custid" id="custid" value="<?php echo $_POST[custid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="itemsid">itemsid</label>
	<input type="text" name="itemsid" id="itemsid" value="<?php echo $_POST[itemsid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="quantity">quantity</label>
	<input type="text" name="quantity" id="quantity" value="<?php echo $_POST[quantity];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="invoicesid">invoicesid</label>
	<input type="text" name="invoicesid" id="invoicesid" value="<?php echo $_POST[invoicesid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="jobno">jobno</label>
	<input type="text" name="jobno" id="jobno" value="<?php echo $_POST[jobno];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $_POST[incept];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="done">done</label>
	<input type="text" name="done" id="done" value="<?php echo $_POST[done];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="notes">notes</label>
	<input type="text" name="notes" id="notes" value="<?php echo $_POST[notes];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="custref">custref</label>
	<input type="text" name="custref" id="custref" value="<?php echo $_POST[custref];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="datedel">datedel</label>
	<input type="text" name="datedel" id="datedel" value="<?php echo $_POST[datedel];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="datereq">datereq</label>
	<input type="text" name="datereq" id="datereq" value="<?php echo $_POST[datereq];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
