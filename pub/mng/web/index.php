<?php

$section = "Web Site";
$page = "Web Site Home";

include "/srv/ath/src/php/mng/common.php";

$errors = array();
$pwhelp='';

$pagetitle = "staff";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";
?>

<h2>Web Site</h2>
<?php

if((isset($_GET['done']))&&($_GET['done']=='pic')){

	?>
<div class="alert alert-success" role="alert">
	<strong>Success</strong> <br> Your file has been upload. Click the link
	below to see your web site with the new header<br> <strong>Note:</strong>
	You may have to hit the "Refresh" icon (or press F5 on your keyboard)
	in your browser, when you see your web page, to see the new image.
</div>
<?php
}
?>
<h4>
	Your Web Site Address <a
		href="http://<?php echo $owner->subdom;?>.athena.systems"
		target="_blank"> http://<?php echo $owner->subdom;?>.athena.systems
	</a>
</h4>

<a href="/web/edit" class="btn btn-primary btn-xs">Edit your Site Text</a>

<a href="/web/pic" class="btn btn-primary btn-xs">Edit your Header Image</a>



<form
	action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $_GET['id']?>&amp;go=y"
	enctype="multipart/form-data" method="post">
	<?php echo form_fail(); ?>

	<h3>Your Web Site Domain Name</h3>
	<p>
		We recommend you buy and maintain your own company domain name.<br> If
		you buy a domain name, without buying hosting it costs no more than
		&pound;5 - &pound;10 a year. Once you have bought it you can point the
		domain name at your web site here. We can help you there if you need
		it.

	</p>
	<fieldset class="form-group">

		<?php
		if(!isset($domname)){
			$domname='';
		}
		#html_text('Domain Name', $domname);
		?>

	</fieldset>
	<p>&nbsp;</p>
	<fieldset class="form-group">
		<?php
		#html_button("Save changes");
		?>
	</fieldset>

</form>

<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
