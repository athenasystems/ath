<?php


$section = "Contacts";
$page = "view";

include "/srv/ath/src/php/mng/common.php";
include "/srv/ath/src/php/athena_mail.php";
include "/srv/ath/src/php/mng/functions_email.php";

$errors = array();
$done = '';

if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

	$logContent=sendCustAccessMail($_GET['id']);

	$name = getCustName($_GET['id']);

	$done = "An email has been sent to $name with access details for the Customer Control Panel";

	$logresult = logEvent(26,$logContent);
}


$pagetitle = "View customer";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";

$sqltext = "SELECT * FROM cust WHERE custid='". addslashes($_GET['id']) ."'";

#print "<br/>$sqltext";

$res = $dbsite->query($sqltext); # or die("Cant get customer");

$r = $res[0];


$addsid = $r->addsid;
$adds = getAddress($r->addsid);


if($done!=''){
	$msg = 'Email Sent';
	wereGood($msg);
}
?>
<div style="float: right;">
	<a class="btn btn-primary"
		href="/customers/edit.php?id=<?php echo $_GET['id']?>"
		title="Edit Customer">Edit Customer</a>
	<?php
	if(isset($siteMods['custport'])){
		?>
	<form action="/customers/view?id=<?php echo $_GET['id'];?>&amp;go=y"
		enctype="multipart/form-data" method="post" style="display: inline;">
		<input class="btn btn-primary" type="submit"
			value="Send Login Details" />
	</form>
	<?php
	}
	?>
</div>

<h2>View Customer</h2>


<?php
echo '<h3>Company Details</h3>';
tablerow('First Name', $r->fname);
tablerow('Surname Name', $r->sname);
if($r->co_name != $r->fname.' '.$r->sname){
	tablerow('Company Name', $r->co_name);
}
include '/srv/ath/src/php/tmpl/adds.view.php';

$invContact = '';
if((isset($r->inv_contact))&&($r->inv_contact!='')&&($r->inv_contact>0)){
	$invContact = getCustExtName($r->inv_contact);
	tablerow('Invoice Contact',$invContact );
}

$sqltext2 = "SELECT * FROM contacts WHERE fname<>'Company' AND custid=" . $_GET['id'];
#print "<br/>$sqltext2";
$resContact = $dbsite->query($sqltext2);# or die("Cant get External Customer Contact");


if (! empty($resContact)) {
	?>

<h3>
	<?php echo $r->co_name;?>
	Staff
</h3>

<?php
foreach($resContact as $rr) {

	$staffHTML .= <<< EOF

		<a	href="/contacts/edit.php?id={$rr->contactsid}"
		title="Edit External Customer Contact">
		<strong>{$rr->fname} {$rr->sname}</strong></a>



EOF;


	tablerow('Contact', $staffHTML);
	?>



<?php
}
}

?>

<br clear=all />



<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
