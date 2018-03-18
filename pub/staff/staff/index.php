<?php

$section = "Staff";
$page = "Staff";

include "/srv/ath/src/php/staff/common.php";

$errors = array();

$pagetitle = "staff";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/staff/tmpl/header.php";
?>

<h1>
	Staff
	<?php
	if($staffid<4){
		?>
	<span> <a href="/staff/hols.php" title="Holidays at a glance">Holidays</a>
		| <a href="/staff/timesheets.php"
		title="A Week's Timesheets at a glance">Timesheets</a>
	</span>
	<?php
	}
	?>
</h1>

<?php
$sqltext = "SELECT * FROM staff WHERE status='active' AND staffid>1000";
$res = $dbsite->query($sqltext); # or die("Cant get staff");
if (! empty($res)) {
	?>
<ul class="list">

	<?php
	foreach($res as $r) {

		if($r->fname=='System'){
			continue;
		}
		$jobTitle = '';
		if($r->jobtitle!=''){
			$jobTitle = '<span style="font-size:70%"> - ' . $r->jobtitle . '</span>';
		}
		if((($staffid<3)&&($r->staffid!=$staffid))||($r->staffid==$staffid)){
			$holHTML = getHolidayData($r->staffid);
			?>

	<li>
		<div>
			<div style="float: left; width: 400px;">
				<?php echo htmlentities($r->fname)?>
				<?php echo $r->sname?>
				<?php echo $jobTitle?>
			</div>
			<div id=actions>

				<a href="/staff/login.php?id=<?php echo $r->staffid?>"
					title="Log in Details">Log in Details</a> | <a
					href="/staff/edit.php?id=<?php echo $r->staffid?>"
					title="Edit this person's details">Edit Details</a> | <a
					href="/staff/times_add.php?id=<?php echo $r->staffid?>"
					title="Fill in Timesheets">Do Timesheet</a>
			</div>

			<br clear=all /> <span style="font-size: 80%;"><?php echo $holHTML?>
			</span>
		</div>
	</li>
	<?php
		}
		?>
	<?php
	}
	?>

</ul>

<?php
}


include "/srv/ath/pub/staff/tmpl/footer.php";
?>
