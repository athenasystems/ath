<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Supp.php";
$pageTitle = "Supp Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php"; 
 

?>
<h1>Supp</h1><div><a href="add.php">Add an Item to the Supp table</a></div><br>
<?php
$res = $db->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT * FROM supp ORDER BY suppid DESC");
if (! empty($res)) {
	foreach($res as $r) {
		   ?>
<div class="panel panel-info">
	<div class="panel-heading">
		<strong><?php echo $r->suppid;?></strong>
	</div>
	<div class="panel-body">
		<a href="view.php?id=<?php echo $r->suppid;?>">View</a> |
		<a href="edit.php?id=<?php echo $r->suppid;?>">Edit</a>|
		<a href="delete.php?id=<?php echo $r->suppid;?>">Delete</a>
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
