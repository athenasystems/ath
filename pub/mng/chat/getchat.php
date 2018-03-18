<?php
include "/srv/ath/src/php/mng/common.php";

#header("Cache-Control: no-cache");
header('Cache-Control: no-cache, no-store, must-revalidate');
$noOfLines = ( (isset($_GET['l']))  &&
		($_GET['l']!='')
) ? $_GET['l'] : 20;

$out = getChat($noOfLines);

print $out;

?>
