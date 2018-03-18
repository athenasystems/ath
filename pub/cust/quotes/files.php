<?php 
#
#	This drops file into the data store for the site
#

$section = "catalogue";
$page = "Quotes";

include "/srv/ath/src/php/cust/common.php";
include "/srv/ath/src/php/athena_mail.php";

$errors = array();

$done = "";

if($_GET['upload'] == "y"){

	$required = array("quoteno");
	$errors = check_required($required, $_POST);

	if($_FILES['quotefile']['name'] == ""){
		$errors[] = 'quotefile';
	}

	if(empty($errors)){

		$input = array();

		if($_FILES['quotefile']['name'] != ""){

			$quoteno = $_POST['quoteno'];
			
			$ret = file_share_upload($quoteno,"quotefile", 'C' );
			
			$ffile = $_FILES['quotefile']['name'] ;

			# Create and send Email
			$quotesid = getQuoteIDFromNo($quoteno);
			$ffile = $_FILES['jobfile']['name'] ;
				
			$htmlBody = <<<EOF
<img
src="http://www.$domain/img/email.header.jpg"
 border=0 alt="{$owner->co_name}" title="{$owner->co_name}"><br><br>
New files have been added to your Online Control Panel by a customer.<br><br>
File is named $ffile and is meant for Quote No: $quoteno<br><br>
<a href="http://mng.$domain/quotes/view?id=$quotesid">Go to Job</a>


EOF;
			
			$esubject = "New Files from Customer";
			$owner->email='wmodtest@gmail.com';
			sendGmailEmail($owner->co_name,$owner->email,$esubject ,$htmlBody);
		
			#$logresult = logEvent(5,$logContent);
			
			header("Location: /quotes/view?nf=y&id=". $quotesid);
			exit();
			

		}
	}
}

$pagetitle = "File Upload";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/cust/tmpl/header.php";

if(!isset($siteMods['quotes'])){
	?>
	<h2>This Athena Module has not been activated</h2>
	<?php
	include "/srv/ath/pub/cust/tmpl/footer.php";
	exit;
	}
	
	
?>

<h1>
	<?php echo $owner->co_name; ?>
	Control Panel
</h1>

<?php 
if($done != ''){
	echo $done;
}else{
	?>
To submit files fill in the details below and choose the file to send.
<br>
<form action="<?php echo $_SERVER['PHP_SELF']?>?upload=y" method="post"
	enctype="multipart/form-data">
	<?php echo form_fail(); ?>

	<fieldset class="form-group">

		<ul>

			<?php 
			quote_select("Quote No *",'quoteno',$custID,$_GET['quoteno']);
			html_file ("Quote File *", 'quotefile', '', "");

			?>

		</ul>
	</fieldset>
	<fieldset class="form-group">
		<?php 
		html_button("Upload File");
		?>
	</fieldset>

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