<?php
$section = "Home";
$page = "Home";

include "/srv/ath/src/php/mng/common.php";

$pagetitle = "Home";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";
$warn = '';

?>
<h4>Athena for <?php echo $owner->co_name?></h4>
<?php

if ($owner->add1 == '') {
    $warn .= <<< EOF
	<br>Please fill out your company address and other details <a
		href="/acc/company">here</a>
EOF;
}
if ($fname == 'Business') {
    $warn .= <<< EOF
		<br>Please fill out your name <a
		href="/staff/edit.php?id=$staffid">here</a>
EOF;
}

if (($owner->eoyday == '') || ($owner->eoyday == 0)) {}

$nino = getNextInvoiceNo();
if ($nino == 1) {
    $warn .= <<< EOF
		<br>You can choose where to start your invoice numbers <a
		href="/acc/init_nos">here</a>. <br>
		Note: This is a one time only thing.
	Once you have issued an invoice this value will be set.
EOF;
}
if (isset($siteMods['quotes'])) {
    $nqno = getNextQuoteNo();
    if ($nqno == 1) {
        $warn .= <<< EOF
		<br>You can choose where to start your quote numbers <a
		href="/acc/init_nos">here</a>. <br>
		Note: This is a one time only thing.
	Once you have issued a quote this value will be set.
EOF;
    }
}
if ($warn != '') {
    ?>
<div class="alert alert-warning" role="alert">
	<strong>Welcome</strong>
	<?php echo $warn; ?>
</div>
<?php
}

?>

<br clear="all">


<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>

