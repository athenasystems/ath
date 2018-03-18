<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Iitems.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	$iitemsDelete = new Iitems();
	$iitemsDelete->setIitemsid($_GET['id']);
	$iitemsDelete->deleteFromDB();
	
	header("Location: /iitems/?ItemDeleted=y");
    
    exit();
}
$pageTitle = "Iitems Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<?php
$iitems = new Iitems();
// Load DB data into object
$iitems->setIitemsid($_GET['id']);
$iitems->loadIitems();
$all = $iitems->getAll();

if (isset($all)) {
		   ?>
		   
<div class="panel panel-info">
	<div class="panel-heading">
		<strong>Viewing <?php echo $iitems->getIitemsid();?></strong>
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
	    <div class="form-group"><input type="hidden" name="iitemsid" id="iitemsid" value="<?php echo $_GET['id'];?>"></div>
	    
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
