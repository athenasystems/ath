<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Tasks.php";
$pageTitle = "Tasks Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php"; 
 

?>
<h1>Tasks</h1><div><a href="add.php">Add an Item to the Tasks table</a></div><br>
<?php
$res = $db->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT * FROM tasks ORDER BY tasksid DESC");
if (! empty($res)) {
	foreach($res as $r) {
		   ?>
<div class="panel panel-info">
	<div class="panel-heading">
		<strong><?php echo $r->tasksid;?></strong>
	</div>
	<div class="panel-body">
		<a href="view.php?id=<?php echo $r->tasksid;?>">View</a> |
		<a href="edit.php?id=<?php echo $r->tasksid;?>">Edit</a>|
		<a href="delete.php?id=<?php echo $r->tasksid;?>">Delete</a>
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
