<?php

if( (!isset($_GET['id'])) && (isset($argv[1])) ){
	$_GET['id'] = $argv[1];
}

include "/srv/ath/src/php/mng/common.php";
include ("/srv/ath/src/php/athena_mail.php");
include ("/srv/ath/src/php/mng/functions_email.php");
include ("/srv/ath/pub/mng/tmpl/blank_header.php");

$htmlBody = getInvoiceMailBodyShort($_GET['id']);

$sqltext = "SELECT
cust.custid,
cust.co_name,
cust.fname,
cust.sname,
adds.email,
invoices.invoiceno
FROM
cust,
invoices,
adds
WHERE
invoices.invoicesid = '". $_GET['id'] ."'
AND invoices.custid = cust.custid
AND cust.addsid = adds.addsid
LIMIT 1";

//print $sqltext;

$res = $dbsite->query($sqltext); # or die("Cant get customer email");
if (! empty($res)) {
	$r = $res[0];
}else{
	echo "Mailer Error: There was a problem";
	exit;
}

$custid = $r->custid;

$co_name = $r->co_name;

$name = $r->fname . ' ' . $r->sname ;

$email = $r->email ;  #getContactEmailAdd($r->contactsid);

$invoiceno = $r->invoiceno;

if( (!isset($email)) || ($email=='') ){
	echo "Mailer Error: Customer has No Email address on the system";

}else{
	if (!isset($_GET['go'])){
		?>

<h4>The Invoice will be sent to:-</h4>

Name:
<?php echo $name ; ?>
<br>
Email:
<?php echo $email; ?>
<br>
<br>
<span style="color: #777;">If these details are not correct you can edit
	them <a href="/customers/edit.php?id=<?php echo $custid; ?>"
	target=_top>here</a>.</span>
	<br><br>
	<form
		action="<?php echo $_SERVER['PHP_SELF']?>?go=y&id=<?php echo $_GET['id']; ?>"
		enctype="multipart/form-data" method="post">
		<fieldset class="form-group">
			<?php
			html_checkbox('Send a copy to yourself?', 'cc', 1);
			#html_text('Send a copy to some else?', 'ccc', '');

			?>

		</fieldset>
		<fieldset class="form-group">
			<?php
			html_hidden('id', $_GET['id']);
			html_button('Send the mail -&gt;');
			?>

		</fieldset>
	</form> <?php
	}else{

		$docTitlePrefix = preg_replace('/\W/', '_', $owner->co_name);
		$docTitlePrefix = preg_replace('/__/', '_', $docTitlePrefix);
		$docTitle = $docTitlePrefix."_Invoice_" . $invoiceno . '.pdf';
		$docName = $dataDir . "/pdf/invoices/$docTitle";

		# PDF Attachment
		#if(!file_exists($docName)){

		# Else make a PDF
		passthru("perl /srv/ath/src/perl/mng/make_pdf_invoice.pl format=file sid=".$sitesid." id=" . $_GET['id']);

		#}
		$esubject="Your Invoice from " . $owner->co_name;
		$ret = sendGmailEmail($name,$email,$esubject ,$htmlBody,$docName,$docTitle);

		# Update DB
		$invoicesUpdate = new Invoices();
		$invoicesUpdate->setInvoicesid($_GET['id']);
		$invoicesUpdate->setSent(time());
		$invoicesUpdate->updateDB();

		if((isset($_POST['cc']))&&($_POST['cc']==1)){
			$ret .= sendGmailEmail($owner->co_name ,$owner->email,$esubject ,$htmlBody,$docName,$docTitle);

		}
		$logContent= "InvID: " . $_GET['id'] . " sent to $name - $email";
		$logresult = logEvent(14,$logContent);

		echo $ret;
	}
}
include "/srv/ath/pub/mng/tmpl/blank_footer.php";
