<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Sales.php";
$pageTitle = "Sales Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php"; 
 

?>
<h1>Sales</h1><div><a href="add.php">Add an Item to the Sales table</a></div><br>
<?php
$res = $db->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT * FROM sales ORDER BY salesid DESC");
if (! empty($res)) {
	foreach($res as $r) {
		   ?>
<div class="panel panel-info">
	<div class="panel-heading">
		<strong><?php echo $r->salesid;?></strong>
	</div>
	<div class="panel-body">
		<a href="view.php?id=<?php echo $r->salesid;?>">View</a> |
		<a href="edit.php?id=<?php echo $r->salesid;?>">Edit</a>|
		<a href="delete.php?id=<?php echo $r->salesid;?>">Delete</a>
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
