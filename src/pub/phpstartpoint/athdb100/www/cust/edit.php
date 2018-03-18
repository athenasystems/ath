<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Cust.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$custUpdate = new Cust();

	$custUpdate->setCustid($_POST['custid']);
	$custUpdate->setFname($_POST['fname']);
	$custUpdate->setSname($_POST['sname']);
	$custUpdate->setCo_name($_POST['co_name']);
	$custUpdate->setContact($_POST['contact']);
	$custUpdate->setAddsid($_POST['addsid']);
	$custUpdate->setInv_email($_POST['inv_email']);
	$custUpdate->setInv_contact($_POST['inv_contact']);
	$custUpdate->setColour($_POST['colour']);
	$custUpdate->setFilestr($_POST['filestr']);
	$custUpdate->setLive($_POST['live']);

	$custUpdate->updateDB();
}
$pageTitle = "Cust Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";


$cust = new Cust();
// Load DB data into object
$cust->setCustid($_GET['id']);
$cust->loadCust();
$all = $cust->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="custid" id="custid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="fname">fname</label>
	<input type="text" name="fname" id="fname" value="<?php echo $cust->getFname();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="sname">sname</label>
	<input type="text" name="sname" id="sname" value="<?php echo $cust->getSname();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="co_name">co_name</label>
	<input type="text" name="co_name" id="co_name" value="<?php echo $cust->getCo_name();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="contact">contact</label>
	<input type="text" name="contact" id="contact" value="<?php echo $cust->getContact();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="addsid">addsid</label>
	<input type="text" name="addsid" id="addsid" value="<?php echo $cust->getAddsid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="inv_email">inv_email</label>
	<input type="text" name="inv_email" id="inv_email" value="<?php echo $cust->getInv_email();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="inv_contact">inv_contact</label>
	<input type="text" name="inv_contact" id="inv_contact" value="<?php echo $cust->getInv_contact();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="colour">colour</label>
	<input type="text" name="colour" id="colour" value="<?php echo $cust->getColour();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="filestr">filestr</label>
	<input type="text" name="filestr" id="filestr" value="<?php echo $cust->getFilestr();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="live">live</label>
	<input type="text" name="live" id="live" value="<?php echo $cust->getLive();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
