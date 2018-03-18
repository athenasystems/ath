<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Contacts.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$contactsUpdate = new Contacts();

	$contactsUpdate->setContactsid($_POST['contactsid']);
	$contactsUpdate->setTitle($_POST['title']);
	$contactsUpdate->setFname($_POST['fname']);
	$contactsUpdate->setSname($_POST['sname']);
	$contactsUpdate->setCo_name($_POST['co_name']);
	$contactsUpdate->setRole($_POST['role']);
	$contactsUpdate->setCustid($_POST['custid']);
	$contactsUpdate->setSuppid($_POST['suppid']);
	$contactsUpdate->setAddsid($_POST['addsid']);
	$contactsUpdate->setNotes($_POST['notes']);

	$contactsUpdate->updateDB();
}
$pageTitle = "Contacts Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";


$contacts = new Contacts();
// Load DB data into object
$contacts->setContactsid($_GET['id']);
$contacts->loadContacts();
$all = $contacts->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
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
	<input type="text" name="fname" id="fname" value="<?php echo $contacts->getFname();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="sname">sname</label>
	<input type="text" name="sname" id="sname" value="<?php echo $contacts->getSname();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="co_name">co_name</label>
	<input type="text" name="co_name" id="co_name" value="<?php echo $contacts->getCo_name();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="role">role</label>
	<input type="text" name="role" id="role" value="<?php echo $contacts->getRole();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="custid">custid</label>
	<input type="text" name="custid" id="custid" value="<?php echo $contacts->getCustid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="suppid">suppid</label>
	<input type="text" name="suppid" id="suppid" value="<?php echo $contacts->getSuppid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="addsid">addsid</label>
	<input type="text" name="addsid" id="addsid" value="<?php echo $contacts->getAddsid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="notes">notes</label>
	<input type="text" name="notes" id="notes" value="<?php echo $contacts->getNotes();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
