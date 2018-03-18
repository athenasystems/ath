<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Jobs.php";
$pageTitle = "Jobs Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php"; 
 

?>
<h1>Jobs</h1><div><a href="add.php">Add an Item to the Jobs table</a></div><br>
<?php
$res = $db->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT * FROM jobs ORDER BY jobsid DESC");
if (! empty($res)) {
	foreach($res as $r) {
		   ?>
<div class="panel panel-info">
	<div class="panel-heading">
		<strong><?php echo $r->jobsid;?></strong>
	</div>
	<div class="panel-body">
		<a href="view.php?id=<?php echo $r->jobsid;?>">View</a> |
		<a href="edit.php?id=<?php echo $r->jobsid;?>">Edit</a>|
		<a href="delete.php?id=<?php echo $r->jobsid;?>">Delete</a>
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
