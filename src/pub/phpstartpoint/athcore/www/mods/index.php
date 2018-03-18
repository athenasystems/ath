<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Mods.php";
$pageTitle = "Mods Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php"; 
 

?>
<h1>Mods</h1><div><a href="add.php">Add an Item to the Mods table</a></div><br>
<?php
$res = $db->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT * FROM mods ORDER BY modsid DESC");
if (! empty($res)) {
	foreach($res as $r) {
		   ?>
<div class="panel panel-info">
	<div class="panel-heading">
		<strong><?php echo $r->modsid;?></strong>
	</div>
	<div class="panel-body">
		<a href="view.php?id=<?php echo $r->modsid;?>">View</a> |
		<a href="edit.php?id=<?php echo $r->modsid;?>">Edit</a>|
		<a href="delete.php?id=<?php echo $r->modsid;?>">Delete</a>
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
