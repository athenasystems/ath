<?php
$section = "quotes";
$page = "Quotes";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

$qno = ((isset($_POST['q'])) && ($_POST['q'] != '')) ? $_POST['q'] : '';

$ino = ((isset($_POST['i'])) && ($_POST['i'] != '')) ? $_POST['i'] : '';

$done =0;

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	if (isset($siteMods['quotes'])) {
		if (! is_numeric($qno)) {
			$errors[] = 'qno';
		}
	}
	if (! is_numeric($ino)) {
		$errors[] = 'ino';
	}

	if (empty($errors)) {
		if (isset($siteMods['quotes'])) {
			file_put_contents($dataDir . '/qno', $qno);
		}

		file_put_contents($dataDir . '/ino', $ino);
	}
	$done = 1;
}

$pagetitle = "Edit Quote Numbering";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";

?>
<div id="fbhelptext" style="float: right;">
	<a href="javascript:void(0);" onclick="showHideHelp('helptext')">Show
		Help</a>
</div>
<br clear="all">

<h2>Document Numbering</h2>
<?php
if($done){
	$msg = 'I\'ve saved that';
	wereGood($msg);
}
?><?php echo form_fail(); ?>
<form action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">
	<?php
	if (isset($siteMods['quotes'])) {
		?>
	<h3>Choose your first Quote number</h3>
	<br> <br>
	<fieldset class="form-group">
		<?php
		if(file_exists($dataDir . '/qno')){
			$qno = file_get_contents($dataDir . '/qno');
		}
		html_text("First Quote No", 'q', $qno);
		?>

	</fieldset>
	<?php } ?>

	<h3>Choose your first Invoice number</h3>
	<br> <br>
	<fieldset class="form-group">
		<?php
		if(file_exists($dataDir . '/ino')){
			$ino = file_get_contents($dataDir . '/ino');
		}
		html_text("First Invoice No", 'i', $ino);
		?>

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
