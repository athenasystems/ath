<?php

#
#	This drops file into the data store for the site
#	which are collected by the cron job get.int.job.uploads.pl

$section = "Jobs";
$page = "Jobs";

include "/srv/ath/src/php/mng/common.php";
include "/srv/ath/src/php/athena_mail.php";

$sqltext = "SELECT * FROM jobs,items,quotes WHERE
jobs.itemsid=items.itemsid
AND items.quotesid=quotes.quotesid
AND jobsid='". addslashes($_GET['id']) ."'";
$res = $dbsite->query($sqltext); # or die("Cant get jobs");
if (! empty($res)) {
	$r = $res[0];
}else{
	header("Location: /jobs/");
	exit();
}


$errors = array();

if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

	$required = ("jobfile0");
	$errors = check_required($required, $_POST);

	if(empty($errors)){

		$jobsid = $_GET['id'] ;
		$jobno = $r->jobno ;


		for ($i = 0; $i < 10; $i++) {

			if($_FILES["jobfile$i"]['name'] != ""){

				$ret = file_share_upload($r->jobno,"jobfile$i", 'I' );
			}
		}
		if( isset($r->contactsid) && ($r->contactsid>0)){

			$sqltextExt = "SELECT fname,sname,email,logon,init_pw FROM contacts,adds
			WHERE contacts.addsid=adds.addsid
			AND contactsid=". $r->contactsid ;
			$qExt = $dbsite->query($sqltextExt) or die("Cant get ext staff details");
			
			if (! empty($qExt)) {
				$rExt = $qExt[0];

				# Create and send Email

				# Make login link
				$purl = base64_encode("/jobs/view?id=$jobsid");

				$htmlBody = <<<EOF
<img
src="http://www.$domain/img/email.header.jpg"
 border=0 alt="{$owner->co_name}" title="{$owner->co_name}"><br><br>

Dear {$rExt->fname} {$rExt->sname}<br><br>

New files have been added to {$owner->co_name}'s Online Control Panel for a Job.<br><br>

The new file is meant for Job No: $jobno<br><br>

<a href="http://login.$domain/?purl=$purl">Go to Job</a><br><br>


Your access details are:-<br>
Username: {$rExt->logon}<br>
Password: {$rExt->init_pw}<br>
<br><br>
Regards<br><br>

{$owner->co_name}
EOF;

				$esubject = "New Files from " . $owner->co_name;
				$rExt->email='wmodtest@gmail.com';
				sendGmailEmail($rExt->fname.' '.$rExt->sname,$rExt->email,$esubject ,$htmlBody);

			}

		}



		$logresult = logEvent(5,$logContent);

		header("Location: /jobs/view?nf=y&id=". $_GET['id']);
		exit();

	}

}


$pagetitle = "Share Files for Job No:" . $r->jobno;
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";
include "filestab.php";

if(!isset($siteMods['jobs'])){
	?>
<h2>This Athena Module has not been activated</h2>
<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
exit;
}


$path = getPathToFilesReal($r->jobno);
?>

<h1>
	<?php echo $pagetitle; ?>
</h1>
<?php echo $pathToFiles; ?>
<form
	action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $_GET['id']?>&amp;go=y"
	enctype="multipart/form-data" method="post">
	<?php
	form_fail();
	html_hidden('jobno',$r->jobno);
	?>
	<p>&nbsp;</p>
	<p>
		Files you upload here will be shared with

		<?php echo getCustName($r->custid); ?>
		on the View Job page
	</p>

	<p>&nbsp;</p>
	<fieldset class="form-group">

		<ol>
			<?php

			html_file("Add file to Job?", "jobfile0");

			?>
			<li><span id="filerowmore0"
				style="font-size: 70%; margin-left: 153px"> <a
					href="javascript:void(0);"
					onclick="document.getElementById('filerowmore0').style.display='none';document.getElementById('filerow1').style.display='block';">Add
						another file ...</a>
			</span></li>
			<?php

			for($i=1; $i<=9; $i++){
				fileBlock($i);
			}

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
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
