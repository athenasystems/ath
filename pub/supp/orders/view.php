<?php

$section = "pages";
$page = "Orders";

include "/srv/ath/src/php/supp/common.php";



$errors = array();


$pagetitle = "View Order";
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


$sqltext = "SELECT * FROM order_req,orders,supp
WHERE order_req.suppid=supp.suppid
AND orders.ordersid=order_req.orderid
AND orders.ordersid=". $_GET['id'] ;
#print $sqltext;
$res = $dbsite->query($sqltext); # or die("Cant get orders");

if (! empty($res)) {
	$r = $res[0];
}else{
	#header("Location: /orders/");
	#exit();
}



$ordersid = $r->ordersid;
$reqOrderdate = date('d-m-Y',$r->incept);
$datereq = date('d-m-Y',$r->datereq);

$r->content = preg_replace("/\r\n/", "<br>" , $r->content);
#$r->content = preg_replace("/\r/", "<br>" , $r->content);

$int_contact = getStaffName($r->staffid);

?>
<h1>
	Order Request No:
	<?php echo $r->ordersid?>
</h1>
<?php

tablerow("Date",$reqOrderdate);
tablerow("Internal Contact",$int_contact);
tablerow("Order Description",$r->content);
tablerow("Quantity",$r->quantity);
tablerow("Date Required",$datereq);

$value = date("d-m-Y", $r->dateoff);
$suppnotes = htmlentities(stripslashes($r->suppnotes));

?>

<div class="clearfix"></div>
<br clear=all>

You have submitted a Order for this request as follows:-
<ul>

	<li>Date Offered to deliver by:- <?php echo $value?>
	</li>
	<li>Price Offered: &pound;<?php echo $r->priceoff?>
	</li>
	<li>Your Notes for this Order: <?php echo $suppnotes?>
	</li>
	<li><span style="color: red;">This Order has been Approved and a
			purchase order has been sent via Email.<br>
	</span> <input type=button value="Resend Purchase Order"
		onclick="openPurchaseOrderMail(<?php echo $r->ordersid?>)">
	</li>
</ul>


<br>
<br>
<?php
include "/srv/ath/pub/supp/tmpl/footer.php";
?>
