<?php 

print <<<EOF
		
		<h3 style="text-align:center;">What our customers<br>are saying ...</h3>
		
EOF;
	
$sqltext = "SELECT * FROM press ORDER BY RAND() LIMIT 4";
		$res = $dbsite->query($sqltext); # or die("Cant get testamonials");
		
		foreach($res as $p) {
		
		print <<<EOF
		
		<p style="font-size:80%;">
		<span style="font-style:italic;">
		{$p->quote} </span><br>
		<span style="float:right;">
		<span style="font-weight:bold;">{$p->name}  {$p->org} 
		</span>
		
		</p>
		<br clear="all">
		
		
EOF;
		}
		
?>
