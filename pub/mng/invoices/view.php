<?php


$section = "Invoices";
$page = "Invoices";

include "/srv/ath/src/php/mng/common.php";

$errors = array();




if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

	if((isset($_GET['id']))&&(is_numeric($_GET['id']))&&($_GET['id'])){

		$invoicesUpdate = new Invoices();
		$invoicesUpdate->setInvoicesid($_GET['id']);
		$invoicesUpdate->setPaid(time());
		$invoicesUpdate->updateDB();

		$logContent = 'Invoice marked as Paid for InvoiceID:' . $_GET['id'] ;
		$logresult = logEvent(26,$logContent);

		$done = 1;
	}

}

if( (isset($_GET['go'])) && ($_GET['go'] == "undopaid") ){

	if((isset($_GET['id']))&&(is_numeric($_GET['id']))&&($_GET['id'])){

		$invoicesUpdate = new Invoices();
		$invoicesUpdate->setInvoicesid($_GET['id']);
		$invoicesUpdate->setPaid(0);
		$invoicesUpdate->updateDB();

		$logContent = 'Invoice marked UNPaid for InvoiceID:' . $_GET['id'] ;
		$logresult = logEvent(26,$logContent);

		$done = 1;
	}

}



$pagetitle = "Home";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";

include "helptab.php";


if(!isset($siteMods['invoices'])){
	?>
<h2>This Athena Module has not been activated</h2>
<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
exit;
}



$sqltext = "SELECT jobs.incept,jobs.jobno,jobs.jobsid,jobs.done,jobs.notes,

jobs.custref,jobs.itemsid,

cust.co_name,cust.inv_contact,addsid,

invoices.invoicesid,invoices.invoiceno,invoices.paid,invoices.incept as invincept

FROM jobs,items,cust,invoices
WHERE items.itemsid=jobs.itemsid
AND jobs.invoicesid = invoices.invoicesid
AND jobs.custid=cust.custid
AND jobs.itemsid=items.itemsid
AND invoices.invoicesid='". addslashes($_GET['id']) ."'";

#print $sqltext;exit;

$res = $dbsite->query($sqltext); # or die("Cant get jobs");
if (! empty($res)) {
	$r = $res[0];
}else{
	header("Location: /jobs/");
	exit();
}

$adds = getAddress($r->addsid);

$url = base64_encode("/mail/invoice.php?id=".$_GET['id']);

$invoicesid = $_GET['id'];
$paidLink = "<a href=\"/invoices/?go=y&id=$invoicesid\" title=\"Mark as Paid\">Mark as Paid</a>";
$nonpaidLink = "<a href=\"/invoices/?go=undopaid&id=$invoicesid\" title=\"Mark as Not Paid\">Undo</a>";

$paid = ($r->paid>0) ? "Paid: " . date("d-m-Y",$r->paid) . $nonpaidLink : $paidLink;



?>
<br clear="all">
<span id=pageactions> <span style="font-size: 90%; color: #999;">For
		this Invoice:- </span>


		<i class="fa fa-pencil-square-o"></i> <a
	href="/invoices/edit?id=<?php echo $_GET['id'];?>"
	title="Edit the Invoice">Edit</a>

	|

	<i
	class="fa fa-file-pdf-o"></i>
	<a
	href="/bin/make_pdf_invoice.pl?id=<?php echo $_GET['id'];?>&sid=<?php echo $sitesid;?>"
	title="Download PDF"> Download PDF </a>

| <i class="fa fa-money"></i> <?php echo $paid; ?>
<?php
	$retHTML = '';
	if($sent>0){
		$sent = 'Sent '.date('H:i d/m/Y',$sent);
		$retHTML .= '| <i class="fa fa-envelope" title="'.$sent.'"></i>';
	}else{
		$sent = '';
		$retHTML .= '| <i class="fa fa-envelope-o" title="Not sent yet"></i>';
	}
	echo $retHTML;
	?>
	<form action="/mail/send_owl" method="post"
		enctype="multipart/form-data" style="display: inline;">
		<a href="javascript:void(0);" onclick="parentNode.submit();">Email
			to Customer
		</a> <input type="hidden" name=url value="<?php echo $url; ?>">
	</form>

