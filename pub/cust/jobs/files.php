<?php 

$section = "catalogue";
$page = "Jobs";


include "/srv/ath/src/php/cust/common.php";
include "/srv/ath/src/php/athena_mail.php";


$errors = array();

$done = "";

if($_GET['upload'] == "y"){

	$required = array("jobno");
	$errors = check_required($required, $_POST);

	if($_FILES['jobfile']['name'] == ""){
	$errors[] = 'jobfile';
	}

	if(empty($errors)){

		$input = array();

		if($_FILES['jobfile']['name'] != ""){

			$jobno = $_POST['jobno'];

			# Upload the new file
			$ret = file_share_upload($jobno,"jobfile", 'C' );
			
			
			# Create and send Email
			$jobsid = getJobIDFromNo($jobno);			
			$ffile = $_FILES['jobfile']['name'] ;
			
			$htmlBody = <<<EOF
<img 
src="http://www.$domain/img/email.header.jpg"
 border=0 alt="{$owner->co_name}" title="{$owner->co_name}"><br><br>
New files have been added to Athena Online by a customer via the Control Panel.<br><br>			
File is named $ffile and is meant for Job No: $jobno<br><br>			
<a href="http://mng.$domain/jobs/view?id=$jobsid">Go to Job</a>
EOF;
	
			$esubject = "New Files from Customer";			
			$owner->email='wmodtest@gmail.com';			
			sendGmailEmail($owner->co_name,$owner->email,$esubject ,$htmlBody);
			
			
			#$logresult = logEvent(5,$logContent);
				
			header("Location: /jobs/view?nf=y&id=". $jobsid);
			exit();
								
		}
	}
}

$pagetitle = "File Upload";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/cust/tmpl/header.php";


if(!isset($siteMods['jobs'])){
	?>
	<h2>This Athena Module has not been activated</h2>
	<?php
	include "/srv/ath/pub/cust/tmpl/footer.php";
	exit;
	}
	
	
?>

<h2><?php echo $owner->co_name; ?> Control Panel</h2>

<?php 
if($done != ''){
	print $done;
}else{
	?>


To submit files fill in the details below and choose the file to send.
<br>
<form action="<?php echo $_SERVER['PHP_SELF']?>?upload=y&id=" method="post"
	enctype="multipart/form-data"><?php echo form_fail(); ?>

<fieldset class="form-group">

<ul>

<?php 
job_select("Job No *",'jobno',$custID,$_GET['jobno']);
html_file ("Job File *", 'jobfile', '', "");

?>

</ul>
</fieldset>

<fieldset class="form-group"><?php 
html_button("Upload File");
?></fieldset>

</form>
<br>
<br>
Please wait while the files are uploaded.

<?php 
}
?>

<br>
<br>
<br>
<br>

<?php 
include "/srv/ath/pub/cust/tmpl/footer.php" ;
?>