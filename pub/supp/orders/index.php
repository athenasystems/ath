<?php

	$page = "Orders";

	include "/srv/ath/src/php/supp/common.php";


	$errors = array();

	$done = "";

	$pagetitle = "Orders";
	$pagescript = array();
	$pagestyle = array();

	include "/srv/ath/pub/supp/tmpl/header.php";

if(!isset($siteMods['stock'])){
	?>
	<h2>This Athena Module has not been activated</h2>
	<?php
	include "/srv/ath/pub/supp/tmpl/footer.php";
	exit;
	}


?>


<h2><?php echo $owner->co_name; ?> Suppliers Tools</h2>

<h2>Orders</h2>

<?php

$sqltext = "SELECT * FROM order_req,orders,supp
WHERE order_req.suppid=supp.suppid
AND orders.ordersid=order_req.orderid
AND order_req.suppid=$suppID
AND agree>0
ORDER BY order_req.order_reqid DESC LIMIT 24";

	#print $sqltext ;

	$res = $dbsite->query($sqltext); # or die("Cant get Requested Items");

if (! empty($res)) {
	foreach($res as $r) {

			print getOrdersRowHTML($r);
		}

	}

?>

<br><br>

<br><br>

<?php
	include "/srv/ath/pub/supp/tmpl/footer.php" ;
?>
