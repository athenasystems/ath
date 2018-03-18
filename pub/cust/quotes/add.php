<?php
$page = "Quotes";

include "/srv/ath/src/php/cust/common.php";
include "/srv/ath/src/php/athena_mail.php";

$_POST['custid'] = $custID;
$errors = array();

$done = "";

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	$required = array(
			"custid"
	);
	$errors = check_required($required, $_POST);

	$items = $_POST['item'];
	if($items[0]['content']==''){
		$errors[] = 'item[0][content]';
	}
	$errors = array_merge($errors, check_items($items));


	if (empty($errors)) {

		$logContent = "\n";

		$fields = array_merge($required, array(
				"contactsid",
				"staffid",
		));


		foreach ($fields as $name) {
			$logContent .= $name . ':' . $_POST[$name] . "\n";
		}
		// Add the quote to the Quotes table
		$quoteno = getNextQuoteNo();
		$quotesNew = new Quotes();
		$quotesNew->setStaffid($_POST['staffid']);
		$quotesNew->setCustid($_POST['custid']);
		$quotesNew->setContactsid($_POST['contactsid']);
		$quotesNew->setQuoteno($quoteno);
		$quotesNew->setIncept(time());
		$quotesNew->setLive(1);
		$quotesNew->setOrigin('ext');
		$quotesid = $quotesNew->insertIntoDB();



		foreach ($items as $item) {
			if ($item['content'] != '') {
				$itemcontent = $item['content'];
				$itemquantity = $item['quantity'];
// 				$itemdeliveryDay = $item['datereq']['day'];
// 				$itemdeliveryMonth = $item['datereq']['month'];
// 				$itemdeliveryYear = $item['datereq']['year'];

				// Add the quote items to the Items table
				$itemsNew = new Items();
				$itemsNew->setIncept(time());
				$itemsNew->setContent(addslashes($itemcontent));
				$itemsid = $itemsNew->insertIntoDB();

// 				$datereq = mktime(0, 0, 0, $itemdeliveryMonth, $itemdeliveryDay, $itemdeliveryYear);

				$qitemsNew = new Qitems();
				$qitemsNew->setQuotesid($quotesid);
				$qitemsNew->setQuantity($itemquantity);
				$qitemsNew->setItemno(getNoOfItemsInQuote($quotesid) + 1);
				$qitemsNew->setContent(addslashes($itemcontent));
// 				$qitemsNew->setDatereq($datereq);
				$itemid = $qitemsNew->insertIntoDB();


				// print "$itemcontent $datereq $itemquantity<br>";
			}
		}

		// print var_dump($items);

		$logresult = logEvent(1, $logContent);

		// Send a mail to owner
		$htmlBody = <<<EOF
		A Customer has asked for a quotation via the Control Panel<br><br>
		<a href="$int_url/quotes/view.php?id=$quotesid">View the Quote Request</a><br><br>
EOF;

		// $owner->email='wmodtest@gmail.com';

		sendGmailEmail($owner->co_name, $owner->email, 'A Customer has asked for a Quotation', $htmlBody);

		header("Location: /quotes/view?id=" . $quotesid);
		exit();
	}
}

$pagetitle = "Add quote";
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

?>

<h2>
	Request a Quote from
	<?php echo $owner->co_name; ?>
</h2>
<p>&nbsp;</p>
<form action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">
	<?php
	foreach ($errors as $error){
		#echo $error ." ";
	}
	echo form_fail();
	?>
	<input type="hidden" name="MAX_FILE_SIZE" value="20971520" />
	<fieldset class="form-group">
		<?php

		$value = date("Y-m-d", time());
		$nowDay = date("d", time());
		$nowMonth = date("m", time());
		$nowYear = date("Y", time());

		custcontact_select("Your Name", "contactsid", $contactsID, $custID);

		staff_select($owner->co_nick . " Contact", "staffid", $_POST['staffid']);

		// html_textarea("Job Description *", "content", $_POST['content'], "body", "y");

		$itemArray = $_POST['item'];

		// if ($itemArray[0]['datereq']['year'] < $nowYear) {
		// $itemArray[0]['datereq']['day'] = $nowDay;
		// $itemArray[0]['datereq']['month'] = $nowMonth;
		// $itemArray[0]['datereq']['year'] = $nowYear;
		// }
		$blk = 'none';
		$noOfQitems=0;

		if($noOfQitems==0){
			$blk = 'display';
			$noOfQitems++;
		}

		if($_GET['d']==1){
			$blk = 'dev';
		}

		$last='';
		if($i==($noOfQitems-1)){
			$last='y';
		}


		itemBlock('0', $itemArray[0],  '', $blk,$last);

		for ($i = 1; $i <= 20; $i ++) {

			if($i==($noOfQitems-1)){
				$last='y';
			}
			if($_GET['d']==1){
				$blk = 'dev';
			}else{
				$blk = 'none';
			}
			itemBlock($i, $itemArray[$i],  '', $blk,$last);
		}

		?>

	</fieldset>

	<fieldset class="form-group">
		<?php
		html_button("Submit Quote Request");

		html_hidden("custid", $custID);
		?>
	</fieldset>
</form>
<br>
<br>
<?php
include "/srv/ath/pub/cust/tmpl/footer.php";
?>
