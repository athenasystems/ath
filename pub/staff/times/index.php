<?php

$section = "Staff";
$page = "Staff";

include "/srv/ath/src/php/staff/common.php";

$errors = array();

$pagetitle = "staff";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/staff/tmpl/header.php";

if(!isset($siteMods['timesheets'])){
	?>
	<h2>This Athena Module has not been activated</h2>
	<?php
	include "/srv/ath/pub/staff/tmpl/footer.php";
	exit;
	}


if((isset($_GET['from']))&&($_GET['from']!='')){
	$day = $_GET['from'];
}else{
	$lastMonday = strtotime("last Monday");# - (60*60*24*7);
	$day = mktime( 0, 0, 0, date("m",$lastMonday), date("d",$lastMonday), date("Y",$lastMonday) );
}

$lastmon = $day  - (60*60*24*7) ;
$nextmon = $day  + (60*60*24*7) ;
$weekBegin =  date("d-m-Y", $day);
$week =  date("W", $day);

?>

<h2>Staff Timesheets</h2>

<?php
$sqltext = "SELECT * FROM staff WHERE status='active' AND timesheet=1 AND staffid>1000";
$res = $dbsite->query($sqltext); # or die("Cant get staff");
if (! empty($res)) {

	?>
	<h2>Week Start: <?php echo $weekBegin ?></h2>
	<h3><a href="/staff/timesheets.php?id=<?php echo $_GET['id']?>&from=<?php echo $lastmon?>">&lt;--
Last Week</a> | Week Starting: <?php echo $weekBegin?> | <a
	href="/staff/timesheets.php?id=<?php echo $_GET['id']?>&from=<?php echo $nextmon?>">Next Week
--&gt;</a></h3>

<table cellpadding="1" cellspacing="2">
	<tr>
		<td>Date</td>
		<td>Name</td>
		<td>Shift Start</td>
		<td>Lunch</td>
		<td>Shift Finish</td>
	</tr>

	<?php

	foreach($res as $r) {


		$thisday = $day;

		for ($i = 0; $i < 7; $i++) {
			$shift = getStaffTimesheet($r->staffid,$thisday);
			$shdate = date("d-m-Y",$thisday);

			$jobTitle = '';
			if($r->jobtitle!=''){
				$jobTitle = '<span style="font-size:70%"> - ' . $r->jobtitle . '</span>';
			}
			$name = $r->fname . ' ' . $r->sname;

			$shift = getStaffTimesheet($r->staffid,$thisday);

			$shiftHTML .= <<<EOF
	<tr>
		<td>$shdate</td>
		<td>$name</td>
		<td>{$shift['shour']}:{$shift['sminute']}</td>
		<td>{$shift['lshour']}:{$shift['lsminute']} =&gt; {$shift['lfhour']}:{$shift['lfminute']}</td>
		<td>{$shift['fhour']}:{$shift['fminute']}</td>
	</tr>
EOF;

			$thisday = $thisday + (60*60*24);
		}

$shiftHTML .= <<<EOF
	<tr><td colspan=5>----------</td></tr>

EOF;

	}
	?>

	<?php echo $shiftHTML?>

</table>

	<?php
}


include "/srv/ath/pub/staff/tmpl/footer.php";
?>