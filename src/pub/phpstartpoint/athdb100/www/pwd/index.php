<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Pwd.php";
$pageTitle = "Pwd Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php"; 
 

?>
<h1>Pwd</h1><div><a href="add.php">Add an Item to the Pwd table</a></div><br>
<?php
$res = $db->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT * FROM pwd ORDER BY usr DESC");
if (! empty($res)) {
	foreach($res as $r) {
		   ?>
<div class="panel panel-info">
	<div class="panel-heading">
		<strong><?php echo $r->usr;?></strong>
	</div>
	<div class="panel-body">
		<a href="view.php?id=<?php echo $r->usr;?>">View</a> |
		<a href="edit.php?id=<?php echo $r->usr;?>">Edit</a>|
		<a href="delete.php?id=<?php echo $r->usr;?>">Delete</a>
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
