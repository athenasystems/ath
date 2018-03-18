<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Times_types.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$times_typesNew = new Times_types();
	$times_typesNew->setSitesid($_POST['sitesid']);
	$times_typesNew->setName($_POST['name']);

	$times_typesNew->insertIntoDB();
		
	header("Location: /times_types/?ItemAdded=y");

}
$pageTitle = "Times_types Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="times_typesid" id="times_typesid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="sitesid">sitesid</label>
	<input type="text" name="sitesid" id="sitesid" value="<?php echo $_POST[sitesid];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="name">name</label>
	<input type="text" name="name" id="name" value="<?php echo $_POST[name];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
