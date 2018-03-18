<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Supp.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$suppNew = new Supp();
	$suppNew->setCo_name($_POST['co_name']);
	$suppNew->setFname($_POST['fname']);
	$suppNew->setSname($_POST['sname']);
	$suppNew->setContact($_POST['contact']);
	$suppNew->setAddsid($_POST['addsid']);
	$suppNew->setInv_email($_POST['inv_email']);
	$suppNew->setInv_contact($_POST['inv_contact']);
	$suppNew->setColour($_POST['colour']);
	$suppNew->setLive($_POST['live']);

	$suppNew->insertIntoDB();
		
	header("Location: /supp/?ItemAdded=y");

}
$pageTitle = "Supp Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="suppid" id="suppid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="co_name">co_name</label>
	<input type="text" name="co_name" id="co_name" value="<?php echo $_POST[co_name];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="fname">fname</label>
	<input type="text" name="fname" id="fname" value="<?php echo $_POST[fname];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="sname">sname</label>
	<input type="text" name="sname" id="sname" value="<?php echo $_POST[sname];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="contact">contact</label>
	<input type="text" name="contact" id="contact" value="<?php echo $_POST[contact];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="addsid">addsid</label>
	<input type="text" name="addsid" id="addsid" value="<?php echo $_POST[addsid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="inv_email">inv_email</label>
	<input type="text" name="inv_email" id="inv_email" value="<?php echo $_POST[inv_email];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="inv_contact">inv_contact</label>
	<input type="text" name="inv_contact" id="inv_contact" value="<?php echo $_POST[inv_contact];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="colour">colour</label>
	<input type="text" name="colour" id="colour" value="<?php echo $_POST[colour];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="live">live</label>
	<input type="text" name="live" id="live" value="<?php echo $_POST[live];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
