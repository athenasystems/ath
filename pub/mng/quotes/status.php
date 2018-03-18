<?php


$section = "quotes";
$page = "Quotes";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

	if(empty($errors)){

		if($_POST['live']!=1){
			$_POST['live']=0;
		}
		$quotesUpdate = new Quotes();

		$quotesUpdate->setQuotesid($_GET['id']);
		$quotesUpdate->setLive($_POST['live']);
		$quotesUpdate->updateDB();

		$logresult = logEvent(5,$logContent);

		header("Location: /quotes/view?id=".$_GET['id']);

		exit();

	}

}

$pagetitle = "Edit Quote";
$pagescript = array("/pub/calpop/calendar_eu.js");
$pagestyle = array("/css/calendar.css");

include "/srv/ath/pub/mng/tmpl/header.php";

include "helptab.php";


if(!isset($siteMods['quotes'])){
	?>
<h2>This Athena Module has not been activated</h2>
<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
exit;
}


$sqltext = "SELECT * FROM quotes WHERE quotesid='". addslashes($_GET['id']) ."'";
$res = $dbsite->query($sqltext); # or die("Cant get quotes");
if (! empty($res)) {
	$r = $res[0];
}else{
	header("Location: /quotes/");
	exit();
}

?>
<div id="fbhelptext" style="float: right;">
	<a href="javascript:void(0);" onclick="showHideHelp('helptext')">Show
		Help</a>
</div>
<br clear="all">
<div id="helptext" style="display: none;">

	Athena Quotes Status
	<ul>
		<li>Setting a Quote "Live" allows your customers to see it in Athena
			Customer Portal.</li>
		<li>This allows you to create and work on Quotes, but not have them
			available until you are ready.</li>
		<li>Once a Quote is Live, customers are able to log in to the Athena
			Customer Portal and respond to the Quote immediately.</li>
		<li>When a customer responds, Athena will send you an Email, and a
			link to the Submitted Quote will be visible on the front page summary
			panels, and Quotes section, flagged in red.</li>
	</ul>

</div>
<h2>Quote Status</h2>

<form
	action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $_GET['id']?>&amp;go=y"
	enctype="multipart/form-data" method="post">

	<h1>
		Quote No:
		<?php echo $r->quoteno?>
	</h1>
	<br>
	<h3>If this Quote is finished and ready to be seen by the customer,
		tick the box below.</h3>
	<br> <br>
	<fieldset class="form-group">
		<span style="font-size: 140%;"> <?php

		$chkd = ($r->live) ? 1 : 0;
		html_checkbox ('Make This Quote Live?', 'live', 1,$chkd);

		?>
		</span>
	</fieldset>

	<fieldset class="form-group">
		<?php
		html_button("Save changes");
		?>


	</fieldset>

</form>



<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
