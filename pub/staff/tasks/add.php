<?php
$section = "tasks";
$page = "Tasks";

include "/srv/ath/src/php/staff/common.php";

$errors = array();

if ($_GET['go'] == "y") {

	$required = array(
			"hours"
	);
	$errors = check_required($required, $_POST);

	if (empty($errors)) {

		$logContent = "\n";

		$tasksNew = new Tasks();
		$tasksNew->setCustid($_POST['custid']);
		$tasksNew->setIncept(time());
		$tasksNew->setStaffid($staffid);
		$tasksNew->setNotes(addslashes($_POST['notes']));
		$tasksNew->setHours($_POST['hours']);
		$tasksNew->setJobsid($_POST['jobsid']);
		$tasksNew->insertIntoDB();

		// $logresult = logEvent(1,$logContent);

		header("Location: /tasks/?NewTasks=" . $result['id']);
		exit();
	}
}

$pagetitle = "Staff Times";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/staff/tmpl/header.php";

include "helptab.php";
// print $logContent;

if (! isset($siteMods['tasks'])) {
	?>
<h2>This Athena Module has not been activated</h2>
<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
exit();
}

?>

<h1>
	Tasks <span> </span>
</h1>

<form action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">

	<?php
	form_fail();
	?>

	<fieldset class="form-group">

		<ol>

			<?php
			if(!isset($_POST['custid'])){
				$_POST['custid']=$_GET['cid'];
			}

			customer_select("For Customer", "custid", $_POST['custid'], 2, 0);

			job_select('Job No', 'jobsid', $_POST['custid'], '');

			html_textarea("Description", "notes", $_POST['notes'], "body", "y");

			html_text("Time in Hours *", "hours", $_POST['hours'], "", "", 'print', 1, "60");

			// html_text("Hourly Rate in &pound;s", "rate", $_POST['rate'],"", "", 'print', 1, "60");

			?>

		</ol>

	</fieldset>

	<fieldset class="form-group">

		<?php
		html_button("Save changes");

		?>

	</fieldset>

</form>



<?php
include "/srv/ath/pub/staff/tmpl/footer.php";
?>
