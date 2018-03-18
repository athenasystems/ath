<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Signups.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$signupsUpdate = new Signups();

	$signupsUpdate->setSignupsid($_POST['signupsid']);
	$signupsUpdate->setIncept($_POST['incept']);
	$signupsUpdate->setFname($_POST['fname']);
	$signupsUpdate->setSname($_POST['sname']);
	$signupsUpdate->setCo_name($_POST['co_name']);
	$signupsUpdate->setEmail($_POST['email']);
	$signupsUpdate->setTel($_POST['tel']);
	$signupsUpdate->setStatus($_POST['status']);
	$signupsUpdate->setBrand($_POST['brand']);

	$signupsUpdate->updateDB();
}
$pageTitle = "Signups Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php";


$signups = new Signups();
// Load DB data into object
$signups->setSignupsid($_GET['id']);
$signups->loadSignups();
$all = $signups->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="signupsid" id="signupsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $signups->getIncept();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="fname">fname</label>
	<input type="text" name="fname" id="fname" value="<?php echo $signups->getFname();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="sname">sname</label>
	<input type="text" name="sname" id="sname" value="<?php echo $signups->getSname();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="co_name">co_name</label>
	<input type="text" name="co_name" id="co_name" value="<?php echo $signups->getCo_name();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="email">email</label>
	<input type="text" name="email" id="email" value="<?php echo $signups->getEmail();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="tel">tel</label>
	<input type="text" name="tel" id="tel" value="<?php echo $signups->getTel();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="status">status</label>
	<select name="status" id="status" class="form-control">
	
<option value="new">new</option>
<option value="active">active</option>
<option value="paused">paused</option>
<option value="dead">dead</option>
</select></div>
	
	<div class="form-group">
	<label for="brand">brand</label>
	<input type="text" name="brand" id="brand" value="<?php echo $signups->getBrand();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
