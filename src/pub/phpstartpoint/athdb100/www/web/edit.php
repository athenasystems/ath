<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Web.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$webUpdate = new Web();

	$webUpdate->setWebid($_POST['webid']);
	$webUpdate->setText($_POST['text']);
	$webUpdate->setPlace($_POST['place']);

	$webUpdate->updateDB();
}
$pageTitle = "Web Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";


$web = new Web();
// Load DB data into object
$web->setWebid($_GET['id']);
$web->loadWeb();
$all = $web->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="webid" id="webid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="text">text</label>
	<input type="text" name="text" id="text" value="<?php echo $web->getText();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="place">place</label>
	<input type="text" name="place" id="place" value="<?php echo $web->getPlace();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
