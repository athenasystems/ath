<!DOCTYPE html>
<html lang="en">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title><?php echo htmlentities($pagetitle)?> - Admin Tools</title>

<style type="text/css">
@import '/css/css.php?site=int';

<?php 
if (is_array($pagestyle)  && !empty ($pagestyle)){foreach ($pagestyle as
	$style){ ?> @import '/css/mng/<?php echo $style;?>'; <?php 

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