<?php

	$page = "Quotes";

	include "/srv/ath/src/php/supp/common.php";


	$_POST['suppid'] = $suppID;
	$errors = array();

	$done = "";

#	print $_POST['item'][0][content];

	if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

		$required = array( "content", "custid" );
		$errors = check_required($required, $_POST);

		if(empty($errors)){

			$logContent = "\n";


        $quoteno = getNextQuoteNo();
        $quotesNew = new Quotes();
        $quotesNew->setStaffid($_POST['staffid']);
        $quotesNew->setCustid($_POST['custid']);
        $quotesNew->setContactsid($_POST['contactsid']);
        $quotesNew->setQuoteno($quoteno);
        $quotesNew->setIncept(time());
        $quotesid = $quotesNew->insertIntoDB();

//         $itemsNew = new Items();
//         $itemsNew->setPrice($_POST['price']);
//         $itemsNew->setIncept(time());
//         $itemsNew->setContent(addslashes($_POST['itemcontent']));
//         $itemsid = $itemsNew->insertIntoDB();

        $qitemsNew = new Qitems();
        $qitemsNew->setQuotesid($quotesid);
        $qitemsNew->setQuantity($_POST['quantity']);
        $qitemsNew->setItemno(getNoOfItemsInQuote($quotesid) + 1);
        $ret = $qitemsNew->insertIntoDB();


			$logresult = logEvent(1,$logContent);
//
			header("Location: /quotes/?highlight=". $result['id']);
			exit();

		}

	}

	$pagetitle = "Add quote";
	$pagescript = array();
	$pagestyle = array();

	include "/srv/ath/pub/supp/tmpl/header.php";

if(!isset($siteMods['orders'])){
	?>
<h2>This Athena Module has not been activated</h2>
<?php
include "/srv/ath/pub/supp/tmpl/footer.php";
exit;
}




	$nextQuoteNo = getNextQuoteNo();
?>

<h1>
	Request a New Quote from <?php echo $owner->co_name; ?>
</h1>
<p>&nbsp;</p>
<form  action="<?php echo $_SERVER['PHP_SELF']?>?go=y" enctype="multipart/form-data" method="post">

	<?php echo form_fail(); ?>

	<fieldset class="form-group">

		<ol  style="white-space:nowrap;">
		<?
		#if((!isset($_POST['content']))||($_POST['content'] == '')){$_POST['content']='To Manufacture:-';}

			$value = date("Y-m-d", time());
			$nowDay = date("d", time());
			$nowMonth = date("m", time());
			$nowYear = date("Y", time());

		#	html_dateselect ("Date", "incept", $value);
		#	customer_select("Customer", "custid", $_POST['custid'],0,1);

			suppliercontact_select("Your Name", "contactsid", $_POST['contactsid'],$suppID);

			staff_select($owner->co_nick." Contact", "staffid", $_POST['staffid']);

			html_textarea("Job Description *", "content", $_POST['content'], "body", "y");

			$itemArray = $_POST['item'];

			if ($itemArray[0]['datereq']['year']<$nowYear){
				$itemArray[0]['datereq']['day']=$nowDay;
				$itemArray[0]['datereq']['month']=$nowMonth;
				$itemArray[0]['datereq']['year']=$nowYear;
			}

			itemBlock('0', $itemArray[0],  '', $blk,$last);

			for($i=1; $i<=20; $i++){
			$itemcontent = 'item' . $i . 'content';
			$itemdelivery = 'item' . $i . 'delivery';
			$itemprice = 'item' . $i . 'price';
				itemBlock($i, $itemArray[$i],  '', $blk,$last);
			}

			#html_file ("Attach a file to this Quote", 'quotefile', '', "");
			#html_text("External Contact", "ext_contact", $_POST['ext_contact']);
			#html_textarea("Internal Notes<br>(not seen by Customer)", "notes", $_POST['notes'], "notes", "y");

		?>
		</ol>


	</fieldset>

<fieldset class="form-group">

	<?php
		html_button("Submit Quote Request");

		html_hidden("custid",$custID);
	?>

	</fieldset>
</form>
<br>
<br>


<?php
	include "/srv/ath/pub/supp/tmpl/footer.php";
?>
