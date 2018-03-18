<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Sales.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	$salesDelete = new Sales();
	$salesDelete->setSalesid($_GET['id']);
	$salesDelete->deleteFromDB();
	
	header("Location: /sales/?ItemDeleted=y");
    
    exit();
}
$pageTitle = "Sales Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php";
?>
<?php
$sales = new Sales();
// Load DB data into object
$sales->setSalesid($_GET['id']);
$sales->loadSales();
$all = $sales->getAll();

if (isset($all)) {
		   ?>
		   
<div class="panel panel-info">
	<div class="panel-heading">
		<strong>Viewing <?php echo $sales->getSalesid();?></strong>
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
	    <div class="form-group"><input type="hidden" name="salesid" id="salesid" value="<?php echo $_GET['id'];?>"></div>
	    
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
