<?php

$section = "owner";
$page = "edit";

include "/srv/ath/src/php/adm/common.php";

$errors = array();

if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

}


$pagetitle = "Admin";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/adm/tmpl/header.php";

?>

<h2>Athena Modules</h2>

<?php

$sqltext = "SELECT * FROM athcore.sites ORDER BY sitesid";
#print $sqltext;
$res = $dbsys->query($sqltext) or die("Cant get site sites");
if (! empty($res)) {
	foreach($res as $r) {


		?>
<div class="container-fluid">
<div class="row">
  <div class="col-md-3">
  <strong><?php echo $r->co_name?></strong>
  </div>
  <div class="col-md-9">
  	<a href="mods?id=<?php echo $r->sitesid; ?>">Modules</a> | <a
		href="loginas?sid=<?php echo $r->sitesid; ?>" target=_blank>Log in
		as...</a>

  </div>
</div>
</div>


<?php


	}
}


?>



<?php
include "/srv/ath/pub/adm/tmpl/footer.php";
?>
