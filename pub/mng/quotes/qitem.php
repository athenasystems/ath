<?php


$section = "Items";
$page = "Quotes";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

$qitemsid = $_GET['id'] ;

$sqltext = "SELECT * FROM qitems WHERE qitemsid=" . $qitemsid;
// $sqltext = "SELECT * FROM items,qitems WHERE qitems.itemsid=items.itemsid AND
//  items.itemsid=" . $qitemsid;
$res = $dbsite->query($sqltext); # or die("Cant get item");
if (! empty($res)) {
	$r = $res[0];
}else{
	header("Location: /quotes/?NoSuchItem");
}

if(isset($_GET['remove']) && $_GET['remove'] == "y" && isset($_GET['id']) && is_numeric($_GET['id'])){

	$qitemsDelete = new Qitems();
	$qitemsDelete->setQitemsid($_GET['id']);
	$qitemsDelete->deleteFromDB();


	header("Location: /");
	exit();

}

if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){


	$required = array( 'itemcontent', "price");
	$errors = check_required($required, $_POST,1);

	if(empty($errors)){
		#
		$logContent = "\n";

		$qitemsUpdate = new Qitems();
		$qitemsUpdate->setQitemsid($_POST['qitemsid']);
		$qitemsUpdate->setContent($_POST['itemcontent']);
		$qitemsUpdate->setPrice($_POST['price']);
		$qitemsUpdate->updateDB();


		$logresult = logEvent(1,$logContent);


		header("Location: /quotes/view?id=". $r->quotesid);

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

		html_text('Price &pound;&nbsp;', 'price', $r->price );

		?>

	</fieldset>

	<fieldset class="form-group">
		<?php
		html_button("Save changes");

		html_hidden('qitemsid', $qitemsid);

		?>
	</fieldset>
</form>
<br>
<br>

<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
