<?php
$section = "Stock";
$page = "Stock";

include "/srv/ath/src/php/mng/common.php";


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
		<strong>Viewing <?php echo $stock->getName();?></strong>
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
?>
<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
