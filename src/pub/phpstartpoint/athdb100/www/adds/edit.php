<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Adds.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$addsUpdate = new Adds();

	$addsUpdate->setAddsid($_POST['addsid']);
	$addsUpdate->setAdd1($_POST['add1']);
	$addsUpdate->setAdd2($_POST['add2']);
	$addsUpdate->setAdd3($_POST['add3']);
	$addsUpdate->setCity($_POST['city']);
	$addsUpdate->setCounty($_POST['county']);
	$addsUpdate->setCountry($_POST['country']);
	$addsUpdate->setPostcode($_POST['postcode']);
	$addsUpdate->setTel($_POST['tel']);
	$addsUpdate->setMob($_POST['mob']);
	$addsUpdate->setFax($_POST['fax']);
	$addsUpdate->setEmail($_POST['email']);
	$addsUpdate->setWeb($_POST['web']);
	$addsUpdate->setFacebook($_POST['facebook']);
	$addsUpdate->setTwitter($_POST['twitter']);
	$addsUpdate->setLinkedin($_POST['linkedin']);

	$addsUpdate->updateDB();
}
$pageTitle = "Adds Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";


$adds = new Adds();
// Load DB data into object
$adds->setAddsid($_GET['id']);
$adds->loadAdds();
$all = $adds->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="addsid" id="addsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="add1">add1</label>
	<input type="text" name="add1" id="add1" value="<?php echo $adds->getAdd1();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="add2">add2</label>
	<input type="text" name="add2" id="add2" value="<?php echo $adds->getAdd2();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="add3">add3</label>
	<input type="text" name="add3" id="add3" value="<?php echo $adds->getAdd3();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="city">city</label>
	<input type="text" name="city" id="city" value="<?php echo $adds->getCity();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="county">county</label>
	<input type="text" name="county" id="county" value="<?php echo $adds->getCounty();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="country">country</label>
	<input type="text" name="country" id="country" value="<?php echo $adds->getCountry();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="postcode">postcode</label>
	<input type="text" name="postcode" id="postcode" value="<?php echo $adds->getPostcode();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="tel">tel</label>
	<input type="text" name="tel" id="tel" value="<?php echo $adds->getTel();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="mob">mob</label>
	<input type="text" name="mob" id="mob" value="<?php echo $adds->getMob();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="fax">fax</label>
	<input type="text" name="fax" id="fax" value="<?php echo $adds->getFax();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="email">email</label>
	<input type="text" name="email" id="email" value="<?php echo $adds->getEmail();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="web">web</label>
	<input type="text" name="web" id="web" value="<?php echo $adds->getWeb();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="facebook">facebook</label>
	<input type="text" name="facebook" id="facebook" value="<?php echo $adds->getFacebook();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="twitter">twitter</label>
	<input type="text" name="twitter" id="twitter" value="<?php echo $adds->getTwitter();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="linkedin">linkedin</label>
	<input type="text" name="linkedin" id="linkedin" value="<?php echo $adds->getLinkedin();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
