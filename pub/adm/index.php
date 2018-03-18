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

<h2>Athena</h2>



<?php
include "/srv/ath/pub/adm/tmpl/footer.php";
?>
