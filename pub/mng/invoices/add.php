<?php
$section = "Invoices";
$page = "add";

include "/srv/ath/src/php/mng/common.php";

$errors = array();


if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	$logContent = "\n";

	$jobsids = array();
	if(isset($_POST['jobsid'])){
		$jobsids = $_POST['jobsid'];
	}
	$required = array("custid");

	$errors = check_required($required, $_POST);

	$items = $_POST['item'];

	if($items[0]['content']==''){
		$errors[]='content';
	}

	$errors = array_merge($errors, check_items($items));

	if (empty($errors)) {

		// Add Invoice
		$invoicesNew = new Invoices();
		$invoicesNew->setInvoiceno(getNextInvoiceNo());
		$invoicesNew->setCustid($_POST['custid']);
		$invoicesNew->setIncept(time());
		$invoicesid = $invoicesNew->insertIntoDB();

		foreach ($items as $item) {
			if ($item['content'] != '') {

				$price = $item['price'];
				$quantity =  $item['quantity'];

				if(is_numeric($item['singleprice'])&&($item['singleprice']>0)){
					$price =$item['singleprice'];
					$quantity = 1;
				}

				if ((isset($item['hours']))&&($item['hours']>0)) {
					$tasksNew = new Tasks();
					$tasksNew->setCustid($_POST['custid']);
					$tasksNew->setIncept(time());
					$tasksNew->setStaffid($staffid);
					$tasksNew->setHours($item['hours']);
					$tasksNew->setRate($item['rate']);
					#$tasksNew->setJobsid($jobsid);
					$tasksNew->insertIntoDB();
					unset($tasksNew);

				}else{
					// Add Item
					$itemsNew = new Items();
					$itemsNew->setPrice($price);
					$itemsNew->setIncept(time());
					$itemsNew->setContent($item['content']);
					$itemsid = $itemsNew->insertIntoDB();
					unset($itemsNew);

					// Add Job
					$jobsNew = new Jobs();
					$jobsNew->setCustid($_POST['custid']);
					$jobsNew->setInvoicesid($invoicesid);
					$jobsNew->setItemsid($itemsid);
					$jobsNew->setQuantity($quantity);
					$jobsNew->setJobno(getNextJobNo());
					$jobsNew->setIncept(time());
					$jobsid = $jobsNew->insertIntoDB();
					unset($jobsNew);

				}

				# Insert into DB
				$iitemsNew = new Iitems();
				$iitemsNew->setInvoicesid($invoicesid);
				$iitemsNew->setJobsid($jobsid);
				$iitemsNew->setQuantity($quantity);
				$iitemsNew->setContent($item['content']);
				$iitemsNew->setPrice($price);
				$iitemsNew->setHours($item['hours']);
				$iitemsNew->setRate($item['rate']);
				$iitemsNew->insertIntoDB();
				unset($iitemsNew);

			}
		}


		$logContent = "Customer: $custid | Job: " . $inputJob['jobno'] . " | Invoice: " . $inputInvoice['invoiceno'];
		$logresult = logEvent(4, $logContent);

		header("Location: /invoices/?highlight=" . $invoicesid);
		exit();

	}
}
$pagetitle = "Create An Invoice";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";

include "helptab.php";

if (! isset($siteMods['invoices'])) {
	?>
<h2>This Athena Module has not been activated</h2>
<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
exit();
}
?>
<h1>
	<?php echo $pagetitle; ?>
</h1>

<br>
<form
	action="<?php echo $_SERVER['PHP_SELF']?>?go=y&id=<?php echo $_GET['id']?>&d=<?php echo $_GET['d'];?>"
	enctype="multipart/form-data" method="post" id=searchform
	class="form-horizontal">

	<?php
	foreach ($errors as $error){
		#echo $error ." ";
	}
	 echo form_fail(); ?>
	<fieldset class="form-group">

		<?php
		#$itemArray = array();

		$itemArray = $_POST['item'];

		if(isset($_POST['item'][0])){

		}else{
			for ($i = 0; $i <= 20; $i ++) {

			}
		}

		$noOfQitems=0;
		if ((isset($_GET['qid'])) && ($_GET['qid'] >0)) {

			$qItemsIDs = $_POST['qitemsid'];
			$cnt=0;
			foreach ($qItemsIDs as $qItemsID){

				$sqltext = "SELECT * FROM qitems WHERE qitemsid='" .$qItemsID . "'";
				$resQitems = $dbsite->query ( $sqltext ) ;#or die ( "Cant get quotes" );

				if (! empty($resQitems)) {

					foreach($resQitems as $resQitem) {

						$itemArray[$cnt]['content'] = $resQitem->content;
						$itemArray[$cnt]['quantity'] = $resQitem->quantity;
						$itemArray[$cnt]['price'] = $resQitem->price;
						$itemArray[$cnt]['hours'] = $resQitem->hours;
						$itemArray[$cnt]['rate'] = $resQitem->rate;
					}
				}
				$cnt++;$noOfQitems++;
			}
		}

		if (!isset($_GET['id'])) {
			?>
		<div>
			<a href="/customers/add?backto=invoices" title="Add a new contact"
				id=newcust>Invoice New Customer</a>
		</div>
		<br>
		<?php
		}

		customer_invoice_select("Select Customer *", "custid", $_GET['id'], 0, 1);

		$extraJobsHTML = '';
		if ((isset($_GET['id']))&&($_GET['id']>0)) {
			$extraJobsHTML = getInvoiceableJobs($_GET['id'], $_POST);
			print $extraJobsHTML;
		}
		if ($extraJobsHTML != '') {
			?>
		<h4>Add a new Job to this Invoice</h4>
		<?php
		}
		if ((isset($_GET['id']))&&($_GET['id']>0)) {

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
				if($_GET['d']==1){
					$blk = 'display';
				}
				if($_GET['d']==1){
					$blk = 'dev';
				}

				itemBlock($i, $itemArray[$i],  '', $blk,$last);
			}

		}
		?>

	</fieldset>
	<span id=pagetotal style="font-size: 160%; color: #999;"></span>
	<fieldset class="form-group">

		<?php

		if (isset($_GET['id'])) {
			html_hidden('custid', $_GET['id']);
		}
		if ((isset($_GET['id']))&&($_GET['id']>0)) {
			html_button("Add Invoice");
		}
		?>

	</fieldset>

</form>
<br>
<br>
<script type="text/javascript">
<!--
window.onload = refreshInvoice;
//-->
</script>
<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
