<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Pwd.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$pwdUpdate = new Pwd();

	$pwdUpdate->setUsr($_POST['usr']);
	$pwdUpdate->setStaffid($_POST['staffid']);
	$pwdUpdate->setCustid($_POST['custid']);
	$pwdUpdate->setSuppid($_POST['suppid']);
	$pwdUpdate->setContactsid($_POST['contactsid']);
	$pwdUpdate->setSeclev($_POST['seclev']);
	$pwdUpdate->setPw($_POST['pw']);
	$pwdUpdate->setInit($_POST['init']);
	$pwdUpdate->setLastlogin($_POST['lastlogin']);

	$pwdUpdate->updateDB();
}
$pageTitle = "Pwd Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";


$pwd = new Pwd();
// Load DB data into object
$pwd->setUsr($_GET['id']);
$pwd->loadPwd();
$all = $pwd->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="usr" id="usr" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="staffid">staffid</label>
	<input type="text" name="staffid" id="staffid" value="<?php echo $pwd->getStaffid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="custid">custid</label>
	<input type="text" name="custid" id="custid" value="<?php echo $pwd->getCustid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="suppid">suppid</label>
	<input type="text" name="suppid" id="suppid" value="<?php echo $pwd->getSuppid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="contactsid">contactsid</label>
	<input type="text" name="contactsid" id="contactsid" value="<?php echo $pwd->getContactsid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="seclev">seclev</label>
	<input type="text" name="seclev" id="seclev" value="<?php echo $pwd->getSeclev();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="pw">pw</label>
	<input type="text" name="pw" id="pw" value="<?php echo $pwd->getPw();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="init">init</label>
	<input type="text" name="init" id="init" value="<?php echo $pwd->getInit();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="lastlogin">lastlogin</label>
	<input type="text" name="lastlogin" id="lastlogin" value="<?php echo $pwd->getLastlogin();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
