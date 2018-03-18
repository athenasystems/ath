<?php

$section = "Web Site";
$page = "Web Site Home";

include "/srv/ath/src/php/mng/common.php";

$errors = array();
$pwhelp='';
$done = 0;
if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

	if(empty($errors)){

		if(isset($_FILES['image'])){
			$errors= array();
			$file_name = $_FILES['image']['name'];
			$file_size =$_FILES['image']['size'];
			$file_tmp =$_FILES['image']['tmp_name'];
			$file_type=$_FILES['image']['type'];
			$file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));

			$expensions= array("jpeg","jpg","png");

			if(in_array($file_ext,$expensions)=== false){
				$errors[]="extension not allowed, please choose a JPEG or PNG file.";
			}

			if($file_size > 2097152){
				$errors[]='File size must be no more than 2 MB';
			}

			if(empty($errors)==true){
				move_uploaded_file($file_tmp,"$webDir/img/header.jpg");
			}
		}

		passthru("sudo /usr/bin/perl /srv/ath/src/perl/cron/build.web.pages.pl $sitesid");

		if(empty($errors)==true){
			header("Location: /web/?done=pic");
		}
	}
}

$pagetitle = "Web Site Header Image";
$pagescript = array();
$pagestyle = array();


include "/srv/ath/pub/mng/tmpl/header.php";
?>

<h2>Web Site</h2>

<?php
if(empty($errors)!=true){

	print_r($errors);
}

?>

<h3>Your Web Site Header Image</h3>

<form action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">
	<?php echo form_fail(); ?>

	<br> <br>

	<fieldset class="form-group">


		<?php
		#html_text('Front Page Heading', 'head',$_POST['head']);
		html_file('Header Image', 'image');

		?>

	</fieldset>

	<fieldset class="form-group">
		<?php
		html_button("Save changes");
		html_hidden('head', 'Home');
		?>
	</fieldset>
</form>

<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
