<?php

$section = "costs";
$page = "edit";

include "/srv/ath/src/php/mng/common.php";
$errors = array();

if(isset($_GET['remove']) && $_GET['remove'] == "y" && isset($_GET['id']) && is_numeric($_GET['id'])){

	$costsDelete = new Costs();
	$costsDelete->setCostsid($_GET['id']);
	$costsDelete->deleteFromDB();

	header("Location: /costs/");
	exit();

};


if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

	$_POST['incept'] = mktime(0, 0, 0, $_POST['incept']['month'], $_POST['incept']['day'], $_POST['incept']['year']);

	$required = array("price","expsid");
	$errors = check_required($required, $_POST);

	if(empty($errors)){

		$logContent = "\n";

		$costsUpdate = new Costs();
		$costsUpdate->setCostsid($_POST['costsid']);
		$costsUpdate->setExpsid($_POST['expsid']);
		$costsUpdate->setDescription($_POST['description']);
		$costsUpdate->setPrice($_POST['price']);
		$costsUpdate->setIncept($_POST['incept']);
		$costsUpdate->setSupplier($_POST['supplier']);
		$costsUpdate->updateDB();

		$logresult = logEvent(26,$logContent);

		header("Location: /costs/?highlight=". $result['id']);
		exit();
	};
};


$pagetitle = "Edit Cost";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";

$sqltext = "SELECT * FROM costs WHERE costsid=" . $_GET['id'];
$res = $dbsite->query($sqltext);
$r = $res[0];

?>


<h1>
	Edit Cost <a class="btn btn-primary btn-xs"
		href="?id=<?php echo $_GET['id']?>&amp;remove=y"
		title="Remove this item" class="cancel"
		onclick="return confirm('Are you sure you want to delete this cost?');">Delete
		Cost</a>

</h1>

<form
	action="<?php echo $_SERVER['PHP_SELF']?>?go=y&id=<?php echo $r->costsid?>"
	enctype="multipart/form-data" method="post">


	<?php echo form_fail(); ?>

	<fieldset class="form-group">

		<?php

		exps_select("Cost Type *","expsid",$r->expsid);

		$value = date("Y-m-d", $r->incept);

		html_dateselect("Date", "incept", $value);

		html_text("Cost *","price", $r->price);
		html_text("From","supplier", $r->supplier);
		html_text("Description","description", $r->description);
		?>
	</fieldset>

	<fieldset class="form-group">
		<?php
		html_hidden('costsid', $_GET['id']);

		html_button("Save changes");


		?>

	</fieldset>

</form>

<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>

