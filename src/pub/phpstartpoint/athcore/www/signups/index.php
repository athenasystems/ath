<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Signups.php";
$pageTitle = "Signups Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php"; 
 

?>
<h1>Signups</h1><div><a href="add.php">Add an Item to the Signups table</a></div><br>
<?php
$res = $db->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT * FROM signups ORDER BY signupsid DESC");
if (! empty($res)) {
	foreach($res as $r) {
		   ?>
<div class="panel panel-info">
	<div class="panel-heading">
		<strong><?php echo $r->signupsid;?></strong>
	</div>
	<div class="panel-body">
		<a href="view.php?id=<?php echo $r->signupsid;?>">View</a> |
		<a href="edit.php?id=<?php echo $r->signupsid;?>">Edit</a>|
		<a href="delete.php?id=<?php echo $r->signupsid;?>">Delete</a>
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
