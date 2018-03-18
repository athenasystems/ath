<?php
include "/srv/ath/src/php/mng/common.php";

$errors = array ();

$pagetitle = "Chat";
$pagescript = array ();
$pagestyle = array ();

$id = ((isset ( $_GET ['q'] )) && ($_GET ['q'] != '')) ? $_GET ['q'] : '';

$section = "Chat";
$page = "Chat";

include "/srv/ath/pub/mng/tmpl/header.php";
?>
<h2 style="margin-top: 0px;">Company Chat</h2>


<?php echo getChatBox();?>
<script type="text/javascript">
<!--
window.onload = refreshChat;
setInterval(refreshChat, 6000);
//-->
</script>
<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>