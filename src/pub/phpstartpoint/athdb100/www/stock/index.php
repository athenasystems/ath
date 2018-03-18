<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Stock.php";
$pageTitle = "Stock Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php"; 
 

?>
<h1>Stock</h1><div><a href="add.php">Add an Item to the Stock table</a></div><br>
<?php
$res = $db->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT * FROM stock ORDER BY stockid DESC");
if (! empty($res)) {
	foreach($res as $r) {
		   ?>
<div class="panel panel-info">
	<div class="panel-heading">
		<strong><?php echo $r->stockid;?></strong>
	</div>
	<div class="panel-body">
		<a href="view.php?id=<?php echo $r->stockid;?>">View</a> |
		<a href="edit.php?id=<?php echo $r->stockid;?>">Edit</a>|
		<a href="delete.php?id=<?php echo $r->stockid;?>">Delete</a>
	</div>
</div>
<?php
	}
}else{
	?>
	<h2>No results found</h2>
	<?php
}
?>

<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
