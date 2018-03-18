<?php

include "/srv/ath/src/php/mng/common.php";
include ("/srv/ath/src/php/athena_mail.php");
include ("/srv/ath/src/php/mng/functions_email.php");

$logContent=sendContactAccessMail($_GET['cid']);

$logresult = logEvent(26,$logContent);

header("Location: /contacts/edit?SentAccessEmail=1&id=".$_GET['cid'] );
exit();

?>