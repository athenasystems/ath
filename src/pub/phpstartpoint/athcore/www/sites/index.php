<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Sites.php";
$pageTitle = "Sites Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php"; 
 

?>
<h1>Sites</h1><div><a href="add.php">Add an Item to the Sites table</a></div><br>
<?php
$res = $db->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT * FROM sites ORDER BY sitesid DESC");
if (! empty($res)) {
	foreach($res as $r) {
		   ?>
<div class="panel panel-info">
	<div class="panel-heading">
		<strong><?php echo $r->sitesid;?></strong>
	</div>
	<div class="panel-body">
		<a href="view.php?id=<?php echo $r->sitesid;?>">View</a> |
		<a href="edit.php?id=<?php echo $r->sitesid;?>">Edit</a>|
		<a href="delete.php?id=<?php echo $r->sitesid;?>">Delete</a>
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
