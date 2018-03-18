<?php

	$page = "Quotes";

	include "/srv/ath/src/php/supp/common.php";


	$errors = array();

	$done = "";

	$pagetitle = "Quotes";
	$pagescript = array();
	$pagestyle = array();

	include "/srv/ath/pub/supp/tmpl/header.php";

if(!isset($siteMods['orders'])){
	?>
<h2>This Athena Module has not been activated</h2>
<?php
include "/srv/ath/pub/supp/tmpl/footer.php";
#exit;
}



?>

<h2><?php echo $owner->co_name; ?> Suppliers Tools</h2>

<h2>Quotes</h2>
<?php

$sqltext = "SELECT * FROM orders,order_req,supp
WHERE order_req.orderid=orders.ordersid
AND order_req.suppid=supp.suppid
AND orders.ordersid>0
AND agree<1
AND supp.suppid=$suppID
ORDER BY orders.ordersid DESC LIMIT 24";
	#print $sqltext ;


	$res = $dbsite->query($sqltext); # or die("Cant get Requested Items");

if (! empty($res)) {
	foreach($res as $r) {

			print getRequestQuoteRowHTML($r);
		}

	}

?>

<br><br>

<br><br>

<?php
	include "/srv/ath/pub/supp/tmpl/footer.php" ;
?>
