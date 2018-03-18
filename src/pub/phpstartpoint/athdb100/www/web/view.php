<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Web.php";
$pageTitle = "Web Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php"; 
 

?>
<?php
$web = new Web();
// Load DB data into object
$web->setWebid($_GET['id']);
$web->loadWeb();
$all = $web->getAll();

if (isset($all)) {
		   ?>
		   
<div class="panel panel-info">
	<div class="panel-heading">
		<strong>Viewing <?php echo $web->getWebid();?></strong>
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
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
