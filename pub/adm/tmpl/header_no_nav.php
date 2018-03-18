<!DOCTYPE html>
<html lang="en">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <!-- Size for iPad and iPad mini (high resolution) -->
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="/img/apple-touch-icon-152x152.png">
    <!-- Size for iPhone and iPod touch (high resolution) -->
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="/img/apple-touch-icon-120x120.png">
    <!-- Size for iPad 2 and iPad mini (standard resolution) -->
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="/img/apple-touch-icon-76x76.png">
    <!-- Default non-defined size, also used for Android 2.1+ devices -->
    <link rel="apple-touch-icon-precomposed" href="/img/apple-touch-icon-60x60.png">

<title><?php echo htmlentities($pagetitle)?> - Admin Tools</title>

<style type="text/css">
@import '/css/css.php?site=adm';

<?php 
if (is_array($pagestyle)  && !empty ($pagestyle)){foreach ($pagestyle as
	$style){ ?> @import '/css/adm/<?php echo $style;?>'; <?php 

}
}
?>
</style>

<script	type="text/javascript" src="/pub/js/jquery.js"></script>
<script	type="text/javascript" src="/js/common.js"></script>
<?php 
	if (is_array($pagescript) && !empty($pagescript)){
		foreach($pagescript as $p){
			?> <script type="text/javascript" src="<?php echo $p?>"></script> <?php 
		}
	}

	?>

	<?php 
	if(($pagetitle == 'Edit customer')||($pagetitle == 'Edit supplier')){
		?> <script language="JavaScript" src="/pub/js/picker.js"></script> <?php 
	}

	?>

</head>
<body>

<div id="container">

<div id="header" class="clearfix"><?php 
if( isDev()){
	?> <span
	style="color: #FFFFFF; font-size: 80%; float: right; margin-left: 30px;">On
DB Host: <?php echo $host?></span> <?php 
}
?> <br><span
	style="float: right; padding: 5px; color: #FFFFFF; font-size: 120%;"><span
	style="font-size: 150%;">Workflow Tools</span>
	<?php 
	if((isset($fname))&&($fname!='')){
	?>
	<br>Logged in as: <?php echo $fname?> <?php echo $sname?>
 <?php 
	}
	?>
</span>

</div>


<br clear=all>

<div id="content">