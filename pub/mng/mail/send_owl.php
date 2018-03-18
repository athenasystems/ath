<?php
include "/srv/ath/src/php/mng/common.php";
include "/srv/ath/src/php/athena_mail.php";

$url = base64_decode($_POST['url']);

include '/srv/ath/pub/mng/tmpl/header.php';

?>
<h3>Send an Email</h3>
<iframe style="padding: 12px; margin: 12px; width: 96%; height: 400px;"
	frameborder="0" marginheight="12" marginwidth="12"
	src="<?php echo $url; ?>"> </iframe>

<?php

include '/srv/ath/pub/mng/tmpl/footer.php';

?>