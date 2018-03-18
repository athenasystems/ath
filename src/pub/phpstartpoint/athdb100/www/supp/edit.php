<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Supp.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$suppUpdate = new Supp();

	$suppUpdate->setSuppid($_POST['suppid']);
	$suppUpdate->setCo_name($_POST['co_name']);
	$suppUpdate->setFname($_POST['fname']);
	$suppUpdate->setSname($_POST['sname']);
	$suppUpdate->setContact($_POST['contact']);
	$suppUpdate->setAddsid($_POST['addsid']);
	$suppUpdate->setInv_email($_POST['inv_email']);
	$suppUpdate->setInv_contact($_POST['inv_contact']);
	$suppUpdate->setColour($_POST['colour']);
	$suppUpdate->setLive($_POST['live']);

	$suppUpdate->updateDB();
}
$pageTitle = "Supp Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";


$supp = new Supp();
// Load DB data into object
$supp->setSuppid($_GET['id']);
$supp->loadSupp();
$all = $supp->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="suppid" id="suppid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="co_name">co_name</label>
	<input type="text" name="co_name" id="co_name" value="<?php echo $supp->getCo_name();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="fname">fname</label>
	<input type="text" name="fname" id="fname" value="<?php echo $supp->getFname();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="sname">sname</label>
	<input type="text" name="sname" id="sname" value="<?php echo $supp->getSname();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="contact">contact</label>
	<input type="text" name="contact" id="contact" value="<?php echo $supp->getContact();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="addsid">addsid</label>
	<input type="text" name="addsid" id="addsid" value="<?php echo $supp->getAddsid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="inv_email">inv_email</label>
	<input type="text" name="inv_email" id="inv_email" value="<?php echo $supp->getInv_email();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="inv_contact">inv_contact</label>
	<input type="text" name="inv_contact" id="inv_contact" value="<?php echo $supp->getInv_contact();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="colour">colour</label>
	<input type="text" name="colour" id="colour" value="<?php echo $supp->getColour();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="live">live</label>
	<input type="text" name="live" id="live" value="<?php echo $supp->getLive();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
