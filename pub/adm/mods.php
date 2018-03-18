<?php
$section = "owner";
$page = "edit";

include "/srv/ath/src/php/adm/common.php";

$errors = array();

$sitesid = $_GET['id'];

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {
    
    $sqltext = "DELETE FROM mods WHERE sitesid=$sitesid";
    // print $sqltext;
    $q = $dbsys->query($sqltext) or die("Cant delete site modules");
    
    $allSiteModIDs = getAllSiteModIDs();
    
    $modsNew = new Mods();
    $modsNew->setSitesid($_POST['sitesid']);
    
    foreach ($allSiteModIDs as $siteModID) {
        if (isset($_POST['mod' . $siteModID])) {
            $modsNew->setModulesid($siteModID);            
            $modsNew->insertIntoDB();
        }
    }
}

$pagetitle = "Admin";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/adm/tmpl/header.php";

?>

<h2>Athena Modules</h2>


<form
	action="<?php echo $_SERVER['PHP_SELF']?>?go=y&id=<?php echo $_GET['id']?>"
	enctype="multipart/form-data" method="post">
	<?php echo form_fail(); ?>

	<fieldset class="form-group">

		<?php

$siteModIDs = getSiteModIDs();
$js = '';
echo "Has Modules: ";
foreach ($siteModIDs as $siteModID) {
    echo getSiteModName($siteModID) . ", ";
    $js .= "document.getElementById('mod$siteModID').checked = true;";
}

$sqltext = "SELECT * FROM athcore.modules ORDER BY modulesid";
// print $sqltext;
$res = $dbsys->query($sqltext) or die("Cant get site modules");

$siteMods = array();

if (! empty($res)) {
    foreach ($res as $r) {
        ?>
		<div>
			<?php
        html_checkbox($r->name, 'mod' . $r->modulesid, $r->modulesid);
        
        ?>
		</div>
		<?php
    }
}

?>


	</fieldset>


	<fieldset class="form-group">
		<?php
html_button("Save da mods");
?>


	</fieldset>
	<?php

html_hidden("itemsid", '0');

?>
</form>
<script>
	window.onload = init;
function init(){
<?php
echo $js;
?>
}
</script>
<?php
include "/srv/ath/pub/adm/tmpl/footer.php";
?>
