<?php
$section = "Stock";
$page = "Stock";

include "/srv/ath/src/php/mng/common.php";



if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	$stockDelete = new Stock();
	$stockDelete->setStockid($_GET['id']);
	$stockDelete->deleteFromDB();

	header("Location: /stock/?ItemDeleted=y");

    exit();
}
$pageTitle = "Stock Page";
include "/srv/ath/pub/mng/tmpl/header.php";
?>
<?php
$stock = new Stock();
// Load DB data into object
$stock->setStockid($_GET['id']);
$stock->loadStock();
$all = $stock->getAll();

if (isset($all)) {
		   ?>

<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Viewing <?php echo $stock->getStockid();?></strong>
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
	    <div class="form-group"><input type="hidden" name="stockid" id="stockid" value="<?php echo $_GET['id'];?>"></div>

<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
