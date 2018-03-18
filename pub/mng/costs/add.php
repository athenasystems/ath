<?php
$section = "costs";
$page = "add";

include "/srv/ath/src/php/mng/common.php";
$errors = array();

if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

	$_POST['incept'] = mktime(0, 0, 0, $_POST['incept']['month'], $_POST['incept']['day'], $_POST['incept']['year']);

	$required = array("price","expsid");
	$errors = check_required($required, $_POST);

	if(empty($errors)){

		$logContent = "\n";

		if(($_POST['supplier']!='')&&(

				isset($_POST['addsupp']) && ($_POST['addsupp']==1)

				)){
		$_POST['co_name']=$_POST['supplier'];
		$_POST['email']='';
		$suppid = addSupplier($_POST);
		}
		$costsNew = new Costs();
		$costsNew->setExpsid($_POST['expsid']);
		$costsNew->setDescription(addslashes($_POST['description']));
		$costsNew->setPrice($_POST['price']);
		$costsNew->setIncept($_POST['incept']);
		$costsNew->setSupplier($_POST['supplier']);
		$costsNew->insertIntoDB();

		$logresult = logEvent(26,$logContent);

		header("Location: /costs/?highlight=". $result['id']);
		exit();

	};

};

$pagetitle = "Add Cost";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";
?>

<h2>Add Cost Information</h2>

<form
	action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post"><?php echo form_fail(); ?>

<fieldset class="form-group">
<?php

exps_select("Cost Type *","expsid",$_POST['expsid']);

html_text("Amount * &pound;","price", $_POST['price']);

html_text("Description","description", $_POST['description']);

html_text("Supplied by","supplier", $_POST['supplier']);

html_checkbox('Add this contact to your Suppliers List?', 'addsupp', 1);

if(!isset($_POST['incept'])){$_POST['incept']=time();}
$value = date("Y-m-d", $_POST['incept']);
html_dateselect("Date", "incept", $value);



?>
</fieldset>

<fieldset class="form-group">

<?php
html_button("Save changes");
?>

</fieldset>

</form>


<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>

