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

        $tasksUpdate = new Tasks();
        $tasksUpdate->setTasksid($_POST['tasksid']);
        $tasksUpdate->setCustid($_POST['custid']);
        $tasksUpdate->setNotes($_POST['notes']);
        $tasksUpdate->setHours($_POST['hours']);
        $tasksUpdate->setJobsid($_POST['jobsid']);
        $tasksUpdate->updateDB();

        // $logresult = logEvent(1,$logContent);

        header("Location: /tasks/?highlight=" . $result['id']);
        exit();
    }
}
$pagetitle = "Staff Times";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/staff/tmpl/header.php";

include "helptab.php";
// print $logContent;

$sqltext = "SELECT * from tasks WHERE tasksid=" . $_GET['id'];
// print "<br/>$sqltext";

$res = $dbsite->query($sqltext); // or die("Cant get tasks!");

if (! empty($res)) {
    $r = $res[0];
} else {

    header("Location: /tasks/?NoTaskOfThatNameHere");
    exit();
}

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

<form
	action="<?php echo $_SERVER['PHP_SELF']?>?go=y&id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">

	<?php
form_fail();
?>

	<fieldset class="form-group">

		<ol>

			<?php

// staff_select("Staff Name","staffid",$r->staffid);

customer_select("Customer", "custid", $r->custid, 0, 1);

job_select('Job No', 'jobsid', $r->custid, $r->jobsid);

html_textarea("Description *", "notes", $r->notes, "body", "y");

html_text("Time in Hours", "hours", $r->hours, "", "", 'print', 1, "60");

// html_text("Hourly Rate in &pound;s", "rate", $r->rate,"", "", 'print', 1, "60");

?>

		</ol>

	</fieldset>

	<fieldset class="form-group">

		<?php
html_button("Save changes");
html_hidden('tasksid', $_GET['id']);

?>

	</fieldset>

</form>



<?php
include "/srv/ath/pub/staff/tmpl/footer.php";
?>
