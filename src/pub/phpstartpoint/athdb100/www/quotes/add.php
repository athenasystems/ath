<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Quotes.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$quotesNew = new Quotes();
	$quotesNew->setStaffid($_POST['staffid']);
	$quotesNew->setCustid($_POST['custid']);
	$quotesNew->setContactsid($_POST['contactsid']);
	$quotesNew->setQuoteno($_POST['quoteno']);
	$quotesNew->setIncept($_POST['incept']);
	$quotesNew->setOrigin($_POST['origin']);
	$quotesNew->setAgree($_POST['agree']);
	$quotesNew->setLive($_POST['live']);
	$quotesNew->setContent($_POST['content']);
	$quotesNew->setNotes($_POST['notes']);
	$quotesNew->setSent($_POST['sent']);

	$quotesNew->insertIntoDB();
		
	header("Location: /quotes/?ItemAdded=y");

}
$pageTitle = "Quotes Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="quotesid" id="quotesid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="staffid">staffid</label>
	<input type="text" name="staffid" id="staffid" value="<?php echo $_POST[staffid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="custid">custid</label>
	<input type="text" name="custid" id="custid" value="<?php echo $_POST[custid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="contactsid">contactsid</label>
	<input type="text" name="contactsid" id="contactsid" value="<?php echo $_POST[contactsid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="quoteno">quoteno</label>
	<input type="text" name="quoteno" id="quoteno" value="<?php echo $_POST[quoteno];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $_POST[incept];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="origin">origin</label>
	<select name="origin" id="origin" class="form-control">
	
<option value="int">int</option>
<option value="ext">ext</option>
<option value="tasks">tasks</option>
</select></div>
	
	<div class="form-group">
	<label for="agree">agree</label>
	<input type="text" name="agree" id="agree" value="<?php echo $_POST[agree];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="live">live</label>
	<input type="text" name="live" id="live" value="<?php echo $_POST[live];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="content">content</label>
	<input type="text" name="content" id="content" value="<?php echo $_POST[content];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="notes">notes</label>
	<input type="text" name="notes" id="notes" value="<?php echo $_POST[notes];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="sent">sent</label>
	<input type="text" name="sent" id="sent" value="<?php echo $_POST[sent];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
