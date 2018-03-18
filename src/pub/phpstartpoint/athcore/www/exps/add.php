<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Exps.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$expsNew = new Exps();
	$expsNew->setName($_POST['name']);
	$expsNew->setPeriodical($_POST['periodical']);

	$expsNew->insertIntoDB();
		
	header("Location: /exps/?ItemAdded=y");

}
$pageTitle = "Exps Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="expsid" id="expsid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="name">name</label>
	<input type="text" name="name" id="name" value="<?php echo $_POST[name];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="periodical">periodical</label>
	<input type="text" name="periodical" id="periodical" value="<?php echo $_POST[periodical];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
