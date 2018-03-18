<?php
$section = "Jobs";
$page = "edit";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

if (isset($_GET['remove']) && $_GET['remove'] == "y" && isset($_GET['id']) && is_numeric($_GET['id'])) {

	$jobsDelete = new Jobs();
	$jobsDelete->setJobsid($_GET['id']);
	$jobsDelete->deleteFromDB();

	header("Location: /jobs/");
	exit();
}

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	$required = array(
			"incept"
	);
	$errors = check_required($required, $_POST);

	if (empty($errors)) {

		$_POST['incept'] = mktime(0, 0, 0, $_POST['incept']['month'], $_POST['incept']['day'], $_POST['incept']['year']);
		$_POST['done'] = mktime(0, 0, 0, $_POST['done']['month'], $_POST['done']['day'], $_POST['done']['year']);

		$jobsUpdate = new Jobs();
		$jobsUpdate->setJobsid($_GET['id']);
		$jobsUpdate->setIncept($_POST['incept']);
		$jobsUpdate->setDone($_POST['done']);
		$jobsUpdate->setCustref($_POST['custref']);
		$jobsUpdate->updateDB();

		header("Location: /jobs/?highlight=" . $result['id']);
		exit();
	}
}

$pagetitle = "Edit Job";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";

include "helptab.php";

if (! isset($siteMods['jobs'])) {
	?>
<h2>This Athena Module has not been activated</h2>
<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
exit();
}

$sqltext = "SELECT jobs.incept,jobs.itemsid,jobs.jobno,jobs.jobsid,
jobs.done,jobs.custref
FROM jobs
WHERE jobs.jobsid='" . addslashes($_GET['id']) . "'";
$res = $dbsite->query($sqltext); # or die("Cant get jobs");
$r = $res[0];
$itemsid = $r->itemsid;
?>
<script type="text/javascript">
<!--
function confirmation() {
	var answer = confirm("Sure you want to delete this Job?");
	if (answer){
		window.location = "/jobs/edit.php?id=<?php echo $_GET['id']?>&remove=y";
	}
}
//-->
</script>


<div style="float: right;">
	<a href="javascript:void(0);" title="Remove this item"
		onclick="confirmation()" class="btn btn-primary">Delete Job</a>
</div>



<h2>Edit a Job</h2>

<form
	action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $_GET['id']?>&amp;go=y"
	enctype="multipart/form-data" method="post">
	<?php

	echo form_fail();
	html_hidden("jobno", $r->jobno);
	?>
	<h2>
		Job No:
		<?php echo $r->jobno?>
	</h2>


	<fieldset class="form-group">

		<?php

		html_text("Customer Reference", "custref", $r->custref);

		$value = date("Y-m-d", $r->incept);
		html_dateselect("Date Started", "incept", $value);

		// $value = date("Y-m-d", $r->done);
		// html_dateselect ("Date Completed", "done", $value);

		?>

		<a href="/items/edit?id=<?php echo $itemsid; ?>">Edit Job Item</a>

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
