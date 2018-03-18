<?php
# THIS IS SUPP PORTAL INDEX
$page = "Home";

include "/srv/ath/src/php/supp/common.php";

#

$errors = array();

$done = "";

$pagetitle = "Control Panel Home";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/supp/tmpl/header.php";
?>

<h4>Athena For Suppliers for <?php echo $owner->co_name?></h4>

<br>
<?php
	if(isset($siteMods['quotes'])){

		?>
<h2>Quotes</h2>
Quotes will be listed under the Quotes tab when they have been requested by <?php echo $owner->co_name; ?>,
you should also recieve an email letting you know that a quote has been requested.
You can then quote your price and a date by which you can deliver. You can
also email yourself a copy of the quote you send us, however, you can log in at any time
to access all your previous quotes to us.

<?php

	}

	if(isset($siteMods['orders'])){

		?>

<h2>Orders</h2>
Once <?php echo $owner->co_name; ?> has approved your quote, you will be emailed
to let you know, and the new order will be listed under the Orders tab.
<br>
<br>


<?php
	}


include "/srv/ath/pub/supp/tmpl/footer.php" ;
?>