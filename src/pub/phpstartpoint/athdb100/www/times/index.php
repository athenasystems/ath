<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Times.php";
$pageTitle = "Times Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php"; 
 

?>
<h1>Times</h1><div><a href="add.php">Add an Item to the Times table</a></div><br>
<?php
$res = $db->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT * FROM times ORDER BY timesid DESC");
if (! empty($res)) {
	foreach($res as $r) {
		   ?>
<div class="panel panel-info">
	<div class="panel-heading">
		<strong><?php echo $r->timesid;?></strong>
	</div>
	<div class="panel-body">
		<a href="view.php?id=<?php echo $r->timesid;?>">View</a> |
		<a href="edit.php?id=<?php echo $r->timesid;?>">Edit</a>|
		<a href="delete.php?id=<?php echo $r->timesid;?>">Delete</a>
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
