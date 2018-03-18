<!DOCTYPE html>
<html lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<title><?php echo $owner->co_name; ?> - <?php echo htmlentities($pagetitle)?></title>
	<style type="text/css">
		@import '/css/print_style.css';
	</style>

</head>
<body>  


		<div id="header" class="clearfix">	
      <div class="bigtitle">
	  <h2><?php echo $owner->co_name; ?></h2>
	  
	   <span style="font-size:85%">
	  
	  	<?php echo $owner->add1; ?>,
		<?php echo $owner->add2; ?>
		<?php echo $owner->add3; ?><br>
		<?php echo $owner->city; ?>,
		<?php echo $owner->county; ?>,
		<?php echo $owner->country; ?>,
		<?php echo $owner->postcode; ?><br>
		Tel: <?php echo $owner->tel; ?><br>
		Fax: <?php echo $owner->fax; ?><br>
	  Co. Reg. No:<?php echo $owner->co_no; ?><br>
	  Email: <?php echo $owner->email; ?><br>
	  Website: <?php echo $owner->web; ?><br>
	  </span>
	  
	  </div>
        <p><img src="/img/co.logo.png" />
		</p>
		</div>

		<br clear=all>

		<div id="content">