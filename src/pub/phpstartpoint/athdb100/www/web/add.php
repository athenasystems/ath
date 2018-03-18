<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Web.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$webNew = new Web();
	$webNew->setText($_POST['text']);
	$webNew->setPlace($_POST['place']);

	$webNew->insertIntoDB();
		
	header("Location: /web/?ItemAdded=y");

}
$pageTitle = "Web Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="webid" id="webid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="text">text</label>
	<input type="text" name="text" id="text" value="<?php echo $_POST[text];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="place">place</label>
	<input type="text" name="place" id="place" value="<?php echo $_POST[place];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
