<?php
$page = "Home";

include "/srv/ath/src/php/cust/common.php";

$errors = array();

$done = "";

$pagetitle = "Control Panel Home";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/cust/tmpl/header.php";

if (isset($siteMods['quotes'])) {
    ?>
<h2>Quotes</h2>
Your quotes will appear be listed under the Quotes tab once they have
been prepared.
<br>
<br>
<a href="/quotes/add.php">Request a Quote from <?php echo $owner->co_name ?></a>
<br>
<?php
}

if (isset($siteMods['jobs'])) {

    ?>
<h2>Invoices</h2>
Invoices in PDF format are listed here
<br>
<br>
<br>
<br>
<?php
}

include "/srv/ath/pub/cust/tmpl/footer.php";
?>