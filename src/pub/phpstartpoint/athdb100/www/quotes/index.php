<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Quotes.php";
$pageTitle = "Quotes Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php"; 
 

?>
<h1>Quotes</h1><div><a href="add.php">Add an Item to the Quotes table</a></div><br>
<?php
$res = $db->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT * FROM quotes ORDER BY quotesid DESC");
if (! empty($res)) {
	foreach($res as $r) {
		   ?>
<div class="panel panel-info">
	<div class="panel-heading">
		<strong><?php echo $r->quotesid;?></strong>
	</div>
	<div class="panel-body">
		<a href="view.php?id=<?php echo $r->quotesid;?>">View</a> |
		<a href="edit.php?id=<?php echo $r->quotesid;?>">Edit</a>|
		<a href="delete.php?id=<?php echo $r->quotesid;?>">Delete</a>
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
