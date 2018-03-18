<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Signups.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$signupsNew = new Signups();
	$signupsNew->setIncept($_POST['incept']);
	$signupsNew->setFname($_POST['fname']);
	$signupsNew->setSname($_POST['sname']);
	$signupsNew->setCo_name($_POST['co_name']);
	$signupsNew->setEmail($_POST['email']);
	$signupsNew->setTel($_POST['tel']);
	$signupsNew->setStatus($_POST['status']);
	$signupsNew->setBrand($_POST['brand']);

	$signupsNew->insertIntoDB();
		
	header("Location: /signups/?ItemAdded=y");

}
$pageTitle = "Signups Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="signupsid" id="signupsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $_POST[incept];?>" class="form-control">
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
	<label for="co_name">co_name</label>
	<input type="text" name="co_name" id="co_name" value="<?php echo $_POST[co_name];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="email">email</label>
	<input type="text" name="email" id="email" value="<?php echo $_POST[email];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="tel">tel</label>
	<input type="text" name="tel" id="tel" value="<?php echo $_POST[tel];?>" class="form-control">
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
	<input type="text" name="brand" id="brand" value="<?php echo $_POST[brand];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
