<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Sites.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$sitesNew = new Sites();
	$sitesNew->setCo_name($_POST['co_name']);
	$sitesNew->setCo_nick($_POST['co_nick']);
	$sitesNew->setAddsid($_POST['addsid']);
	$sitesNew->setEmail($_POST['email']);
	$sitesNew->setInv_email($_POST['inv_email']);
	$sitesNew->setInv_contact($_POST['inv_contact']);
	$sitesNew->setColour($_POST['colour']);
	$sitesNew->setStatus($_POST['status']);
	$sitesNew->setPid($_POST['pid']);
	$sitesNew->setVat_no($_POST['vat_no']);
	$sitesNew->setCo_no($_POST['co_no']);
	$sitesNew->setGmailpw($_POST['gmailpw']);
	$sitesNew->setGmail($_POST['gmail']);
	$sitesNew->setIncept($_POST['incept']);
	$sitesNew->setSubdom($_POST['subdom']);
	$sitesNew->setDomain($_POST['domain']);
	$sitesNew->setFilestr($_POST['filestr']);
	$sitesNew->setEoymonth($_POST['eoymonth']);
	$sitesNew->setEoyday($_POST['eoyday']);
	$sitesNew->setBrand($_POST['brand']);

	$sitesNew->insertIntoDB();
		
	header("Location: /sites/?ItemAdded=y");

}
$pageTitle = "Sites Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="sitesid" id="sitesid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="co_name">co_name</label>
	<input type="text" name="co_name" id="co_name" value="<?php echo $_POST[co_name];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="co_nick">co_nick</label>
	<input type="text" name="co_nick" id="co_nick" value="<?php echo $_POST[co_nick];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="addsid">addsid</label>
	<input type="text" name="addsid" id="addsid" value="<?php echo $_POST[addsid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="email">email</label>
	<input type="text" name="email" id="email" value="<?php echo $_POST[email];?>" class="form-control">
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
	<label for="status">status</label>
	<select name="status" id="status" class="form-control">
	
<option value="active">active</option>
<option value="onhold">onhold</option>
<option value="closed">closed</option>
<option value="new">new</option>
</select></div>
	
	<div class="form-group">
	<label for="pid">pid</label>
	<input type="text" name="pid" id="pid" value="<?php echo $_POST[pid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="vat_no">vat_no</label>
	<input type="text" name="vat_no" id="vat_no" value="<?php echo $_POST[vat_no];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="co_no">co_no</label>
	<input type="text" name="co_no" id="co_no" value="<?php echo $_POST[co_no];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="gmailpw">gmailpw</label>
	<input type="text" name="gmailpw" id="gmailpw" value="<?php echo $_POST[gmailpw];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="gmail">gmail</label>
	<input type="text" name="gmail" id="gmail" value="<?php echo $_POST[gmail];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $_POST[incept];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="subdom">subdom</label>
	<input type="text" name="subdom" id="subdom" value="<?php echo $_POST[subdom];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="domain">domain</label>
	<input type="text" name="domain" id="domain" value="<?php echo $_POST[domain];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="filestr">filestr</label>
	<input type="text" name="filestr" id="filestr" value="<?php echo $_POST[filestr];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="eoymonth">eoymonth</label>
	<input type="text" name="eoymonth" id="eoymonth" value="<?php echo $_POST[eoymonth];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="eoyday">eoyday</label>
	<input type="text" name="eoyday" id="eoyday" value="<?php echo $_POST[eoyday];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="brand">brand</label>
	<input type="text" name="brand" id="brand" value="<?php echo $_POST[brand];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
