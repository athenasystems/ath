<?php

$section = "Staff";
$page = "Staff";

include "/srv/ath/src/php/staff/common.php";

$sqltext = "SELECT usr,pw from pwd where staffid=" . $staffid;
#print "<br/>$sqltext";
$res = $dbsite->query($sqltext); # or die("Cant get staff");
$rrt = $res[0];

$errors = array();
$pwhelp='';

if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

	if($seclevel>1){
		$required = array("opw","npw1","npw2","usr");
		$errors = check_required($required, $_POST);

		if( (!isset($_POST['opw'])) ||
				(strlen($_POST['opw'])<7)||
				(crypt($_POST['opw'], $rrt->pw) != $rrt->pw)
		){
			$oldpwwrong = 'Old password is wrong';
			$errors[] = 'opw';
		}

	}else{
		$required = array("npw1","npw2","usr");
		$errors = check_required($required, $_POST);
	}

	if( (!isset($_POST['npw1'])) || (!isset($_POST['npw2'])) ){
		$pwhelp='Please type your new password twice';
		$errors[] = 'npw1';
	}
	elseif(strlen($_POST['npw1'])<7){
		$pwhelp='New password is too short';
		$errors[] = 'npw1';
	}elseif (!chkLowercase($_POST['npw1'])){
		$pwhelp='No lower case letters in password';
		$errors[] = 'npw1';
	}elseif (!chkUppercase($_POST['npw1'])){
		$pwhelp='No upper case letters in password';
		$errors[] = 'npw1';
	}elseif (!chkDigit($_POST['npw1'])){
		$pwhelp='No numbers in password';
		$errors[] = 'npw1';
	}elseif($_POST['npw1']!=$_POST['npw2']){
		$pwhelp='New passwords are not the same';
		$errors[] = 'npw1';
	}


	$stfid = $_POST['stfid'];

	if(empty($errors)){

	    $staffUpdate = new Staff();
	    $staffUpdate->setStaffid($stfid);
	#    $staffUpdate->setInit_pw($_POST['npw1']);
	    $staffUpdate->updateDB();

	    $pwdUpdate = new Pwd();
	    $pwdUpdate->setUsr($_POST['usr']);
	    $pwdUpdate->setPw(crypt($_POST['npw1']));
	    $pwdUpdate->updateDB();

		#	$logresult = logEvent(15,$logContent);
		$done = 1;

	}
}

$pagetitle = "staff";
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

<h2>Staff Log In</h2>
<?php
if ((isset($done))&&($done)) {

	wereGood('The password has been changed');

}else{

	?>

<ol>
	<li id=subtitle><h3>Your Login Details</h3></li>

	<li><label>Your Username</label> <span
		style="font-size: 110%; font-weight: bold;"><?php echo $rrt->usr?> </span>
	</li>
</ol>

<p>&nbsp;</p>

<ol>

	<li id=subtitle><h3>Password</h3></li>
	<li>Password must contain at least ...
		<ul style="margin-left: 40px;">
			<li>A minimum of 7 Characters</li>
			<li style="list-style: disc;">One lower case letter</li>
			<li style="list-style: disc;">One upper case letter</li>
			<li style="list-style: disc;">One number</li>
		</ul>
	</li>
</ol>

<p>&nbsp;</p>
<form
	action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $staffid?>&amp;go=y"
	enctype="multipart/form-data" method="post">
	<?php echo form_fail(); ?>

	<fieldset class="form-group">
		<ol>
			<?php
			html_hidden('usr', $rrt->usr);
			html_hidden('stfid', $staffid);
			if($seclevel>1){
				if($oldpwwrong){
					echo '<li>'.$oldpwwrong.'</li>';
				}
				html_pw("Old Password", "opw", $_POST['opw']);
			}
			if($pwhelp!=''){
				echo '<li style="margin-left:40px;color:red;font-size:100%;">
				There is a problem with the new password: '.$pwhelp.'</li>';
			}

			html_pw("New Password", "npw1", $_POST['npw1']);
			html_pw("Repeat New Password", "npw2", $_POST['npw2']);
			?>
		</ol>
	</fieldset>

	<fieldset class="form-group">
		<?php
		html_button("Save changes");
		?>
	</fieldset>

</form>

<?php
}


include "/srv/ath/pub/staff/tmpl/footer.php";
?>
