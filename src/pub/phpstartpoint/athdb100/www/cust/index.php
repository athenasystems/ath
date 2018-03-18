<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Cust.php";
$pageTitle = "Cust Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php"; 
 

?>
<h1>Cust</h1><div><a href="add.php">Add an Item to the Cust table</a></div><br>
<?php
$res = $db->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT * FROM cust ORDER BY custid DESC");
if (! empty($res)) {
	foreach($res as $r) {
		   ?>
<div class="panel panel-info">
	<div class="panel-heading">
		<strong><?php echo $r->custid;?></strong>
	</div>
	<div class="panel-body">
		<a href="view.php?id=<?php echo $r->custid;?>">View</a> |
		<a href="edit.php?id=<?php echo $r->custid;?>">Edit</a>|
		<a href="delete.php?id=<?php echo $r->custid;?>">Delete</a>
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
