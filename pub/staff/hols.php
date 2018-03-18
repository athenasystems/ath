<?php

$section = "Staff";
$page = "Staff";

include "/srv/ath/src/php/staff/common.php";

$errors = array();

$pagetitle = "staff";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/staff/tmpl/header.php";


if(!isset($siteMods['holidays'])){
	?>
	<h2>This Athena Module has not been activated</h2>
	<?php
	include "/srv/ath/pub/staff/tmpl/footer.php";
	exit;
	}



$yr_now = date("Y");
$hols_period_start = mktime(0,0,0,$holiday['year_start_month'],$holiday['year_start_day'],$yr_now);

?>
<h2>Staff Holiday</h2>

<h2>Holiday Period Starts: <?php echo date("d/m/Y",$hols_period_start); ?></h2>
<?php
$sqltext = "SELECT * FROM staff WHERE staffid=$staffid AND status='active' AND staffid>1000";
$res = $dbsite->query($sqltext); # or die("Cant get staff");
if (! empty($res)) {
	?>
<ul class="list">
	<?php
	$r = $res[0];
		$jobTitle = '';
		if($r->jobtitle!=''){
			$jobTitle = '<span style="font-size:70%"> - ' . $r->jobtitle . '</span>';
		}

			$holHTML = getHolidayData($staffid) ;
			?>

	<li style="border: 1px solid #eee; padding: 4px;">

		<br>
		<div style="width: 550px;">
			<?php echo $holHTML?>
		</div> <br clear=all />
	</li>

</ul>

<?php
}


include "/srv/ath/pub/staff/tmpl/footer.php";
?>