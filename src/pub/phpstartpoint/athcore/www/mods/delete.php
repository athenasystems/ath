<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Mods.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	$modsDelete = new Mods();
	$modsDelete->setModsid($_GET['id']);
	$modsDelete->deleteFromDB();
	
	header("Location: /mods/?ItemDeleted=y");
    
    exit();
}
$pageTitle = "Mods Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php";
?>
<?php
$mods = new Mods();
// Load DB data into object
$mods->setModsid($_GET['id']);
$mods->loadMods();
$all = $mods->getAll();

if (isset($all)) {
		   ?>
		   
<div class="panel panel-info">
	<div class="panel-heading">
		<strong>Viewing <?php echo $mods->getModsid();?></strong>
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
	    <div class="form-group"><input type="hidden" name="modsid" id="modsid" value="<?php echo $_GET['id'];?>"></div>
	    
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