</span>
<h1>
	View Invoice
	<?php echo $r->invoiceno;?>
</h1>



<div style="width: 720px;">
	<div
		style="float: right; width: 270px; text-align: right; padding-right: 0px;">
		<table cellpadding=4>
			<tr>
				<td align=right>Date:</td>
				<td><?php echo date("Y-m-d", $r->invincept)?></td>
			</tr>
			<tr>
				<td align=right>Customer Ref:</td>
				<td><?php echo $r->custref?></td>
			</tr>
			<tr>
				<td align=right><?php echo $owner->co_nick; ?> Invoice No:</td>
				<td><?php echo $r->invoiceno?></td>
			</tr>
		</table>
	</div>
	Invoice to:-<br>
	<?php

	echo $r->co_name . '<br>';

	include '/srv/ath/src/php/tmpl/adds.view.html.sm.php';

	?>
	<br>
	<?php
	if( isset($r->inv_contact) && $r->inv_contact!='' && $r->inv_contact>0 && is_numeric($r->inv_contact)){
		print "<br>FAO: " . getCustExtName($r->inv_contact) . "<br>";
	}
	?>
	<br clear="all">

	<h2>SALES INVOICE</h2>

	<span style="font-size: 80%; font-weight: bold;">Job Description</span><br>
	<br>
	<?php

	$sqltextItems = "SELECT * FROM iitems WHERE invoicesid='$invoicesid'";

	#print $sqltextItems;
	$printHeader = 1;
	$qItems = $dbsite->query($sqltextItems) or die("Cant get items");
	$total=0;
	if (! empty($qItems)) {
		foreach($qItems as $rItems) {



			if ($printHeader){
				?>
	<table>
		<tr style="color: #666;">
			<td style="width: 500px;">Details</td>
			<td style="width: 100px; text-align: center;">Quantity</td>
			<td style="width: 100px; text-align: center;">Item Price</td>
			<td style="width: 100px; text-align: center;">Price</td>
		</tr>
		<?php
			}
			$printHeader = 0;
			?>

		<tr style="border: 1px solid #999;">
			<td valign="top" style="padding: 16px;"><?php echo stripslashes($rItems->content)?>
			</td>
			<?php

			if((isset($rItems->hours)) && ($rItems->hours>0)){
				?>

			<td  style="width: 100px; text-align: center;"><?php echo $rItems->hours; ?> Hours</td>
			<td  style="width: 100px; text-align: center;">&pound;<?php echo $rItems->rate; ?>
			</td>
			<?php

			$subtotal = $rItems->hours * $rItems->rate;

			}else{
				if($rItems->price>0){
					?>
			<td style="width: 100px; text-align: center;">X <?php echo $rItems->quantity?>
			</td>
			<td style="width: 100px; text-align: center;">&pound;<?php echo $rItems->price?>
			</td>
			<?php

			$subtotal = $rItems->quantity * $rItems->price;

				}
			}



			?>
			<td style="width: 100px; text-align: center;">&pound;<?php echo $subtotal; ?>
			</td>
		</tr>

		<?php

		$total += $subtotal;
		}
	}
	?>


	</table>
	<br> <br>
	<?php
	if(isset($siteMods['vat'])){
		$vat_rate = getVAT_Rate($r->invincept);
		$vat_rateText = getVatText($vat_rate);

		$vat = round($total * $vat_rate, 2 );
		$totalprice = $total + $vat;
	}else{
		$totalprice = $total;
	}

	setlocale(LC_MONETARY, 'en_GB');
	?>

	<div style="text-align: right; padding-right: 40px;">

		<?php
		if(isset($siteMods['vat'])){

			?>
		Price &pound;
		<?php echo money_format('%i', $total);?>
		<br> VAT @
		<?php echo $vat_rateText;?>
		= &pound;
		<?php echo money_format('%i', $vat);

		}
		?>
		<br>

		<h3>
			Amount Due &pound;
			<?php echo money_format('%i', $totalprice)?>
		</h3>
		<br>
	</div>
	<br clear="all">

</div>
<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>