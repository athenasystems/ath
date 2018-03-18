<?php

$section = "tasks";
$page = "Tasks";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

}

$pagetitle = "Tasks List";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";

include "helptab.php";


if(!isset($siteMods['tasks'])){
	?>
	<h2>This Athena Module has not been activated</h2>
	<?php
#	include "/srv/ath/pub/mng/tmpl/footer.php";
#	exit;
	}


setlocale(LC_MONETARY, 'en_GB.UTF-8');

?>

<h1>
	Tasks <a class="btn btn-primary btn-xs" href="/tasks/add" title="Add new Task">Add new Task</a>

</h1>

<ol>

	<?php

	$sqltext = "SELECT * from tasks";

	if((isset($_GET['id']))&&($_GET['id']>0)){
		$sqltext .= " AND custid=" . $_GET['id'] ;
	}
	$sqltext .= " ORDER BY tasksid DESC" ;
	#print "<br/>$sqltext";

	$res = $dbsite->query($sqltext); # or die("Cant get tasks!");

	if (!empty($res)){

		$subtotals = array();

		foreach($res as $r) {


			if(!isset($subtotals[$r->staffid])){
				$subtotals[$r->staffid]=0;
			}

			$dd = date("d-m-Y",$r->incept);
			$custName = getCustName($r->custid);
			$staffName = getStaffName($r->staffid);

			$notes = stripslashes($r->notes);
			$ssub = money_format('%!i', $subtotal );

			if(!$r->hours>0){
				$style = ' <sup style="color:#f00;">New!!!</sup>';
			}else{
				$style = '';
			}
			$jobno = '';
			if((isset($r->jobsid))&&($r->jobsid!='')){
				$jobno = 'For Job No: '.getJobNoByID($r->jobsid);
			}

			$html .= <<< EOF
		<div class="panel panel-default">
  <div class="panel-heading">
  $style
		$dd, Work for $custName $jobno
  </div>
  <div class="panel-body">
  Task Done By: $staffName<br>
  Tasks: $notes<br>
		Hours: {$r->hours}
  </div>
</div>
EOF;

		}

		print $html;

		?>

</ol>

<?php


for ($i = 2; $i <= 4; $i++) {
	if($subtotals[$i]){
		print getStaffName($i) . ': &pound;' . $subtotals[$i] . '<br>';
	}
}

if((isset($_GET['id']))&&($_GET['id']>0)){
	?>
<br>
<br>
<form  action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">
	<fieldset class="form-group">
		<?php
		html_button("Convert Tasks above to Items ready for Invoicing");
		html_hidden("custid",$_GET['id']);
		?>
	</fieldset>
</form>
<?php
}
	}else{
		?>
No Tasks found
<?php
	}

	include "/srv/ath/pub/mng/tmpl/footer.php";
	?>
