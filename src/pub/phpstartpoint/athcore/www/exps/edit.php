<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Exps.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$expsUpdate = new Exps();

	$expsUpdate->setExpsid($_POST['expsid']);
	$expsUpdate->setName($_POST['name']);
	$expsUpdate->setPeriodical($_POST['periodical']);

	$expsUpdate->updateDB();
}
$pageTitle = "Exps Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php";


$exps = new Exps();
// Load DB data into object
$exps->setExpsid($_GET['id']);
$exps->loadExps();
$all = $exps->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="expsid" id="expsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="name">name</label>
	<input type="text" name="name" id="name" value="<?php echo $exps->getName();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="periodical">periodical</label>
	<input type="text" name="periodical" id="periodical" value="<?php echo $exps->getPeriodical();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
