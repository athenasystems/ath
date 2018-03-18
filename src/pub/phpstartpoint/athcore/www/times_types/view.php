<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athcore/lib/Times_types.php";
$pageTitle = "Times_types Page";
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/header.php"; 
 

?>
<?php
$times_types = new Times_types();
// Load DB data into object
$times_types->setTimes_typesid($_GET['id']);
$times_types->loadTimes_types();
$all = $times_types->getAll();

if (isset($all)) {
		   ?>
		   
<div class="panel panel-info">
	<div class="panel-heading">
		<strong>Viewing <?php echo $times_types->getTimes_typesid();?></strong>
	</div>
	<div class="panel-body">
		<?php
    
    foreach ($all as $key => $value) {
        if (isset($value) && ($value != '')) {
            ?>
		    <dl class="dl-horizontal">
			<dt><?php echo $key;?></dt>
			<dd><?php echo $value;?></dd>
		</dl>
		    <?php
        }
    }
    
    ?>
	</div>
</div>
<?php
}else{
	?>
	<h2>No results found</h2>
	<?php
}
?>
<?php
include "/srv/ath/src/pub/phpstartpoint/athcore/tmpl/footer.php";
?>
