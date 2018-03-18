<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Sites.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$sitesUpdate = new Sites();

	$sitesUpdate->setSitesid($_POST['sitesid']);
	$sitesUpdate->setCo_name($_POST['co_name']);
	$sitesUpdate->setCo_nick($_POST['co_nick']);
	$sitesUpdate->setAddsid($_POST['addsid']);
	$sitesUpdate->setEmail($_POST['email']);
	$sitesUpdate->setInv_email($_POST['inv_email']);
	$sitesUpdate->setInv_contact($_POST['inv_contact']);
	$sitesUpdate->setColour($_POST['colour']);
	$sitesUpdate->setStatus($_POST['status']);
	$sitesUpdate->setPid($_POST['pid']);
	$sitesUpdate->setVat_no($_POST['vat_no']);
	$sitesUpdate->setCo_no($_POST['co_no']);
	$sitesUpdate->setGmailpw($_POST['gmailpw']);
	$sitesUpdate->setGmail($_POST['gmail']);
	$sitesUpdate->setIncept($_POST['incept']);
	$sitesUpdate->setSubdom($_POST['subdom']);
	$sitesUpdate->setDomain($_POST['domain']);
	$sitesUpdate->setFilestr($_POST['filestr']);
	$sitesUpdate->setEoymonth($_POST['eoymonth']);
	$sitesUpdate->setEoyday($_POST['eoyday']);
	$sitesUpdate->setBrand($_POST['brand']);

	$sitesUpdate->updateDB();
}
$pageTitle = "Sites Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php";


$sites = new Sites();
// Load DB data into object
$sites->setSitesid($_GET['id']);
$sites->loadSites();
$all = $sites->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="sitesid" id="sitesid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="co_name">co_name</label>
	<input type="text" name="co_name" id="co_name" value="<?php echo $sites->getCo_name();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="co_nick">co_nick</label>
	<input type="text" name="co_nick" id="co_nick" value="<?php echo $sites->getCo_nick();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="addsid">addsid</label>
	<input type="text" name="addsid" id="addsid" value="<?php echo $sites->getAddsid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="email">email</label>
	<input type="text" name="email" id="email" value="<?php echo $sites->getEmail();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="inv_email">inv_email</label>
	<input type="text" name="inv_email" id="inv_email" value="<?php echo $sites->getInv_email();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="inv_contact">inv_contact</label>
	<input type="text" name="inv_contact" id="inv_contact" value="<?php echo $sites->getInv_contact();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="colour">colour</label>
	<input type="text" name="colour" id="colour" value="<?php echo $sites->getColour();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="status">status</label>
	<select name="status" id="status" class="form-control">
	
<option value="active">active</option>
<option value="onhold">onhold</option>
<option value="closed">closed</option>
<option value="new">new</option>
</select></div>
	
	<div class="form-group">
	<label for="pid">pid</label>
	<input type="text" name="pid" id="pid" value="<?php echo $sites->getPid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="vat_no">vat_no</label>
	<input type="text" name="vat_no" id="vat_no" value="<?php echo $sites->getVat_no();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="co_no">co_no</label>
	<input type="text" name="co_no" id="co_no" value="<?php echo $sites->getCo_no();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="gmailpw">gmailpw</label>
	<input type="text" name="gmailpw" id="gmailpw" value="<?php echo $sites->getGmailpw();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="gmail">gmail</label>
	<input type="text" name="gmail" id="gmail" value="<?php echo $sites->getGmail();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $sites->getIncept();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="subdom">subdom</label>
	<input type="text" name="subdom" id="subdom" value="<?php echo $sites->getSubdom();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="domain">domain</label>
	<input type="text" name="domain" id="domain" value="<?php echo $sites->getDomain();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="filestr">filestr</label>
	<input type="text" name="filestr" id="filestr" value="<?php echo $sites->getFilestr();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="eoymonth">eoymonth</label>
	<input type="text" name="eoymonth" id="eoymonth" value="<?php echo $sites->getEoymonth();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="eoyday">eoyday</label>
	<input type="text" name="eoyday" id="eoyday" value="<?php echo $sites->getEoyday();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="brand">brand</label>
	<input type="text" name="brand" id="brand" value="<?php echo $sites->getBrand();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
