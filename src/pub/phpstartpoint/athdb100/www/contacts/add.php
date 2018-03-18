<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Contacts.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$contactsNew = new Contacts();
	$contactsNew->setTitle($_POST['title']);
	$contactsNew->setFname($_POST['fname']);
	$contactsNew->setSname($_POST['sname']);
	$contactsNew->setCo_name($_POST['co_name']);
	$contactsNew->setRole($_POST['role']);
	$contactsNew->setCustid($_POST['custid']);
	$contactsNew->setSuppid($_POST['suppid']);
	$contactsNew->setAddsid($_POST['addsid']);
	$contactsNew->setNotes($_POST['notes']);

	$contactsNew->insertIntoDB();
		
	header("Location: /contacts/?ItemAdded=y");

}
$pageTitle = "Contacts Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="contactsid" id="contactsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="title">title</label>
	<select name="title" id="title" class="form-control">
	
<option value="Mr">Mr</option>
<option value="Ms">Ms</option>
<option value="Mrs">Mrs</option>
<option value="Dr">Dr</option>
<option value="Sir">Sir</option>
</select></div>
	
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
	<label for="role">role</label>
	<input type="text" name="role" id="role" value="<?php echo $_POST[role];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="custid">custid</label>
	<input type="text" name="custid" id="custid" value="<?php echo $_POST[custid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="suppid">suppid</label>
	<input type="text" name="suppid" id="suppid" value="<?php echo $_POST[suppid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="addsid">addsid</label>
	<input type="text" name="addsid" id="addsid" value="<?php echo $_POST[addsid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="notes">notes</label>
	<input type="text" name="notes" id="notes" value="<?php echo $_POST[notes];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
