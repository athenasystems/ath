<div style="float:left;">


<div class="rightsky">
<h3>What our Customers are saying ...</h3>
<?php

$sqltext = "SELECT * FROM press WHERE kind='cust' ORDER BY RAND() LIMIT 4";
$res = $dbsys->query($sqltext) or die("Cant get press");

foreach($res as $r) {
	print <<<EOF
		<p style="font-size:80%;">
		<span style="font-style:italic;">
		{$p['quote']} </span><br>
		<span style="float:right;">
		<span style="font-weight:bold;">{$p['name']}  {$p['org']}
		</span>
		</p>
		<br clear="all">
EOF;
}
?></div>

<div class="rightsky">

<h3>What the Press are saying ...</h3>
<?php

$sqltext = "SELECT * FROM press WHERE kind='press' ORDER BY RAND() LIMIT 4";
$res = $dbsys->query($sqltext) or die("Cant get press");

foreach($res as $r) {

	print <<<EOF
		<p style="font-size:80%;">
		<span style="font-style:italic;">
		{$p['quote']} </span><br>
		<span style="float:right;">
		<span style="font-weight:bold;">{$p['name']}  {$p['org']}
		</span>
		</p>
		<br clear="all">
EOF;
}
?>

<br clear="all">
</div>
</div>