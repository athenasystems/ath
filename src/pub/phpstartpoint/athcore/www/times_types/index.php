<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Times_types.php";
$pageTitle = "Times_types Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php"; 
 

?>
<h1>Times_types</h1><div><a href="add.php">Add an Item to the Times_types table</a></div><br>
<?php
$res = $db->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT * FROM times_types ORDER BY times_typesid DESC");
if (! empty($res)) {
	foreach($res as $r) {
		   ?>
<div class="panel panel-info">
	<div class="panel-heading">
		<strong><?php echo $r->times_typesid;?></strong>
	</div>
	<div class="panel-body">
		<a href="view.php?id=<?php echo $r->times_typesid;?>">View</a> |
		<a href="edit.php?id=<?php echo $r->times_typesid;?>">Edit</a>|
		<a href="delete.php?id=<?php echo $r->times_typesid;?>">Delete</a>
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
