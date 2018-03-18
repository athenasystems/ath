<?php


$section = "Jobs";
$page = "Quotes";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

$quotesid = $_GET['id'] ;

if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){


	$required = array( 'itemcontent');
	$errors = check_required($required, $_POST,1);

	if(empty($errors)){

		$logContent = "\n";

		$itemsNew = new Items();
		$itemsNew->setPrice($_POST['price']);
		$itemsNew->setIncept(time());
		$itemsNew->setContent(addslashes($_POST['itemcontent']));
		$itemsid = $itemsNew->insertIntoDB();

		$logresult = logEvent(1,$logContent);

		if($_POST['addmore']){
			header("Location: /items/add?id=". $quotesid);
		}else{
			header("Location: /quotes/?id=".$quotesid );
		}
		exit();

	}

}

$pagetitle = "Add quote";
$pagescript = array("/pub/calpop/calendar_eu.js");
$pagestyle = array("/css/calendar.css");

include "/srv/ath/pub/mng/tmpl/header.php";


if(!isset($siteMods['quotes'])){
	?>
<h2>This Athena Module has not been activated</h2>
<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
exit;
}


$noOfItems=0;

$sqltext = "SELECT * FROM quotes WHERE quotesid=" . $quotesid;
$res = $dbsite->query($sqltext); # or die("Cant get quotesid");
if (! empty($res)) {
	$r = $res[0];

	$sqltextItems = "SELECT COUNT(itemsid) as cnt FROM qitems WHERE quotesid=" . $quotesid;
	$qItems = $dbsite->query($sqltextItems) or die("Cant get quotesid");
	$rItems = $qItems[0];
	$noOfItems = $rItems->cnt;

}else{
	header("Location: /quotes/?NoSuchQuote");
}


?>

<h2>
	Add a New Item to Quote No:
	<?php echo $r->quoteno; ?>
</h2>


<form
	action="<?php echo $_SERVER['PHP_SELF']?>?go=y&id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">
	<?php echo form_fail(); ?>

	<fieldset class="form-group">


		<?php

		if(($_POST['content'] != '')||($_POST['delivery'] != '')||($_POST['price'] != '')){
			$display='block' ;
		}

		$reqDate = (($_POST['datereq']!='')&&($_POST['datereq']>0)) ? date("d-m-Y", $_POST['datereq']) : '';
		$offDate = (($_POST['dateoff']!='')&&($_POST['dateoff']>0)) ? date("d-m-Y", $_POST['dateoff']) : '';

		html_textarea('Item Description *','itemcontent', $_POST['itemcontent']);

		html_text('Quantity *', 'quantity', $_POST['quantity']);

		#html_text('Delivery Time', 'delivery', $_POST['delivery']);

		html_text('Price &pound;&nbsp;', 'price', $_POST['price'] );

		html_checkbox ('Add More Items after this one?', 'addmore', 1);
		?>


	</fieldset>

	<fieldset class="form-group">
		<?php
		html_button("Save changes");
		?>
	</fieldset>
</form>
<br>
<br>

<h4>
	There
	<?php echo ($noOfItems==1)?'is':'are';?>
	currently
	<?php echo $noOfItems; ?>
	existing Items for this quotes
</h4>
<?php

$sqltext = "SELECT content FROM qitems,items WHERE qitems.itemsid=items.itemsid AND
quotesid=$quotesid ORDER BY qitems.itemsid";

$res = $dbsite->query($sqltext); # or die("Cant get items");

foreach($res as $r) {

	$itemContent = $r->content . "";
	tablerow('Item', $itemContent);
}



?>
<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
