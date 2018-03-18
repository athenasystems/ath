<?php


$section = "Items";
$page = "Items";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

$itemsid = $_GET['id'] ;

$sqltext = "SELECT * FROM items WHERE items.itemsid=" . $itemsid;
// $sqltext = "SELECT * FROM items,qitems WHERE qitems.itemsid=items.itemsid AND
//  items.itemsid=" . $itemsid;
$res = $dbsite->query($sqltext); # or die("Cant get item");
if (! empty($res)) {
	$r = $res[0];
}else{
	header("Location: /quotes/?NoSuchItem");
}

if(isset($_GET['remove']) && $_GET['remove'] == "y" && isset($_GET['id']) && is_numeric($_GET['id'])){

	$itemsDelete = new Items();
	$itemsDelete->setItemsid($_GET['id']);
	$itemsDelete->deleteFromDB();

	header("Location: /");
	exit();

}

if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){


	$required = array( 'itemcontent', "price");
	$errors = check_required($required, $_POST,1);

	if(empty($errors)){
		#
		$logContent = "\n";

		$itemsUpdate = new Items();
		$itemsUpdate->setItemsid($_POST['itemsid']);
		$itemsUpdate->setPrice($_POST['price']);
		$itemsUpdate->setContent($_POST['itemcontent']);
		$itemsUpdate->updateDB();

		$logresult = logEvent(1,$logContent);

		header("Location: /jobs");

		exit();
	}
}

$pagetitle = "Edit Item";
$pagescript = array("/pub/calpop/calendar_eu.js");
$pagestyle = array("/css/calendar.css");

include "/srv/ath/pub/mng/tmpl/header.php";

$noOfItems=0;

?>
<script type="text/javascript">
<!--
function confirmation() {
	var answer = confirm("Sure you want to delete this Item?");
	if (answer){
		window.location = "/items/edit?id=<?php #echo $_GET['id']?>&remove=y";
	}
}
//-->
</script>
<a href="javascript:void(0);" title="Remove this item" class="cancel"
	onclick="confirmation();">Delete this Item</a>
<h2>Edit Item</h2>

<form
	action="<?php echo $_SERVER['PHP_SELF']?>?go=y&id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">
	<?php echo form_fail(); ?>

	<fieldset class="form-group">

		<?php

		html_textarea('Item Description','itemcontent', $r->content);

		#html_text('Quantity', 'quantity', $r->quantity);

		#html_text('Delivery Time', 'delivery', $r->delivery);

		html_text('Price &pound;&nbsp;', 'price', $r->price );

		?>

	</fieldset>

	<fieldset class="form-group">
		<?php
		html_button("Save changes");

		html_hidden('itemsid', $itemsid);

		?>
	</fieldset>
</form>
<br>
<br>

<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
