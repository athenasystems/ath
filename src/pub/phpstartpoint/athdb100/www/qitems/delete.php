<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Qitems.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	$qitemsDelete = new Qitems();
	$qitemsDelete->setQitemsid($_GET['id']);
	$qitemsDelete->deleteFromDB();
	
	header("Location: /qitems/?ItemDeleted=y");
    
    exit();
}
$pageTitle = "Qitems Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<?php
$qitems = new Qitems();
// Load DB data into object
$qitems->setQitemsid($_GET['id']);
$qitems->loadQitems();
$all = $qitems->getAll();

if (isset($all)) {
		   ?>
		   
<div class="panel panel-info">
	<div class="panel-heading">
		<strong>Viewing <?php echo $qitems->getQitemsid();?></strong>
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
	    <div class="form-group"><input type="hidden" name="qitemsid" id="qitemsid" value="<?php echo $_GET['id'];?>"></div>
	    
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
