<?php

$section = "Contacts";
$page = "Staff";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

$pagetitle = "staff";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";
?>


<h2>Staff Holiday</h2>

<?php
$sqltext = "SELECT * FROM staff WHERE status='active' AND staffid>1000";
$res = $dbsite->query($sqltext); # or die("Cant get staff");
?>
<ul class="list">

	<?php

	if (! empty($res)) {
		foreach($res as $r) {
			$r = $res[0];

			$jobTitle = '';
			if($r->jobtitle!=''){
				$jobTitle = '<span style="font-size:70%"> - ' . $r->jobtitle . '</span>';
			}
			if($seclevel<10){
				$holHTML = ($seclevel<2) ? getHolidayData($r->staffid) : '';
				?>

	<li style="border: 1px solid #eee; padding: 4px;">
		<div style="float: left; width: 300px;">
			<?php echo htmlentities($r->fname)?>
			<?php echo $r->sname?>
			<?php echo $jobTitle?>
		</div>
		<div style="float: left; width: 550px;">
			<?php echo $holHTML?>
		</div> <br clear=all />



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


include "/srv/ath/pub/mng/tmpl/footer.php";
?>