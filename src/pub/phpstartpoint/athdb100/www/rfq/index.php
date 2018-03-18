<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Rfq.php";
$pageTitle = "Rfq Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php"; 
 

?>
<h1>Rfq</h1><div><a href="add.php">Add an Item to the Rfq table</a></div><br>
<?php
$res = $db->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT * FROM rfq ORDER BY rfqid DESC");
if (! empty($res)) {
	foreach($res as $r) {
		   ?>
<div class="panel panel-info">
	<div class="panel-heading">
		<strong><?php echo $r->rfqid;?></strong>
	</div>
	<div class="panel-body">
		<a href="view.php?id=<?php echo $r->rfqid;?>">View</a> |
		<a href="edit.php?id=<?php echo $r->rfqid;?>">Edit</a>|
		<a href="delete.php?id=<?php echo $r->rfqid;?>">Delete</a>
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
