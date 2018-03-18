<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Adds.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$addsNew = new Adds();
	$addsNew->setAdd1($_POST['add1']);
	$addsNew->setAdd2($_POST['add2']);
	$addsNew->setAdd3($_POST['add3']);
	$addsNew->setCity($_POST['city']);
	$addsNew->setCounty($_POST['county']);
	$addsNew->setCountry($_POST['country']);
	$addsNew->setPostcode($_POST['postcode']);
	$addsNew->setTel($_POST['tel']);
	$addsNew->setMob($_POST['mob']);
	$addsNew->setFax($_POST['fax']);
	$addsNew->setEmail($_POST['email']);
	$addsNew->setWeb($_POST['web']);
	$addsNew->setFacebook($_POST['facebook']);
	$addsNew->setTwitter($_POST['twitter']);
	$addsNew->setLinkedin($_POST['linkedin']);

	$addsNew->insertIntoDB();
		
	header("Location: /adds/?ItemAdded=y");

}
$pageTitle = "Adds Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="addsid" id="addsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="add1">add1</label>
	<input type="text" name="add1" id="add1" value="<?php echo $_POST[add1];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="add2">add2</label>
	<input type="text" name="add2" id="add2" value="<?php echo $_POST[add2];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="add3">add3</label>
	<input type="text" name="add3" id="add3" value="<?php echo $_POST[add3];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="city">city</label>
	<input type="text" name="city" id="city" value="<?php echo $_POST[city];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="county">county</label>
	<input type="text" name="county" id="county" value="<?php echo $_POST[county];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="country">country</label>
	<input type="text" name="country" id="country" value="<?php echo $_POST[country];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="postcode">postcode</label>
	<input type="text" name="postcode" id="postcode" value="<?php echo $_POST[postcode];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="tel">tel</label>
	<input type="text" name="tel" id="tel" value="<?php echo $_POST[tel];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="mob">mob</label>
	<input type="text" name="mob" id="mob" value="<?php echo $_POST[mob];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="fax">fax</label>
	<input type="text" name="fax" id="fax" value="<?php echo $_POST[fax];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="email">email</label>
	<input type="text" name="email" id="email" value="<?php echo $_POST[email];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="web">web</label>
	<input type="text" name="web" id="web" value="<?php echo $_POST[web];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="facebook">facebook</label>
	<input type="text" name="facebook" id="facebook" value="<?php echo $_POST[facebook];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="twitter">twitter</label>
	<input type="text" name="twitter" id="twitter" value="<?php echo $_POST[twitter];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="linkedin">linkedin</label>
	<input type="text" name="linkedin" id="linkedin" value="<?php echo $_POST[linkedin];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
