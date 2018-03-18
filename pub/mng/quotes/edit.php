<?php
$section = "quotes";
$page = "Quotes";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

if (isset($_GET['remove']) && $_GET['remove'] == "y" && isset($_GET['id']) && is_numeric($_GET['id'])) {

	$quotesDelete = new Quotes();
	$quotesDelete->setQuotesid($_GET['id']);
	$quotesDelete->deleteFromDB();

	header("Location: /quotes/");
	exit();
}

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	$required = array(
			"incept",
			"custid"
	);
	$errors = check_required($required, $_POST);

	$items = $_POST['item'];

	if($items[0]['content']==''){
		$errors[] = 'item[0][content]';
	}

	$errors = array_merge($errors, check_items($items));

	if (empty($errors)) {

		$_POST['incept'] = mktime(0, 0, 0, $_POST['incept']['month'], $_POST['incept']['day'], $_POST['incept']['year']);

		if ($_POST['live'] != 1) {
			$_POST['live'] = 0;
		}

		$quotesUpdate = new Quotes();
		$quotesUpdate->setQuotesid($_GET['id']);
		$quotesUpdate->setStaffid($staffid);
		$quotesUpdate->setCustid($_POST['custid']);
		#$quotesUpdate->setContactsid($_POST['contactsid']);
		$quotesUpdate->setIncept($_POST['incept']);
		$quotesUpdate->setLive($_POST['live']);
		$quotesUpdate->updateDB();

		$itemno = 1;
		foreach ($items as $item) {
			if ($item['content'] != '') {

				$price = $item['price'];
				$quantity =  $item['quantity'];

				if(is_numeric($item['singleprice'])&&($item['singleprice']>0)){
					$price =$item['singleprice'];
					$quantity = 1;
				}

				if(qitemExits($item['qitemsid'])){
					$qitemsUpdate = new Qitems();
					$qitemsUpdate->setQitemsid($item['qitemsid']);
					$qitemsUpdate->setQuotesid($_GET['id']);
					$qitemsUpdate->setItemno($itemno);
					$qitemsUpdate->setContent(addslashes($item['content']));
					$qitemsUpdate->setPrice($price);
					$qitemsUpdate->setQuantity($quantity);
					$qitemsUpdate->setHours($item['hours']);
					$qitemsUpdate->setRate($item['rate']);
					$qitemsUpdate->updateDB();
					unset($qitemsUpdate);
				}else{
					$qitemsNew = new Qitems();
					$qitemsNew->setQuotesid($_GET['id']);
					$qitemsNew->setQuantity($quantity);
					$qitemsNew->setItemno($itemno);
					$qitemsNew->setContent(addslashes($item['content']));
					$qitemsNew->setPrice($price);
					$qitemsNew->setHours($item['hours']);
					$qitemsNew->setRate($item['rate']);
					$itemid = $qitemsNew->insertIntoDB();
					unset($qitemsNew);
				}
				$itemno++;
			}
		}

		$logresult = logEvent(5, $logContent);

		header("Location: /quotes/view?id=" . $_GET['id']);
		exit();
	}
}

$pagetitle = "Edit Quote";
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

$sqltext = "SELECT * FROM quotes WHERE quotesid='" . addslashes($_GET['id']) . "'";
$res = $dbsite->query($sqltext); # or die("Cant get quotes");
if (! empty($res)) {
	$r = $res[0];
} else {
	header("Location: /quotes/");
	exit();
}

?>
<script type="text/javascript">
<!--
function confirmation() {
	var answer = confirm("Sure you want to delete this Quote?");
	if (answer){
		window.location = "/quotes/edit?id=<?php echo $_GET['id']?>&remove=y";
	}
	else{
		alert("Quote not Deleted");
	}
}
//-->
</script>

<a href="javascript:void(0);" title="Remove this item" class="cancel"
	onclick="confirmation();">Delete Quote</a>
<h2>
	Edit Quote No:
	<?php echo $r->quoteno?>
