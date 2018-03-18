<?php 

$section = "catalogue";
$page = "Quotes";

include "/srv/ath/src/php/supp/common.php";


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

			$ret = file_share_upload($quoteno,"quotefile", 'S' );
			
// 			$ffile = $_FILES['quotefile']['name'] ;

// 			$htmlBody = <<<EOF

// New files ahave been added to the data store by a customer via the Control Panel.<br><br>
// $ffile - for Quote No: $quoteno

// EOF;

// 			$esubject = "New Files from Customer";
			
// 			sendGmailEmail($owner->co_name,$owner->email,$esubject ,$htmlBody);
			

			$done = '<h2>The quote file has been uploaded</h2>';

		}
	}
}

$pagetitle = "File Upload";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/supp/tmpl/header.php";

if(!isset($siteMods['orders'])){
	?>
<h2>This Athena Module has not been activated</h2>
<?php
include "/srv/ath/pub/supp/tmpl/footer.php";
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
<form action="<?php echo $_SERVER['PHP_SELF']?>?upload=y" method="post"
	enctype="multipart/form-data">
	<?php echo form_fail(); ?>

	<fieldset class="form-group">

		<ul>

			<?php 
			quote_select("Quote No *",'quoteno',$suppID,$_GET['quoteno']);
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
include "/srv/ath/pub/supp/tmpl/footer.php" ;
?>