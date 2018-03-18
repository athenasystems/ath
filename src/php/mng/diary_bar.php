<?php

if((isset($_GET['deldiaryitemid']))&&($_GET['action'] == "deldiaryitem")&&($_GET['deldiaryitemid']>0)){
	$now = time();
	$sqltext = "SELECT * FROM diary WHERE diaryid=" . $_GET['deldiaryitemid'];
	$resDiary = $dbsite->query($sqltext); # or die("Cant get diary items");
	$rDiary = $resDiary[0];
	if((isset($rDiary->every))&&($rDiary->every!='')){

		$sqltextIns = "INSERT INTO diary (incept, title, content, location, staffid,done)
		VALUES ({$rDiary->incept},'{$rDiary->title}',{$rDiary->content},{$rDiary->location},{$rDiary->staffid},$now)";
		$res = $dbsite->query($sqltextIns) or die("Cant insert diary items");
	}else{

		$sqltext = "UPDATE diary SET done=$now WHERE diaryid=" . $_GET['deldiaryitemid'];
		$res = $dbsite->query($sqltext); # or die("Cant update diary items");
	}
}
if((isset($staffid))&&($staffid>0)){
	$now = mktime( 0, 0, 0, date("m"), date("d"), date("Y") );
	$sqltext = "SELECT * FROM diary WHERE done IS NULL AND every IS NULL AND staffid=" . $staffid;
	#print $sqltext;
	$resDiary2 = $dbsite->query($sqltext); # or die("Cant get diary items not done");

	foreach($resDiary2 as $rDiary) {
		if(($rDiary->incept>$now)&&($rDiary->incept<($now+(60*60*24)))){
			?>

<div
	style="margin: 1px; border: 1px #000 solid; background-color: #f00; color: #FFF;">
	<form
		action="<?php echo $_SERVER['PHP_SELF']?>?action=deldiaryitem&deldiaryitemid=<?php echo $rDiary->diaryid?>"
		enctype="multipart/form-data" method="post"
		style="font-size: 70%; display: inline;">
		<input type="submit" value="Clear">
	</form>
	Diary Event:
	<?php echo date('l jS \of F Y h:i:s A',$rDiary->incept)?>
	-
	<?php echo stripslashes($rDiary->title) ?>
	-
	<?php echo getStaffName($rDiary->staffid)?>
	-
</div>
<?php
		}
	}
}