</h2>

<form
	action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $_GET['id']?>&amp;go=y"
	enctype="multipart/form-data" method="post">
	<?php
	foreach ($errors as $error){
		#echo $error ." ";
	}

	form_fail();
	html_hidden('quoteno', $r->quoteno);
	?>
	<fieldset class="form-group">

		<?php
		if (! $r->incept) {
			$r->incept = time();
		}
		// Quotes submitted via Control Panel have no Quote Date initially
		$value = date("Y-m-d", $r->incept);
		html_dateselect("Date", "incept", $value);

		customer_select("Customer", "custid", $r->custid);

		custcontact_select("External Contact", "contactsid", $r->contactsid, $r->custid);

		#staff_select("Internal Contact", "staffid", $r->staffid);

		// html_textarea("Notes", "notes", $r->notes, "notes", "y");
		?>

		<?php
		$chkd = ($r->live) ? 1 : 0;
		html_checkbox('Make it Live?', 'live', 1, $chkd);

		?>
		<div>Making a Quote as Live means it can be seen by customer in the
			Customer Control Panel</div>
	</fieldset>

	<fieldset class="form-group">
		<?php

		$itemArray = array();
		if(isset($_POST['item'][0])){
			$itemArray = $_POST['item'];
		}else{
			for ($i = 0; $i <= 20; $i ++) {

			}
		}
		$noOfQitems=0;
		if ((isset($_GET['id'])) && ($_GET['id'] >0)) {

			$qItemsIDs = $_POST['qitemsid'];
			$cnt=0;

			$sqltext = "SELECT * FROM qitems WHERE quotesid='" .$_GET['id'] . "'";
			$resQitems = $dbsite->query ( $sqltext ) ;#or die ( "Cant get quotes" );

			if (! empty($resQitems)) {

				foreach($resQitems as $resQitem) {

					$itemArray[$cnt]['qitemsid'] = $resQitem->qitemsid;


					if(isset($_POST['item'][$cnt]['content'])){
						$itemArray[$cnt]['content'] =$_POST['item'][$cnt]['content'];
					}else{
						$itemArray[$cnt]['content'] = $resQitem->content;
					}
					if(isset($_POST['item'][$cnt]['quantity'])){
						$itemArray[$cnt]['quantity'] =$_POST['item'][$cnt]['quantity'];
					}else{
						$itemArray[$cnt]['quantity'] = $resQitem->quantity;
					}
					if(isset($_POST['item'][$cnt]['price'])){
						$itemArray[$cnt]['price'] =$_POST['item'][$cnt]['price'];
					}else{
						$itemArray[$cnt]['price'] = $resQitem->price;
					}
					if(isset($_POST['item'][$cnt]['hours'])){
						$itemArray[$cnt]['hours'] =$_POST['item'][$cnt]['hours'];
					}else{
						$itemArray[$cnt]['hours'] = $resQitem->hours;
					}
					if(isset($_POST['item'][$cnt]['rate'])){
						$itemArray[$cnt]['rate'] =$_POST['item'][$cnt]['rate'];
					}else{
						$itemArray[$cnt]['rate'] = $resQitem->rate;
					}


					$cnt++;
					$noOfQitems++;
				}
			}



			for ($i = 0; $i <= 20; $i ++) {
				$blk = 'none';
				if($noOfQitems==0){
					$blk = 'display';
					$noOfQitems++;
				}
				$last='';
				if($i==($noOfQitems-1)){
					$last='y';
				}
				itemBlock($i, $itemArray[$i],  '', $blk,$last);
			}
		}

		$quoteTotal = 0;

		?>
	</fieldset>
	<span id=pagetotal style="font-size: 160%; color: #999;"></span>
	<fieldset class="form-group">
		<?php
		html_button("Save changes");
		?>
	</fieldset>

</form>


<script type="text/javascript">
<!--
window.onload = refreshInvoice;
//-->
</script>

<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
