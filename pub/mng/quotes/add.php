<?php
$section = "quotes";
$page = "Quotes";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	$required = array("custid");

	$errors = check_required($required, $_POST, 1);

	$items = $_POST['item'];

	if($items[0]['content']==''){
		$errors[] = 'item[0][content]';
	}

	$errors = array_merge($errors, check_items($items));

	if (empty($errors)) {

		$logContent = "\n";
		$quoteno = getNextQuoteNo();
		$quotesNew = new Quotes();
		$quotesNew->setStaffid($_POST['staffid']);
		$quotesNew->setCustid($_POST['custid']);
		$quotesNew->setContactsid($_POST['contactsid']);
		$quotesNew->setQuoteno($quoteno);
		$quotesNew->setIncept(time());
		$quotesid = $quotesNew->insertIntoDB();

		$itemno = 1;
		foreach ($items as $item) {
			if ($item['content'] != '') {

				$price = $item['price'];
				$quantity =  $item['quantity'];

				if(is_numeric($item['singleprice'])&&($item['singleprice']>0)){
					$price =$item['singleprice'];
					$quantity = 1;
				}

				$qitemsNew = new Qitems();
				$qitemsNew->setQuotesid($quotesid);
				$qitemsNew->setQuantity($quantity);
				$qitemsNew->setItemno($itemno);
				$qitemsNew->setContent(addslashes($item['content']));
				$qitemsNew->setPrice($price);
				$qitemsNew->setHours($item['hours']);
				$qitemsNew->setRate($item['rate']);
				$itemid = $qitemsNew->insertIntoDB();
				unset($qitemsNew);
				$itemno++;
			}
		}

		// Make the Data Folder
		mkDataDir($quoteno);

		$logresult = logEvent(1, $logContent);

		if ($_POST['addmore']) {
			header("Location: /quotes/addqitems?id=" . $quotesid);
		} else {
			header("Location: /quotes/?id=" . $quotesid);
		}

		exit();
	}
}

$pagetitle = "Add quote";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";

include "helptab.php";

if (! isset($siteMods['quotes'])) {
	?>
<h2>This Athena Module has not been activated</h2>
<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
exit();
}
if ((isset($_GET['rfqid'])) && (is_numeric($_GET['rfqid']))) {
	$sqltext = "SELECT * FROM rfq WHERE rfqid={$_GET['rfqid']} LIMIT 1";
	$resA = $dbsite->query($sqltext);
	$rA = $resA[0];
	$_POST['itemcontent'] = $rA->content;
	$_POST['quantity'] = $rA->quantity;
}
?>

<h2>Add a New Quote</h2>

<form
	action="<?php echo $_SERVER['PHP_SELF']?>?go=y&id=<?php echo $_GET['id'];?>&d=<?php echo $_GET['d'];?>"
	enctype="multipart/form-data" method="post"  role="form">
	<?php
	foreach ($errors as $error){
		#echo $error ." ";
	}
	echo form_fail();
	?>

	<fieldset class="form-group">

		<?php
		if (!isset($_GET['id'])) {
			?>
		<div>
			<a href="/customers/add?backto=quotes" title="Quote a New Customer"
				id=newcust>Quote a New Customer</a>
		</div>
		<br>
		<?php
		}
		$noOfQitems=0;

		customer_quote_select("Customer&nbsp;*", "custid", $_GET['id'], 1, 0);

		if (isset($_GET['id'])) {
			$itemArray = $_POST['item'];

			$blk = 'none';

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

			$last='';
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
		}
		?>
		<div id=contactlist>
			<?php
			// 		custcontact_select('Contact','contactsid','',$_GET['id']);
			?>
		</div>
		<?php
		// 		staff_select("Internal Contact", "staffid", $_POST['staffid']);
		?>

	</fieldset>
		<br >
	<span id=pagetotal style="font-size: 160%; color: #999;"></span>
		<br >
	<fieldset class="form-group">
		<?php
		if (isset($_GET['id'])) {
			html_button("Save &amp; Continue");
		}
		?>
	</fieldset>
</form>
<br>
<br>

<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
