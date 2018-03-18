<?php 

$page = "Help";

include "/srv/ath/src/php/cust/common.php";



$pagetitle = "Help";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/cust/tmpl/header.php";
?>

<br>

<h2><?php echo $owner->co_name ?> Customer Control Panel</h2>
<h2>Logging on</h2>
<p>Log-in using a web browser to this address,
<strong><?php echo $cust_url; ?></strong></p>
<p>You should have received your log-in details via Email already, if
you have not received your log-in information then contact <?php echo $owner->co_nick; ?> and ask them to send your Log-In details again. After you have
logged in to the system you will see the Customer Services screen. At
the top of the page you will see the option available to you.</p>
<h2>Home Section</h2>
<p>The Home page will allow you to Request a Quote from your <?php echo $owner->co_nick; ?>.
Any Jobs created from a Quote will be started here.</p>
<h2>Quotes Section</h2>
<p>The Quotes page will allow you to see the status of your Quote
request. Any Quote request will be displayed here. You can add any files
you need and edit you Quote at any time. You will notice that is says,
"Awaiting Quotation". When you Request a Quote, your supplier will
receive an Email telling them you have asked for a Quote. When they have
submitted the Quote you will then receive a similar Email telling you
that a Quote is ready for you to view. Your Quote will now say,
"Awaiting Confirmation". If you are satisfied with the Quote then you
can confirm that you would like to accept the Quote price. When you do
this your Quote will become a Job.</p>
<h2>Jobs Section</h2>
<p>The Jobs page will show you any Jobs that have been created from an
accepted Quote. You can narrow your search by using the Show Jobs
filter. This will allow you to see Jobs that are finished and Jobs that
are still in progress.</p>
<h2>Job Progress Section</h2>
<p>The Progress page will show you what stage all your Jobs are
currently at. You will see a break-down of the whole manufacturing
process. Each stage is represented as an individual column. Jobs at the
top of each column have the highest priority. You can see details on the
your Jobs by clicking the Job number or Job Card link.</p>



<br>
<br>



<?php 
include "/srv/ath/pub/cust/tmpl/footer.php" ;
?>
