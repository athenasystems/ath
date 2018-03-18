<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo htmlentities($pagetitle)?> - Admin Tools</title>

<style type="text/css">
@import '/css/css.php?site=int';
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
<body>

	<div id="container">
		<?php
		include '/srv/ath/src/php/mng/diary_bar.php';
		?>

		<div id="header" class="clearfix">

	<h2>Athena For <?php echo $owner->co_name?></h2>
			<h3>&nbsp;</h3>
			<span
				style="color: #FFFFFF; font-size: 80%; float: right; margin-left: 30px;margin-top: 3px;">
				Athena Workflow by <a style="color: #fff;"
				href="http://athena.systems" target="_blank">Athena Systems</a>


			</span> <br> <span
				style="float: right; padding: 5px; color: #FFFFFF; font-size: 80%;">
				Logged in as: <?php echo $fname?> <?php echo $sname?> - <a
				href="/pass.php?pg=logout&s=<?php echo $sitesid; ?>" title="Log out" style="color: #fff;">Log
					Out</a>
			</span>




		</div>
		<div id="nav" style="background-color: #111;">

			<select onchange="nav_refresh();" id=navsel style="font-size: 120%;background-color: #111;color:#fff;  margin: 0;">

				<?php
				$sqltext = "SELECT pagesid, url, name
				FROM modules,mods
				WHERE mods.modulesid=modules.modulesid
				AND level>=" .  $seclevel ."
				ORDER BY ordernum";

				#print $sqltext;AND pages.isnav='y'
			$res = $dbsys->query($sqltext) or die("Cant get pages");

            $i=1;
            foreach($res as $r) {
                $r = $res[0];

					?>

				<option value="<?php echo $r->url?>" style="background-color: #111;" <?php if ($page == $r->name){echo ' selected=selected ';}?>>
					<?php echo htmlentities($r->name)?>
				</option>
				<?php
				$i++;

				}


				?>

			</select>

		</div>

		<br clear=all>

		<div id="content">