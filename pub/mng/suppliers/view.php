<?php


$section = "Contacts";
$page = "view";

include "/srv/ath/src/php/mng/common.php";
include "/srv/ath/src/php/athena_mail.php";
include "/srv/ath/src/php/mng/functions_email.php";

$errors = array();

$done='';
if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

	$logContent=sendContactAccessMail($_GET['cid']);

	$name = getContactName($_GET['cid']);

	$done = "An email has been sent to $name with access details for the Customer Control Panel";

	$logresult = logEvent(25,$logContent);
}


$pagetitle = "View supplier";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";

$sqltext = "SELECT * FROM supp WHERE suppid='". addslashes($_GET['id']) ."'";

$res = $dbsite->query($sqltext); # or die("Cant get supplier");

$r = $res[0];

$addsid = $r->addsid;
$adds = getAddress($r->addsid);
?>

<h2>View supplier</h2>

<?php
if($done!=''){
	$msg = $done;
	wereGood($msg);
}

echo '<h3>Company Details</h3>';

tablerow('Name',$r->fname. ' ' . $r->sname );
tablerow('Company Name',$r->co_name );

include '/srv/ath/src/php/tmpl/adds.view.php';
$invContact = '';
if((isset($r->inv_contact))&&($r->inv_contact!='')&&($r->inv_contact>0)){
	$invContact = getSuppExtName($r->inv_contact);
	tablerow_li('Invoice Contact',$invContact );
}

?>

<h3>
	<?php echo $r->co_name;?>
	Staff
</h3>


<?php
$sqltext2 = "SELECT * FROM contacts
WHERE fname<>'Company' AND suppid=" . $_GET['id'];
#print "<br/>$sqltext2";

$qq = $dbsite->query($sqltext2);# or die("Cant get External supplier Contact");
foreach($qq as $rr) {

	$staffHTML = <<< EOF
<a	href="/contacts/edit.php?id={$rr->contactsid}" title="Edit External Supplier Contact">
<strong>{$rr->fname} {$rr->sname}</strong></a>

<form action="/suppliers/view?id={$_GET['id']}&cid={$rr->contactsid}&amp;go=y"
enctype="multipart/form-data" method="post" style="float:right;">
<input type="submit" value="Send Access Details" />
</form>
EOF;


	tablerow('Contact', $staffHTML);
}
?>

<br clear=all />


<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>



