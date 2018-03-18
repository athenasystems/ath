<?php

// TODO
// This is not finished
//
$section = "Invoices";
$page = "edit";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	$logContent = "\n";

	$required = array("custid");
	$errors = check_required($required, $_POST);

	$items = $_POST['item'];

	if($items[0]['content']==''){
		$errors[] = 'item[0][content]';
	}

	$errors = array_merge($errors, check_items($items));


	if (empty($errors)) {

		# Update DB
		#$invoicesUpdate = new Invoices();

		#$invoicesUpdate->setInvoicesid($_GET['id']);
		#$invoicesUpdate->setInvoiceno($_POST['invoiceno']);
		#$invoicesUpdate->setIncept($_POST['incept']);
		#$invoicesUpdate->setPaid($_POST['paid']);
		#$invoicesUpdate->setContent($_POST['content']);
		#$invoicesUpdate->setNotes($_POST['notes']);

		#$invoicesUpdate->updateDB();

		$itemno = 1;
		foreach ($items as $item) {
			if ($item['content'] != '') {

				$price = $item['price'];
				$quantity =  $item['quantity'];

				if(is_numeric($item['singleprice'])&&($item['singleprice']>0)){
					$price =$item['singleprice'];
					$quantity = 1;
				}

				# Update DB
				$iitemsUpdate = new Iitems();
				$iitemsUpdate->setIitemsid($item['qitemsid']);
				$iitemsUpdate->setInvoicesid($_GET['id']);
				$iitemsUpdate->setQuantity($quantity);
				#$iitemsUpdate->setJobsid($_POST['jobsid']);
				$iitemsUpdate->setContent(addslashes($item['content']));
				$iitemsUpdate->setPrice($price);
				$iitemsUpdate->setHours($item['hours']);
				$iitemsUpdate->setRate($item['rate']);
				$iitemsUpdate->updateDB();
				unset($iitemsUpdate);

				$itemno++;
			}
		}
	#var_dump($items);	exit();
		$logresult = logEvent(4, $logContent);

		header("Location: /invoices/?highlight=" . $result['id']);
		exit();
	}
}

$pagetitle = "Edit Invoice";
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

$sqltextInv = "SELECT jobs.custid,invoiceno FROM invoices,jobs
WHERE  invoices.invoicesid=jobs.invoicesid
AND jobs.invoicesid=" . $_GET['id'];

// print $sqltext;
$qInv = $dbsite->query($sqltextInv); // or die("Cant get invoice");

if (! empty($qInv)) {

	$rInv = $qInv[0];

} else {
	header("Location: /invoices/?NoSuchInvoice");
	exit();
}

?>

<h1>
	<?php echo $pagetitle . ' ' . $rInv->invoiceno; ?>
</h1>

<form
	action="<?php echo $_SERVER['PHP_SELF']?>?go=y&id=<?php echo $_GET['id']?>"
	enctype="multipart/form-data" method="post" id=searchform>

	<?php
	foreach ($errors as $error){
		#echo $error ." ";
	}
	echo form_fail();
	?>
	<fieldset class="form-group">


		<?php
		if (isset($_GET['id'])) {
			$_POST['custid'] = $rInv->custid;
		}
		html_hidden('custid', $rInv->custid);

		?>

	</fieldset>
	<div id=searchresdone>
		<fieldset class="form-group">
			<?php
			if (isset($_GET['id'])) {



				$itemArray = array();
				if(isset($_POST['item'][0])){
					$itemArray = $_POST['item'];
				}else{
					for ($i = 0; $i <= 20; $i ++) {

					}
				}
				$noOfIitems=0;
				if ((isset($_GET['id'])) && ($_GET['id'] >0)) {

					$iItemsIDs = $_POST['iitemsid'];
					$cnt=0;

					$sqltext = "SELECT * FROM iitems WHERE invoicesid='" .$_GET['id'] . "'";
					$resIitems = $dbsite->query ( $sqltext ) ;#or die ( "Cant get quotes" );

					if (! empty($resIitems)) {

						foreach($resIitems as $resIitem) {

							$itemArray[$cnt]['qitemsid'] = $resIitem->iitemsid;

							if(isset($_POST['item'][$cnt]['content'])){
								$itemArray[$cnt]['content'] =$_POST['item'][$cnt]['content'];
							}else{
								$itemArray[$cnt]['content'] = $resIitem->content;
							}
							if(isset($_POST['item'][$cnt]['quantity'])){
								$itemArray[$cnt]['quantity'] =$_POST['item'][$cnt]['quantity'];
							}else{
								$itemArray[$cnt]['quantity'] = $resIitem->quantity;
							}
							if(isset($_POST['item'][$cnt]['price'])){
								$itemArray[$cnt]['price'] =$_POST['item'][$cnt]['price'];
							}else{
								$itemArray[$cnt]['price'] = $resIitem->price;
							}
							if(isset($_POST['item'][$cnt]['hours'])){
								$itemArray[$cnt]['hours'] =$_POST['item'][$cnt]['hours'];
							}else{
								$itemArray[$cnt]['hours'] = $resIitem->hours;
							}
							if(isset($_POST['item'][$cnt]['rate'])){
								$itemArray[$cnt]['rate'] =$_POST['item'][$cnt]['rate'];
							}else{
								$itemArray[$cnt]['rate'] = $resIitem->rate;
							}

							$cnt++;
							$noOfIitems++;
						}
					}

					for ($i = 0; $i <= 20; $i ++) {
						$blk = 'none';
						if($noOfIitems==0){
							$blk = 'display';
							$noOfIitems++;
						}
						$last='';
						if($i==($noOfIitems-1)){
							$last='y';
						}
						itemBlock($i, $itemArray[$i],  '', $blk,$last);
					}
				}
			}
			?>
			<p></p>


		</fieldset>
	</div>

	<span id=pagetotal style="font-size: 160%; color: #999;"></span>

	<fieldset class="form-group">

		<?php
		html_button("Save Changes");
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
