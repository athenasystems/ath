<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo htmlentities($pagetitle)?> - Admin Tools</title>
<link href="/pub/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/pub/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
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
		include '/srv/ath/src/php/mng/diary_bar.php';
		?>
    <nav class="navbar navbar-inverse navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Athena Admin <?php
		if(isDev()){
			print $_SERVER['SERVER_ADDR'];
		}

?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
				<?php

				$addons = array();

				$addons[] = (object) array("name" => "Sites","url" => '/sites');
				$addons[] = (object) array("name" => "WWW","url" => 'http://athena.systems');

				$i=1;
				if (! empty($addons)) {
					foreach($addons as $r) {
						?>
				<li class="<?php if($page == $r->name) print " here ";?><?php if($i == count($res)) print " last ";?>"><a
					href="<?php echo $r->url?>" title="<?php echo htmlentities($r->name)?>"><?php echo htmlentities($r->name)?>
				</a></li>
				<?php
			$i++;
		      }
		}

	?>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Settings <span class="caret"></span></a>
              <ul class="dropdown-menu">
                 <li><a href="/pass.php?pg=logout">Log	Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

<div class="container" role="main">