<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Size for iPad and iPad mini (high resolution) -->
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="/img/apple-touch-icon-152x152.png">
    <!-- Size for iPhone and iPod touch (high resolution) -->
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="/img/apple-touch-icon-120x120.png">
    <!-- Size for iPad 2 and iPad mini (standard resolution) -->
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="/img/apple-touch-icon-76x76.png">
    <!-- Default non-defined size, also used for Android 2.1+ devices -->
    <link rel="apple-touch-icon-precomposed" href="/img/apple-touch-icon-60x60.png">

<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo htmlentities($pagetitle)?> - Admin Tools</title>
<link href="/pub/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="/pub/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
<link href="/pub/bootstrap/css/staff_theme.css" rel="stylesheet">
<link rel="stylesheet" href="/pub/font-awesome/css/font-awesome.min.css" type="text/css">
<style type="text/css">
<?php

if ((isset($pagestyle)) && (is_array ($pagestyle)) && (!empty($pagestyle))){
	foreach	($pagestyle as  $style ){
		echo '@import ' . $style ."\n";
	}
}
?>
</style>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="/js/staff/common.js"></script>
<?php
if (is_array($pagescript) && !empty($pagescript)){
	foreach($pagescript as $p){
		?>
<script type="text/javascript" src="<?php echo $p?>"></script>
<?php
	}
}
?>
</head>
<body role="document">
	<?php
	#		include '/srv/ath/src/php/staff/diary_bar.php';
	?>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed"
					data-toggle="collapse" data-target="#navbar" aria-expanded="false"
					aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">Athena</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<?php

					$addons = array();

					$addons[] = (object) array("name" => "Diary","url" => '/diary');
					$addons[] = (object) array("name" => "Tasks","url" => '/tasks');

					$addons[] = (object) array("name" => "Timesheet","url" => '/times/add');

					$i=1;

					foreach($addons as $r) {

						?>
					<li><a href="<?php echo $r->url; ?>"
						title="<?php echo htmlentities($r->name);?>"> <?php echo htmlentities($r->name);?>
					</a></li>
					<?php
					$i++;
					}
					?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown" role="button" aria-haspopup="true"
						aria-expanded="false">Settings <span class="caret"></span>
					</a>
						<ul class="dropdown-menu">

							<li><a href="/edit">Your Details</a></li>
							<li><a href="/account" title="Account">Account</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="/pass.php?pg=logout&s=<?php echo $sitesid; ?>">Log
									Out</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</nav>

	<div class="container" role="main">
