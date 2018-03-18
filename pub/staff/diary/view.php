<?php

$section = "diary";
$page = "View";

include "/srv/ath/src/php/staff/common.php";

$errors = array();

$pagetitle = "View a Diary Item";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/staff/tmpl/header.php";

$sqltext = "SELECT * FROM diary WHERE diaryid=" . $_GET['id'];

$res = $dbsite->query($sqltext); # or die("Cant get diary item");
if (! empty($res)) {
	$r = $res[0];
}
?>

<h3>View a Diary Item <span><a class="btn btn-primary btn-xs"
	href="/diary/edit.php?id=<?php echo  $_GET['id']; ?>"
	title="Remove this item" class="cancel">Edit Diary Item</a>

<?php
	if(isset($r->origin)){
		?> | <a class="btn btn-primary btn-xs" href="/diary/edit.php?id=<?php echo $r->origin; ?>"
	title="Edit Diary Item">Edit Original </a></span>
		<?php
	}
	?>
</h3>

<?php
$value = date("Y-m-d H:i:s", $r->incept);

tablerow("Date",  $value);

tablerow("Title",  stripslashes($r->title));

tablerow("For",  getStaffName($r->staffid));

tablerow("Description",  stripslashes($r->content));

tablerow("Duration",  $r->duration);

tablerow("Location", $r->location);
if (isset($r->every)){
	if(preg_match("/\w/",$r->every)){

		switch ($r->every) {
			case 'd':
				$rec = "Daily";
				break;
			case 'w':
				$rec = "Weekly";
				break;
			case 'm':
				$rec = "Monthly";
				break;
			case 'q':
				$rec = "Quarterly";
				break;
			case 'y':
				$rec = "Yearly";
				break;
		}
	}


	tablerow("Recurs every",  $rec);

	$value = date("Y-m-d H:i:s", $r->end);
	tablerow("End Date",  $value,"y");
}
?>


<br>
<br>


<?php
include "/srv/ath/pub/staff/tmpl/footer.php";
?>
