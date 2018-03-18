<?php

$section = "Contacts";
$page = "Staff";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

$pagetitle = "staff";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";

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
$sqltext = "SELECT * FROM staff WHERE status='active'
AND staff.staffid>1000 AND timesheet=1";
$res = $dbsite->query($sqltext); # or die("Cant get staff");
if (! empty($res)) {

	?>
<h2>
	Week Start:
	<?php echo $weekBegin ?>
</h2>
<h3>
	<a
		href="/staff/timesheets.php?id=<?php echo $_GET['id']?>&from=<?php echo $lastmon?>">&lt;--
		Last Week</a> | Week Starting:
	<?php echo $weekBegin?>
	| <a
		href="/staff/timesheets.php?id=<?php echo $_GET['id']?>&from=<?php echo $nextmon?>">Next
		Week --&gt;</a>
</h3>
<style>
td {
	padding: 6px;
}
</style>

<table cellpadding="1" cellspacing="2">
	<tr>
		<td>Date</td>
		<td>Name</td>
		<td>Shift Start</td>
		<td>Lunch</td>
		<td>Shift Finish</td>
		<td>Shift Type</td>
	</tr>

	<?php

	foreach($res as $r) {


		$thisday = $day;

		for ($i = 0; $i < 7; $i++) {
			#	$shift = getStaffTimesheet($r->staffid,$thisday);
			$shdate = date("d-m-Y",$thisday);

			$jobTitle = '';
			if($r->jobtitle!=''){
				$jobTitle = '<span style="font-size:70%"> - ' . $r->jobtitle . '</span>';
			}
			$name = $r->fname . ' ' . $r->sname;

			$this_shift = getStaffTimesheet($r->staffid,$thisday);

			$shiftHTML .= <<<EOF
	<tr>
		<td>$shdate</td>
		<td>$name</td>
EOF;

			if(	($this_shift['shour']!=$this_shift['fhour']) &&	($this_shift['sminute']!=$this_shift['fminute']) ){

				$shiftHTML .= <<<EOF
		<td>{$this_shift['shour']}:{$this_shift['sminute']}</td>
		<td>{$this_shift['lshour']}:{$this_shift['lsminute']} =&gt; {$this_shift['lfhour']}:{$this_shift['lfminute']}</td>
		<td>{$this_shift['fhour']}:{$this_shift['fminute']}</td>
		<td>{$this_shift['type_name']}</td>
EOF;

			}else{
				$shiftHTML .= <<<EOF
	<td colspan=4><span id=faint>No times recorded</span></td>

EOF;
			}

			$shiftHTML .= <<<EOF
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


include "/srv/ath/pub/mng/tmpl/footer.php";
?>