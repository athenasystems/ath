<?php

include "/srv/ath/src/php/adm/common.php";

$txt =$argv[1];

$encrypted= base64_encode(encrypt($txt));

print $encrypted;
exit;
