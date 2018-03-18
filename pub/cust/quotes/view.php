<?php
$page = "Quotes";

include "/srv/ath/src/php/cust/common.php";
include "/srv/ath/src/php/athena_mail.php";

$errors = array();

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	$qItemsIDs = $_POST['qitemsid'];
	if(!empty($qItemsIDs)){
		foreach ($qItemsIDs as $qItemsID){
			$qitemsUpdate = new Qitems();
			$qitemsUpdate->setQitemsid($qItemsID);
			$qitemsUpdate->setAgreed(time());
			$qitemsUpdate->updateDB();
		}
		$quotesid = $_POST['quotesid'];
		$co_name = $_POST['co_name'];
		$quoteno = $_POST['quoteno'];

		$htmlBody = <<<EOF
	A Customer has agreed to a quotation via the Control Panel<br><br>
	$co_name agree to Quote No: $quoteno<br><br>
	<a href="$int_url/quotes/view.php?id=$quotesid">View the Quote Request</a>
	<br><br>
EOF;

		sendGmailEmail($owner->co_name, $owner->email, 'A Customer has agreed to all the items on a Quotation', $htmlBody);

		header("Location: /quotes/?highlight=" . $result['id']);

		exit();
	}else{
		$errors[] = '';
	}
}

$pagetitle = "View Quote";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/cust/tmpl/header.php";

if (! isset($siteMods['quotes'])) {
	?>
<h2>This Athena Module has not been activated</h2>
<?php
include "/srv/ath/pub/cust/tmpl/footer.php";
exit();
}

$sqltext = "SELECT * FROM quotes,cust
WHERE quotes.custid=cust.custid
AND cust.custid=$custID
AND quotes.quotesid='" . addslashes($_GET['id']) . "' AND quotesid>0";
$res = $dbsite->query($sqltext); # or die("Cant get quotes");
if (! empty($res)) {
	$r = $res[0];

	$qno = $r->quoteno;

	$quotedate = date('d-m-Y', $r->incept);
	$datereq = (isset($r->datereq)) ? date('d-m-Y', $r->datereq) : 'N/a';

	$r->content = preg_replace("/\r\n/", "<br>", $r->content);

	$int_contact = getStaffName($r->staffid);
	$ext_contact ='';
	if (isset($r->contactsid) && is_numeric($r->contactsid)) {
		$ext_contact = getCustExtName($r->contactsid);
	}

	?>
<br>

<h1>
	Quote No:
	<?php echo $r->quoteno;?>
	for
	<?php echo $r->co_name;?>
</h1>

<br>
<br>
<style>
#tabcellhead {
	border: 1px solid #999;
	padding: 2px;
	white-space: nowrap;
	color: #666;
	font-size: 90%;
	background-color: #ddd;
	text-align: center;
}

#tabcell {
	border: 1px solid #999;
	padding: 2px;
	text-align: center;
	white-space: nowrap;
}

#tabcellmetric {
	border: 1px solid #333;
	padding: 2px;
	color: #666;
	font-size: 90%;
}
</style>
<form
	action="<?php echo $_SERVER['PHP_SELF'];?>?go=y&id=<?php echo $_GET['id'];?>"
	enctype="multipart/form-data" method="post">
	<table>
		<tr>
			<td id=tabcellhead>Description</td>
			<td id=tabcellhead>Quantity</td>
			<td id=tabcellhead>Unit Price</td>
			<td id=tabcellhead>Total Price</td>
			<td id=tabcellhead>Action</td>
		</tr>
		<?php
		$quoteTotal = 0;
		$showButt = 0;

		$sqltext = "SELECT qitemsid,quantity,content,price,agreed,quantity,hours,rate
		FROM qitems
		WHERE quotesid='" . $r->quotesid . "'
		ORDER BY qitems.price DESC";
		$dres = $dbsite->query($sqltext) or die("Cant get quotes");
		if (! empty($dres)) {
			foreach ($dres as $e) {
				?>
		<tr>
			<td id=tabcellmetric><?php echo stripslashes($e->content);?></td>
			<td id=tabcell><?php

			if((isset($e->quantity))&&(is_numeric($e->quantity))&&($e->quantity>0)){
				echo $e->quantity;
			}else{
				echo $e->hours . '&nbsp;Hours';
			}

			?></td>
			<td id=tabcell><?php

			if((isset($e->price))&&(is_numeric($e->price))&&($e->price>0)){
				echo '&pound;' . $e->price;
			}else{
				echo '@ &pound;' . $e->rate;
			}
			?>
			</td>

			<td id=tabcell><?php

			if((isset($e->price))&&(is_numeric($e->price))&&($e->price>0)){
				echo '&pound;' . ($e->price* $e->quantity);
			}else{
				echo '&pound;' . ($e->hours* $e->rate);
			}
			?>
			</td>

			<td id=tabcell><?php

			if (! $e->price) {
				?> Awaiting Quotation <?php
			}
			elseif (! $e->agreed) {
				?> <input type="checkbox" checked=checked name="qitemsid[]"
				class="c-input c-checkbox" value="<?php echo $e->qitemsid; ?>"> <?php
				$showButt++;
			} else {
				?>Quote Agreed<?php
			}
			?>
			</td>
		</tr>
		<?php

		if((isset($e->price))&&(is_numeric($e->price))&&($e->price>0)){
			$quoteTotal = $quoteTotal + ($e->price * $e->quantity);
		}else{
			$quoteTotal = $quoteTotal +  ($e->hours* $e->rate);
		}

			}
		}

		?>

	</table>

	<?php
	if($showButt){
		html_button("Agree to selected Items");
		html_hidden("quotesid", $_GET['id']);
	}
	?>
</form>

<div class="clearfix"></div>
<br clear=all>
<br>
<?php

if ( $e->price) {
	?>
Quote Total Price: &pound;
<?php echo $quoteTotal;?>
<?php
}
?>
<br>
<br>
<p>&nbsp;</p>

<?php
} else {

	?>
<h2>No Quote to show</h2>
<?php
}

include "/srv/ath/pub/cust/tmpl/footer.php";
?>
