<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Exps.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	$expsDelete = new Exps();
	$expsDelete->setExpsid($_GET['id']);
	$expsDelete->deleteFromDB();
	
	header("Location: /exps/?ItemDeleted=y");
    
    exit();
}
$pageTitle = "Exps Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php";
?>
<?php
$exps = new Exps();
// Load DB data into object
$exps->setExpsid($_GET['id']);
$exps->loadExps();
$all = $exps->getAll();

if (isset($all)) {
		   ?>
		   
<div class="panel panel-info">
	<div class="panel-heading">
		<strong>Viewing <?php echo $exps->getExpsid();?></strong>
	</div>
	<div class="panel-body">
		<?php
    
    foreach ($all as $key => $value) {
        if (isset($value) && ($value != '')) {
            ?>
		    <dl class="dl-horizontal">
			<dt><?php echo $key;?></dt>
			<dd><?php echo $value;?></dd>
		</dl>
		    <?php
        }
    }
    
    ?>
	</div>
</div>
<?php
}else{
	?>
	<h2>No results found</h2>
	<?php
}
?><form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post"><h2>Please confirm you wish to delete this item</h2>	
	    <div class="form-group"><input type="hidden" name="expsid" id="expsid" value="<?php echo $_GET['id'];?>"></div>
	    
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
