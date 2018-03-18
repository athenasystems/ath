<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Products.php";
$pageTitle = "Products Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php"; 
 

?>
<h1>Products</h1><div><a href="add.php">Add an Item to the Products table</a></div><br>
<?php
$res = $db->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT * FROM products ORDER BY productsid DESC");
if (! empty($res)) {
	foreach($res as $r) {
		   ?>
<div class="panel panel-info">
	<div class="panel-heading">
		<strong><?php echo $r->productsid;?></strong>
	</div>
	<div class="panel-body">
		<a href="view.php?id=<?php echo $r->productsid;?>">View</a> |
		<a href="edit.php?id=<?php echo $r->productsid;?>">Edit</a>|
		<a href="delete.php?id=<?php echo $r->productsid;?>">Delete</a>
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
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
