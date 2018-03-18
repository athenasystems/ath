<?php
$section = "Jobs";
$page = "add";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	$logContent = "\n";

	$_POST['incept'] = mktime(0, 0, 0, $_POST['incept']['month'], $_POST['incept']['day'], $_POST['incept']['year']);
	$_POST['done'] = 0;

	$required = array(
			"itemcontent","price","custid"
	);
	$errors = check_required($required, $_POST);

	if (empty($errors)) {

		$itemsid = 0;

		$itemsNew = new Items();
		$itemsNew->setPrice($_POST['price']);
		$itemsNew->setIncept(time());
		if(isset($_POST['qitemsid'])){
			$itemsNew->setQitemsid($_POST['qitemsid']);
		}
		$itemsNew->setContent(addslashes($_POST['itemcontent']));
		$itemsid = $itemsNew->insertIntoDB();



		$jobno = getNextJobNo();

		$jobsNew = new Jobs();
		$jobsNew->setCustid($_POST['custid']);
		$jobsNew->setItemsid($itemsid);
		$jobsNew->setQuantity($_POST['quantity']);
		$jobsNew->setInvoicesid($_POST['invoicesid']);
		$jobsNew->setCustref($_POST['custref']);
		$jobsNew->setJobno($jobno);
		$jobsNew->setIncept(time());
		$jobsid = $jobsNew->insertIntoDB();

		// Make the Data Folder
		mkDataDir($jobno);

		$logresult = logEvent(3, $logContent);

		header("Location: /jobs/?id=" . $r->jobitemsid);

		exit();
	}
}

$pagetitle = "Add A Job";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";
include "helptab.php";

if ($_GET['id']) {
	$sqltext = "SELECT quotes.custid,qitems.content,qitems.price,
	quotes.contactsid,quotes.quoteno,qitems.quantity,
	cust.co_name
	FROM qitems,quotes,cust WHERE qitemsid='" . $_GET['id'] . "'
	AND qitems.quotesid=quotes.quotesid
	AND quotes.custid=cust.custid
	";
	// print $sqltext;

	$res = $dbsite->query($sqltext); # or die("Cant get job item");
	$r = $res[0];

	$_POST['custid'] = $r->custid;
	$_POST['itemcontent'] = stripslashes($r->content);
	$_POST['staffid'] = $r->staffid;
	$_POST['contactsid'] = $r->contactsid;
	$_POST['quoteno'] = $r->quoteno;
	$_POST['co_name'] = $r->co_name;
	$_POST['quantity'] = $r->quantity;
	$_POST['price'] = stripslashes($r->price);
	$_POST['notes'] = stripslashes($r->notes);
}
if (($_GET['custid'])&&($_GET['custid'])) {

	$_POST['custid'] = $_GET['custid'];

}
if (! empty($errors)) {
	$_POST['incept'] = mktime(0, 0, 0, $_POST['incept']['month'], $_POST['incept']['day'], $_POST['incept']['year']);
}

$co_name = $r->co_name;
$itemcontent = $r->content;

?>

<h2>Add Job</h2>
<?php

if ((! $_GET['custid'])&&(!isset($_GET['id']))) {
	?>
<a href="/customers/add?backto=jobs" title="Add a new contact"
	id="newcust">Add a Job for a New Customer</a>
<br>
<br>

<?php
}
?>
<form
	action="<?php echo $_SERVER['PHP_SELF']?>?go=y&id=<?php echo $_GET['id'] ; ?>"
	enctype="multipart/form-data" method="post">
	<?php echo form_fail(); ?>

	<fieldset class="form-group">


		<?php

		if(!isset($_GET ['id'])){
			customer_select("Customer *", "custid", $_POST['custid'], 0, 1);
			if (! isset($_POST['quantity'])) {
				$_POST['quantity'] = 1;
			}
			html_text('Quantity *', 'quantity', $_POST['quantity']);
		}
		html_textarea('Description *', 'itemcontent', $_POST['itemcontent']);

		html_text("Price", "price", $_POST['price']);



		html_text("Customer Reference (optional)", "custref", $_POST['custref']);

		$value = date("Y-m-d", time());
		html_dateselect("Date Started", "incept", $value);

		?>


	</fieldset>

	<fieldset class="form-group">
		<?php
		html_button("Add Job");
		?>

	</fieldset>
	<?php
	if ($_GET['id']) {
		html_hidden("custid", $_POST['custid']);
		html_hidden("qitemsid", $_GET['id']);
		html_hidden("done[day]", '0');
		html_hidden("done[month]", '0');
		html_hidden("done[year]", '0');
		html_hidden('staffid', $staffid);
	} else {
		html_hidden("itemsid", '0');
	}
	?>
</form>
<br>
<br>



<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
