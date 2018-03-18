<?php

$page = "Quotes";


include "/srv/ath/src/php/athena_mail.php";
include "/srv/ath/src/php/supp/common.php";
include "/srv/ath/src/php/supp/functions_email.php";


$errors = array();

$sqltext = "SELECT * FROM orders,order_req,supp
WHERE order_req.orderid=orders.ordersid
AND order_req.suppid=supp.suppid
AND supp.suppid=$suppID
AND orders.ordersid='". $_GET['id'] ."' AND ordersid>0";
#print $sqltext;
$res = $dbsite->query($sqltext); # or die("Cant get suppliers orders");


if (! empty($res)) {
	$r = $res[0];
}else{
	header("Location: /quotes/");
	exit();
}


if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

	$required = array( "dateoff", "priceoff" );
	$errors = check_required($required, $_POST);

	if(empty($errors)){

		$input['dateoff'] = getEpochFromCalPop($_POST['dateoff']);
		$input['priceoff'] = $_POST['priceoff'];
		$input['notes'] = $_POST['notes'];

		$result = db_update("order_req", $input, $r->order_reqid, 'order_reqid');

		$htmlBody=<<<EOF
		A Supplier has submitted a quote via the Control Panel<br><br>
		<a href="$int_url/orders/view_offer.php?id={$_GET['id']}&suppid=$suppID">View the Quotation</a><br><br>
EOF;

			sendGmailEmail($owner->co_name,$owner->email,'A Supplier has submitted a quote',$htmlBody);

			if((isset($_POST['selfsend']))&&($_POST['selfsend']==1)){
				$htmlBody=getOrderCopyMailBody($_GET['id']);
				if($htmlBody){
					sendGmailEmail($r->co_name,$r->email,'Confirmation of your Quote',$htmlBody);
				}
			}

		header("Location: /quotes/?highlight=". $result['id']);

		exit();
	}

}


$pagetitle = "View Request for Quote";
$pagescript = array("/pub/calpop/calendar_eu.js");
$pagestyle = array("/css/calendar.css");

$quotedate = date('d-m-Y',$r->incept);
$datereq = ($r->datereq) ? date('d-m-Y',$r->datereq) : 'N/a';
$r->content = preg_replace("/\r\n/", "<br>" , $r->content);
#$r->content = preg_replace("/\r/", "<br>" , $r->content);

$int_contact = getStaffName($r->staffid);

include "/srv/ath/pub/supp/tmpl/header.php";


if(!isset($siteMods['orders'])){
	?>
<h2>This Athena Module has not been activated</h2>
<?php
include "/srv/ath/pub/supp/tmpl/footer.php";
exit;
}



?>
<h1>
	Request for Quote No:
	<?php echo $_GET['id']?>
	for
	<?php echo $r->co_name?>
</h1>

<?php
tablerow("Your {$owner->co_nick} Contact",$int_contact);
tablerow("Order Description",stripslashes($r->content));
tablerow("Quantity",$r->quantity);
tablerow("{$owner->co_nick} Requested<br>Delivery Date",$datereq);

$dateoff = ($r->dateoff) ? date("d-m-Y",$r->dateoff) : '';

?>
<br>
<br>

<form
	action="<?php echo $_SERVER['PHP_SELF']?>?go=y&id=<?php echo $_GET['id']?>"
	enctype="multipart/form-data" method="post">
	<?php echo form_fail(); ?>

	<fieldset class="form-group">


		<ol>
			<?php
			$dateofferror = '';
			if(isset($errors) && in_array('dateoff', $errors)) $dateofferror .= " class=\"error\"";
			$priceofferror = '';
			if(isset($errors) && in_array('priceoff', $errors)) $priceofferror .= " class=\"error\"";

			?>
			<li><label for=dateoff <?php echo $dateofferror?>>Date you can deliver by *</label>
				<input type="text" name="dateoff" id="dateoff" value="<?php echo $dateoff?>"
				style="width: 110px;" <?php echo $dateofferror?> /> <script
					language="JavaScript">
	var o_cal = new tcal ({
		'controlname': 'dateoff'
	});
</script> <span class=help>&lt;-- Click to enter a date (DD-MM-YYYY)</span>
			</li>

			<li><label for=priceoff <?php echo $priceofferror?>>Price &pound; *</label> <input
				type="text" name="priceoff" id="priceoff"
				value="<?php echo $r->priceoff?>" style="width: 110px;"
			<?php echo $priceofferror?> /> <span class=help>&lt;-- Enter Decimal numbers
					only e.g. 500 or 45.30</span></li>

			<?php

			html_textarea("Explanation", "notes", stripslashes($r->notes), "notes", "y");
			?>

		</ol>

	</fieldset>

	<div class="clearfix"></div>

	<?php
	if(!$r->agree){
		?>
	<fieldset class="form-group">
		<?php
		html_button("Send Quote to {$owner->co_nick}");
		html_hidden("ordersid",$_GET['id']);
?>
	</fieldset>
</form>
<?php
	}else{
		?>
			<h2>This Quote has been agreed on <?php echo date("d/m/Y",$r->agree);?></h2>
				<?php
	}
	?>

<br>
<br>

<?php
	include "/srv/ath/pub/supp/tmpl/footer.php";
	?>
