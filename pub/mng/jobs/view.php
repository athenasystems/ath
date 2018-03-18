<?php


$section = "Jobs";
$page = "view";

include "/srv/ath/src/php/mng/common.php";

$sqltext = "SELECT jobs.incept,jobs.jobno,jobs.jobsid,jobs.done,jobs.custref,
cust.custid,cust.co_name,cust.filestr,
items.itemsid,items.content,jobs.quantity,items.price
FROM jobs,items,cust
WHERE items.itemsid=jobs.itemsid
AND jobs.custid=cust.custid
AND jobs.jobsid='". $_GET['id'] ."'";
$res = $dbsite->query($sqltext); # or die("Cant get jobs");
$r = $res[0];

$custFileStore = '/srv/ath/var/files/cust/'.$r->filestr ;


$errors = array();

if( (isset($_GET['go'])) && ($_GET['go'] == "mkpdf") ){

	passthru("perl /srv/ath/src/perl/mng/root_delivery_note.pl " . $_GET['id'] . " " . $sitesid );

}


if(( isset($_GET['go']) && ($_GET['go']=='delfile') ) && ( isset($_GET['fn']) && ($_GET['fn']!='') )){

	unlink( $custFileStore . '/' . base64_decode($_GET['fn']) );

}
$pagetitle = "Edit Job";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";

include "helptab.php";

if(!isset($siteMods['jobs'])){
	?>
<h2>This Athena Module has not been activated</h2>
<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
exit;
}



if( isset($_GET['nf']) && ($_GET['nf']=='y') ){
	?>
<div style="display: block;">
	<span id=help>Your file has been uploaded and is available below.
		Athena has sent an email to <?php echo getCustName($r->custid)?> to
		let them know.
	</span>
</div>
<br>
<?php
}

$jobsid=$_GET['id'];
$jno = $r->jobno;
$delnoteno = $r->jobno;
$delnoteno = preg_replace("/J/","D",$delnoteno);
$docTitlePrefix = preg_replace('/\W/', '_', $owner->co_name);
$docTitlePrefix = preg_replace('/__/', '_', $docTitlePrefix);
$docTitle = $dataDir . "/pdf/delivery/".$docTitlePrefix."_Delivery_Note_" . $delnoteno . '.pdf';
$docWebName = "/data/$sitesid/pdf/delivery/".$docTitlePrefix."_Delivery_Note_" . $delnoteno . '.pdf';

?>



<h1>
	View Job No:
	<?php echo $r->jobno;?>
</h1>

<?php

form_fail();

$retHTML .= <<<EOF
<h2>Job No: {$r->jobno}</h2>
EOF;


$content = '<a href="/quotes/view.php?id='.$r->quotesid.'" title="View Quote" class="cancel">'.$r->quoteno.'</a>';

tablerow("Customer",$r->co_name);
tablerow("Item Description",$r->content);

#tablerow("Job Notes",$r->notes);
#tablerow("Delivery",$r->delivery);
#tablerow("Quantity",$r->quantity);
tablerow("Date Started",date("Y-m-d", $r->incept));

if( (is_numeric($r->done)) && ($r->done>0 ) ){
	$content = date("Y-m-d", $r->done);
}else{
	$content = "Not Done Yet";
}
tablerow("Date Completed",$content);

tablerow("Customer Ref",$r->custref);
#tablerow("Internal Contact",getStaffName($r->staffid));
#tablerow("External Contact",getCustExtName($r->contactsid));

?>

<script>
<!--
function confirmSubmit()
{
var agree=confirm("Are you sure you wish to delete this file?");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>

<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
