<?php
$section = "Account";
$page = "Account";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

if ((isset($_GET['go'])) && ($_GET['go'] == "remove")) {

    $required = array(
        "pid"
    );
    $errors = check_required($required, $_GET);
    
    if(!is_numeric($_GET['pid'])){
        $errors[]='pid';
    }

    if (empty($errors)) {

        $logContent = "\n";

        $salesNew = new Sales();
        $salesNew->setSitesid($sitesid);
        $salesNew->setProductsid($_GET['pid']);
        $salesNew->setIncept(0);
        $salesNew->insertIntoDB();

        $sql ="DELETE FROM mods WHERE sitesid=$sitesid AND modulesid=".$_GET['pid'];
        $resRemove = $dbsys->db->query($sql);
        
        // $logresult = logEvent(13,$logContent);
        header("Location: /acc/?ModuleDeleted");
    }
}


$pagetitle = "Account";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";

setlocale(LC_MONETARY, 'en_GB');
$siteModIDs = getSiteModIDs();

$total_price = 0;
$base_price = 575;
$sales = array();
$sqltext = "SELECT * FROM sales
WHERE sitesid=$sitesid
ORDER BY incept";
$res = $dbsys->query($sqltext); // or die("Cant get sales");
if (! empty($res)) {
    foreach ($res as $r) {
        array_push($sales, $r->productsid);
    }
}
?>

<h3>Module Store</h3>
<form class=""
	action="<?php echo $_SERVER['PHP_SELF']?>?go=y&id=<?php echo $_GET['id'];?>"
	enctype="multipart/form-data" method="post">
	<?php echo form_fail(); ?>

	<fieldset class="form-group">
		<?php

$js = '';
$sqltext2 = "SELECT * FROM athcore.modules
		WHERE price IS NOT NULL AND price>0 AND base=0 AND display=1 ORDER BY modulesid";
// print $sqltext;
$res2 = $dbsys->query($sqltext2); // or die("Cant get site modules");

$siteMods = array();
foreach ($res2 as $r2) {
    ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<span style="font-size: 140%;"> <?php echo $r2->name;?> Module
				</span>
				<div style="float: right;">
					<!-- Price: &pound;
					<?php
    
  #  echo money_format('%i', ($r2->price / 100));
    
    ?>
					-->
					<?php
    
    if (in_array($r2->modulesid, $siteModIDs)) {
        $total_price = $total_price + $r2->price;
        ?>
					<a class="btn btn-primary"
						href="/acc/?go=remove&pid=<?php echo $r2->modulesid;?>"
						title="Remove this Module"><strong>Remove</strong> </a>
											<?php
    } else {
        ?>
					<a class="btn btn-primary"
						href="/acc/agree?pid=<?php echo $r2->modulesid;?>"
						title="Purchase this Module"><strong>Add</strong> </a>
					<?php
    }
    ?>
				</div>
				<br clear="all">
			</div>
			<div class="panel-body">
				<div style="float: left;">
					<?php echo $r2->description;?>
				</div>
			</div>
		</div>
		<?php
}
?>
	</fieldset>
</form>

<br clear="all">
<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
exit();
?>
<div>
	<h3>Your Payments</h3>
	Your Monthly Payment is: &pound;
	<?php
$monthly_total = $base_price + $total_price;
echo money_format('%i', ($monthly_total / 100));
if (isset($monthly_total) && ($monthly_total > 0)) {
    ?>
	Please set up a standing order to our bank account:<br> <br> Bank Name:
	<br> Account Name: Web Minions Ltd.<br> Account Number: 675756757<br>
	Sort Code: 23 43 53<br>Ref#:
	<?php echo 'ATHENA'. $sitesid;?>
	<?php
}
?>
</div>



