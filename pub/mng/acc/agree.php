<?php
$section = "Account";
$page = "Account";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	$required = array(
			"pid"
	);
	$errors = check_required($required, $_POST);

	if (empty($errors)) {

		$logContent = "\n";

		$salesNew = new Sales();
		$salesNew->setSitesid($sitesid);
		$salesNew->setProductsid($_POST['pid']);
		$salesNew->setIncept(time());
		$salesNew->insertIntoDB();

		$modsNew = new Mods();
		$modsNew->setSitesid($sitesid);

		if ($_POST['pid'] == 1000) {
			$modsNew->setModulesid(16);
			$modsNew->insertIntoDB();
		} elseif ($_POST['pid'] == 1001) {
			$mods = array(
					3,8,10,12,16
			);
			foreach ($mods as $mod) {
				$modsNew->setModulesid($mod);
				$modsNew->insertIntoDB();
			}
		} elseif ($_POST['pid'] < 1000) {
			$modsNew->setModulesid($_POST['pid']);
			$modsNew->insertIntoDB();
		}

		// $logresult = logEvent(13,$logContent);

		header("Location: /acc/?" . $result['id']);

		exit();
	}
}

$pagetitle = "Account";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";
?>
<div id=mru>
	<div>
		<h3>Agree to Term &amp; Conditions</h3>
		<br clear="all">
		<h3>
			Module: <?php echo getModuleName($_GET['pid']);?>
		</h3>
		<br> Blah blah blah ... <br> <br>Face it ... you weren't going to read
		it anyway :)
		<form action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
			enctype="multipart/form-data" method="post" name=agreeform>
			<?php echo form_fail(); ?>
			<fieldset class="form-group">
				<?php
				html_button("Add This Module",'','agree');
				html_hidden('pid', $_GET['pid']);
				?>
			</fieldset>

		</form>
	</div>
</div>
<br clear="all">
<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
