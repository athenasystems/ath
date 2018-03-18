<!DOCTYPE html><html lang="en"><head><meta charset="utf-8">
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
<title><?php echo htmlentities($pagetitle)?> - Athena Tools</title>
<link href="/pub/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/pub/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
  <link href="/pub/bootstrap/css/theme.css" rel="stylesheet">
<style type="text/css">
<?php
if  (is_array ($pagestyle)   && !empty  ($pagestyle )){
	foreach($pagestyle as $style){
		?> @import '<?php echo $style;?>'; <?php
	}
}
?>
</style>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="/js/mng/common.js"></script>
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
#include '/srv/ath/src/php/mng/diary_bar.php';
#include '/srv/ath/pub/mng/tmpl/nav.php';
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
			<a class="navbar-brand" href="https://athena.systems/" title="">Athena</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">


 					<li><a href="https://signup.athena.systems"	title="">Sign Up</a></li>


			</ul>

		</div>
	</div>
	<!--/.nav-collapse -->
</nav>
<div class="container" role="main">