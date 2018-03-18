<?php
$section = "Web Site";
$page = "Web Site Home";

include "/srv/ath/src/php/mng/common.php";

$errors = array();
$pwhelp='';

if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

	if(empty($errors)){

		$sqltext = "DELETE FROM web WHERE webid>0";
		$res = $dbsite->db->query($sqltext);


		foreach ($_POST as $key=>$value) {
			$webNew = new Web();
			$webNew->setText($value);
			$webNew->setPlace($key);
			$webNew->insertIntoDB();
		}
		passthru("sudo /usr/bin/perl /srv/ath/src/perl/cron/build.web.pages.pl $sitesid");
		header("Location: /web/");
	}
}

$pagetitle = "staff";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";
?>
<h3>Edit the text on your Web Pages</h3>
<?php

$sqltext = "SELECT text,place FROM web";
#print "<br/>$sqltext";
$res = $dbsite->query($sqltext); # or die("Cant get web site details");

foreach($res as $r) {
	$_POST[$r->place]= $r->text;
}

?>

<form
	action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">
	<?php echo form_fail(); ?>

	<fieldset class="form-group">
		<?php
		#html_text('Front Page Heading', 'head',$_POST['head']);
		html_text('Company Tagline', 'headtag',$_POST['headtag']);
		html_text('About Section Title', 'abouthead',$_POST['abouthead']);
		html_textarea('About Section Text', 'abouttxt',$_POST['abouttxt']);
		html_text('Service 1 Heading', 'srv1head',$_POST['srv1head']);
		html_text('Service 1 Text', 'srv1txt',$_POST['srv1txt']);
		html_text('Service 2 Heading', 'srv2head',$_POST['srv2head']);
		html_text('Service 2 Text', 'srv2txt',$_POST['srv2txt']);
		html_text('Service 3 Heading', 'srv3head',$_POST['srv3head']);
		html_text('Service 3 Text', 'srv3txt',$_POST['srv3txt']);
		html_text('Service 4 Heading', 'srv4head',$_POST['srv4head']);
		html_text('Service 4 Text', 'srv4txt',$_POST['srv4txt']);
		html_textarea('Directions', 'directions',$_POST['directions']);
		?>
	</fieldset>
	<p>&nbsp;</p>
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
