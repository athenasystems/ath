<?php 
# this is for supp
$page = "Help";

include "/srv/ath/src/php/supp/common.php";




$pagetitle = "Help";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/supp/tmpl/header.php";
?>


<h2><?php echo $owner->co_name; ?> Control Panel</h2>

<br>
<br>

<h2>Control Panel Help</h2>
<h2>Logging on</h2>
<p>Log-in using a web browser to this address,
<?php echo $supp_url; ?></p>
<p>You should have received your log-in details via Email already, if
you have not received your log-in information then contact <?php echo $owner->co_name; ?>
and ask them to send your Log-In details again. After you have
logged in to the system you will see the Customer Services screen. At
the top of the page you will see the option available to you.</p>




<br>
<br>



<?php 
include "/srv/ath/pub/supp/tmpl/footer.php" ;
?>
