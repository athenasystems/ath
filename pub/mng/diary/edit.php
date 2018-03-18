<?php


$section = "diary";
$page = "Edit";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

if(isset($_GET['remove']) && $_GET['remove'] == "y" && isset($_GET['id']) && is_numeric($_GET['id'])){

    $diaryDelete = new Diary();
    $diaryDelete->setDiaryid($_GET['id']);
    $diaryDelete->deleteFromDB();
    
	$sqltext = "DELETE FROM diary WHERE origin=" . $_GET['id'];
	$res = $dbsite->query($sqltext); # or die("Cant delete diary items");

	header("Location: /diary/");
	exit();

}


if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

	$logContent = "\n";
	$_POST['incept'] = mktime($_POST['incept']['hour'], $_POST['incept']['minute'], 0, $_POST['incept']['month'], $_POST['incept']['day'], $_POST['incept']['year']);
	if(isset($_POST['every'])){
		#$_POST['start'] = mktime($_POST['start']['hour'], $_POST['start']['minute'], 0, $_POST['start']['month'], $_POST['start']['day'], $_POST['start']['year']);
		$_POST['end'] = mktime($_POST['end']['hour'], $_POST['end']['minute'], 0, $_POST['end']['month'], $_POST['end']['day'], $_POST['end']['year']);
	}
	
	
	
	$required = array("incept","title","staffid");
	
	
	if(isset($_POST['every'])){
		$required[]="every";
		$required[]="end";
	}
	$errors = check_required($required, $_POST);

	if(empty($errors)){

		$fields = array_merge($required, array( "location","content","duration"));
		
		$diaryUpdate->setDiaryid($_POST['diaryid']);
		$diaryUpdate->setIncept($_POST['incept']);
		$diaryUpdate->setDuration($_POST['duration']);
		$diaryUpdate->setTitle($_POST['title']);
		$diaryUpdate->setContent($_POST['content']);
		$diaryUpdate->setLocation($_POST['location']);
		$diaryUpdate->setStaffid($_POST['staffid']);
		$diaryUpdate->setEvery($_POST['every']);
		$diaryUpdate->setEnd($_POST['end']);		
		$diaryUpdate->updateDB();
				
		$logresult = logEvent(18,$logContent);

		header("Location: /diary/?highlight=". $result['id']);
		exit();

	}

}

$pagetitle = "Edit a Diary Item";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";


if(!isset($siteMods['diary'])){
	?>
	<h2>This Athena Module has not been activated</h2>
	<?php
	include "/srv/ath/pub/mng/tmpl/footer.php";
	exit;
	}


$sqltext = "SELECT diaryid,diary.duration,diary.title,diary.content,diary.incept,diary.done,diary.location,diary.staffid,diary.every,diary.end,fname,sname
			FROM diary,staff
			WHERE diary.staffid = staff.staffid
			AND diaryid=" . $_GET['id'];

$res = $dbsite->query($sqltext); # or die("Cant get diary item");
if (! empty($res)) {
	$r = $res[0];
}
?>

<h1>Edit a Diary Item <span><a href="javascript:void(0);"
	title="Remove this item" class="cancel" onclick="confirmation()">Delete
Diary Item</a></span></h1>
<script type="text/javascript">
<!--
function confirmation() {
	var answer = confirm("Sure you want to delete this Item?");
	if (answer){
		window.location = "/diary/edit.php?id=<?php #echo $_GET['id']?>&remove=y";
	}

}
//-->
</script>
<form
	action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $_GET['id']?>&go=y"
	enctype="multipart/form-data" method="post"><?php echo form_fail(); ?>
<fieldset class="form-group">

<ol>

<?php
$value = date("Y-m-d H:i:s", $r->incept);
html_dateselect("Date *", 'incept', $value,"y");

html_text("Title *", "title", $r->title);

staff_select("For *", "staffid", $r->staffid);

html_textarea("Description *", "content", $r->content, "content", "y");

html_text("Duration", "duration", $r->duration);

html_text("Location", "location", $r->location);

if (isset($r->every)){

	recur_select("Recurs every ...", "every", $r->every);

	$value = date("Y-m-d H:i:s", $r->end);
	html_dateselect("End Date *", 'end', $value,"y");
}
?>

</ol>

</fieldset>

<fieldset class="form-group"><input type="submit" name="sendbutt"
	id="sendbutt" value="Save Diary Item"  /></fieldset>

</form>
<br>
<br>




<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
