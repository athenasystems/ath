<?php
$section = "Quotes";
$page = "Quotes";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

$pagetitle = "Quotes";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";
include "helptab.php";

if (! isset($siteMods['quotes'])) {
    ?>
<h2>This Athena Module has not been activated</h2>
<?php
    include "/srv/ath/pub/mng/tmpl/footer.php";
    exit();
}
?>

<h2 style="margin-top: 0px;">Quotes Control Panel</h2>

<div class="row">
	<div class="col-md-6">


		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Recent Quotes</h3>
			</div>
			<div class="panel-body"></div>
		</div>


	</div>
	<div class="col-md-6">


		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Quotes from Customers</h3>
			</div>
			<div class="panel-body"></div>
		</div>

	</div>
</div>
<div class="row">
	<div class="col-md-6">


		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Quotes from the Web Site</h3>
			</div>
			<div class="panel-body"></div>
		</div>

	</div>
	<div class="col-md-6">


		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Quotes Statistics</h3>
			</div>
			<div class="panel-body"></div>
		</div>

	</div>
</div>


<?php

include "/srv/ath/pub/mng/tmpl/footer.php";
?>
