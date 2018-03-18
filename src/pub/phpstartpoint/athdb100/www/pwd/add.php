<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Pwd.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$pwdNew = new Pwd();
	$pwdNew->setStaffid($_POST['staffid']);
	$pwdNew->setCustid($_POST['custid']);
	$pwdNew->setSuppid($_POST['suppid']);
	$pwdNew->setContactsid($_POST['contactsid']);
	$pwdNew->setSeclev($_POST['seclev']);
	$pwdNew->setPw($_POST['pw']);
	$pwdNew->setInit($_POST['init']);
	$pwdNew->setLastlogin($_POST['lastlogin']);

	$pwdNew->insertIntoDB();
		
	header("Location: /pwd/?ItemAdded=y");

}
$pageTitle = "Pwd Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="usr" id="usr" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="staffid">staffid</label>
	<input type="text" name="staffid" id="staffid" value="<?php echo $_POST[staffid];?>" class="form-control">
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
	<label for="contactsid">contactsid</label>
	<input type="text" name="contactsid" id="contactsid" value="<?php echo $_POST[contactsid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="seclev">seclev</label>
	<input type="text" name="seclev" id="seclev" value="<?php echo $_POST[seclev];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="pw">pw</label>
	<input type="text" name="pw" id="pw" value="<?php echo $_POST[pw];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="init">init</label>
	<input type="text" name="init" id="init" value="<?php echo $_POST[init];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="lastlogin">lastlogin</label>
	<input type="text" name="lastlogin" id="lastlogin" value="<?php echo $_POST[lastlogin];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
