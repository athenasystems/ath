<?php
$section = "Contacts";
$page = "Staff";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {
    
    if (empty($errors)) {
        
        $usr = getUsrFromStaffID($_GET['id']);
        
        $pwdUpdate = new Pwd();
        $pwdUpdate->setUsr($usr);
        $pwdUpdate->setSeclev($_POST['seclev']);
        $pwdUpdate->updateDB();
        
        // $logresult = logEvent(15,$logContent);
        $done = 1;
    }
}

$pagetitle = "staff";
$pagescript = array();
$pagestyle = array();

$sqltext = "SELECT * from staff where staffid=" . $_GET['id'];
// print "<br/>$sqltext";
$res = $dbsite->query($sqltext); // or die("Cant get the staff times!");
$rStaff = $res[0];

include "/srv/ath/pub/mng/tmpl/header.php";
?>

<h2>Athena Access</h2>
<br>
<h4>Choose which site this user should log in to ...</h4>
<br>
<p>Here you can choose to allow a staff member </p>
<ul><li>Full Athena Access, which
	is this site you are now in</li>
<li>Limit their access to just the Staff
	Portal</li>
</ul>
<br><br>
<form
	action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $_GET['id']?>&amp;go=y"
	enctype="multipart/form-data" method="post">
	<?php echo form_fail(); ?>

	<fieldset class="form-group">

			<?php
html_hidden('stfid', $_GET['id']);

$group['1'] = 'Full Athena Access';
$group['10'] = 'Staff Portal Access';

html_radios('Access', 'seclev', $group, $rStaff->level);
?>
			
	</fieldset>
	<p>&nbsp;</p>
	<fieldset class="form-group">
		<?php
html_button("Save changes");
?>
		

	</fieldset>

</form>

<?php

include "/srv/ath/pub/mng/tmpl/footer.php";
?>
