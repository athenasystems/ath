<?php


$section = "diary";
$page = "add";

include "/srv/ath/src/php/staff/common.php";

$errors = array();


if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

	$logContent = "\n";
	$_POST['incept'] = mktime($_POST['incept']['hour'], $_POST['incept']['minute'], 0, $_POST['incept']['month'], $_POST['incept']['day'], $_POST['incept']['year']);

	if(isset($_POST['recevent'])){
		$_POST['end'] = mktime($_POST['end']['hour'], $_POST['end']['minute'], 0, $_POST['end']['month'], $_POST['end']['day'], $_POST['end']['year']);
	}

	$required = array("incept","title","staffid");

	if(isset($_POST['recevent'])){
		$required[]="every";
		$required[]="end";
	}

	$errors = check_required($required, $_POST);

	if(empty($errors)){

		$diaryNew = new Diary();
		$diaryNew->setIncept($_POST['incept']);
		$diaryNew->setDuration($_POST['duration']);
		$diaryNew->setTitle($_POST['title']);
		$diaryNew->setContent($_POST['content']);
		$diaryNew->setLocation($_POST['location']);
		$diaryNew->setStaffid($_POST['staffid']);
		$originid = $diaryNew->insertIntoDB();
		
		
		if(isset($_POST['recevent'])){
			$sqltext = "SELECT diaryid,title,content,incept,done,location,duration,staffid,every,end,origin FROM diary WHERE diaryid=" . $originid;
			$res = $dbsite->query($sqltext); # or die("Cant get diary item");
			$r = $res[0];
			$rows = getRecurringDates($r,$_POST['incept'],$_POST['end']);
			foreach($rows as $row){
				$sqltextIns = "INSERT INTO diary (incept, title, content, location,duration, staffid,origin)
					   		   VALUES ({$row['incept']},'{$row['title']}','{$row['content']}','{$row['location']}','{$row['duration']}',{$row['staffid']},$originid)";
				$res = $dbsite->query($sqltextIns) or die("Cant insert diary items");
			}
		}

		$logresult = logEvent(18,$logContent);

		header("Location: /diary/?highlight=". $result['id']);
		exit();

	}

}

$pagetitle = "Add a Diary Item";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/staff/tmpl/header.php";


?>

<h2>Add a Diary Item</h2>

<form  action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post"><?php echo form_fail(); ?>
<fieldset class="form-group">

<ol>

<?php

if(((isset($_GET['incept'])))&&(is_numeric($_GET['incept']))){
	$_POST['incept']=$_GET['incept'];
}
$value = ((isset($_POST['incept']))&&(is_numeric($_POST['incept']))) ? date("Y-m-d H:i:s", $_POST['incept']) : date("Y-m-d 12:0:0", time());
html_dateselect("Date *", 'incept', $value,"y");

html_text("Title *", "title", $_POST['title']);
if($seclevel<6){
staff_select("For *", "staffid", $staffid);
}else{
	html_hidden("staffid", $staffid);
}
html_textarea("Description", "content", $_POST['content'], "content", "y");

html_text("Duration", "duration", $_POST['duration']);

html_text("Location", "location", $_POST['location']);
?>
</ol>

<ol>
	<li><label for=recevent>Recurring Event?</label><input type="checkbox"
		name="recevent" id="recevent" onclick="showHideRecur('recuroptions')"
		value=1 <?php if(isset($_POST['recevent'])){echo ' checked=checked ';}?>/></li>
</ol>
<?php if(isset($_POST['recevent'])){ ?>
	<ol id=recuroptions>
<?php }else{
	?>
	<ol style="display: none" id=recuroptions>
	<?php
}
?>
<?php

recur_select("Recurs every ...", "every", $_POST['every']);

#html_dateselect("Start Date", 'start', $value,"y");

$value = ((isset($_POST['end']))&&(is_numeric($_POST['end']))) ? date("Y-m-d H:i:s", $_POST['end']) : date("Y-m-d 12:0:0", time());
html_dateselect("End Date", 'end', $value,"y");

?>

</ol>

</fieldset>

<fieldset class="form-group"><input type="submit" name="sendbutt"
	id="sendbutt" value="Save Diary Item"  /></fieldset>
<?php
if ($_GET['id']){
	html_hidden('staffid',$_POST['staffid']);
}else{
	html_hidden("itemsid",'0');
}
?></form>
<br>
<br>




<?php
include "/srv/ath/pub/staff/tmpl/footer.php";
?>
