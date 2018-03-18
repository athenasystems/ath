<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Quotes.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$quotesUpdate = new Quotes();

	$quotesUpdate->setQuotesid($_POST['quotesid']);
	$quotesUpdate->setStaffid($_POST['staffid']);
	$quotesUpdate->setCustid($_POST['custid']);
	$quotesUpdate->setContactsid($_POST['contactsid']);
	$quotesUpdate->setQuoteno($_POST['quoteno']);
	$quotesUpdate->setIncept($_POST['incept']);
	$quotesUpdate->setOrigin($_POST['origin']);
	$quotesUpdate->setAgree($_POST['agree']);
	$quotesUpdate->setLive($_POST['live']);
	$quotesUpdate->setContent($_POST['content']);
	$quotesUpdate->setNotes($_POST['notes']);
	$quotesUpdate->setSent($_POST['sent']);

	$quotesUpdate->updateDB();
}
$pageTitle = "Quotes Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";


$quotes = new Quotes();
// Load DB data into object
$quotes->setQuotesid($_GET['id']);
$quotes->loadQuotes();
$all = $quotes->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="quotesid" id="quotesid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="staffid">staffid</label>
	<input type="text" name="staffid" id="staffid" value="<?php echo $quotes->getStaffid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="custid">custid</label>
	<input type="text" name="custid" id="custid" value="<?php echo $quotes->getCustid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="contactsid">contactsid</label>
	<input type="text" name="contactsid" id="contactsid" value="<?php echo $quotes->getContactsid();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="quoteno">quoteno</label>
	<input type="text" name="quoteno" id="quoteno" value="<?php echo $quotes->getQuoteno();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $quotes->getIncept();?>" class="form-control">
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
	<input type="text" name="agree" id="agree" value="<?php echo $quotes->getAgree();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="live">live</label>
	<input type="text" name="live" id="live" value="<?php echo $quotes->getLive();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="content">content</label>
	<input type="text" name="content" id="content" value="<?php echo $quotes->getContent();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="notes">notes</label>
	<input type="text" name="notes" id="notes" value="<?php echo $quotes->getNotes();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="sent">sent</label>
	<input type="text" name="sent" id="sent" value="<?php echo $quotes->getSent();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
