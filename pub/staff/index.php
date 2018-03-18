<?php 

$section = "home";
$page = "Home";

include "/srv/ath/src/php/staff/common.php";

$pagetitle = "Home";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/staff/tmpl/header.php";

if(!isset($siteMods['staff'])){
	?>
	<h2>This Athena Module has not been activated</h2>
	<?php
	include "/srv/ath/pub/mng/tmpl/footer.php";
	exit;
	}
?>

<h4>Athena For Staff for <?php echo $owner->co_name?></h4>

<br>

<ul>
<li>Above are the tabs to get to the features in Athena.</li>
<li>Timesheets are for filling in the hours you have worked across a week.</li>


	<?php 
	if($staffid==3145345345){

		?>
	<li>
		<h2>Job Hours Admin</h2>
		<form  action="/jobs/all_hours.php"
			enctype="multipart/form-data" method="get">

			<?php 
			jobsid_hours_select('Job No', 'jobsid' ,$_POST['jobsid']);

			?>

		</form>
	</li>
	<?php 
	}
	?>
</ul>



<?php 

include "/srv/ath/pub/staff/tmpl/footer.php";
?>
