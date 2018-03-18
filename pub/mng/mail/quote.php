<?php
include "/srv/ath/src/php/mng/common.php";
include ("/srv/ath/src/php/athena_mail.php");
include ("/srv/ath/src/php/mng/functions_email.php");
include ("/srv/ath/pub/mng/tmpl/blank_header.php");

$htmlBody = getQuoteMailBody($_GET['id']);

$sqltext = "SELECT cust.custid,cust.co_name,adds.email,
quotes.quoteno,cust.fname,cust.sname
FROM cust,quotes ,adds
WHERE quotes.custid=cust.custid
AND cust.addsid=adds.addsid
AND quotesid='" . $_GET['id'] . "' LIMIT 1";
// print $sqltext;

$res = $dbsite->query($sqltext); // or die("Cant get customer email");
if (! empty($res)) {
	$r = $res[0];
}else{
	echo "Mailer Error: There was a problem";
	exit;
}
$custid = $r->custid;

$quoteno = $r->quoteno;

$name = $r->fname . ' ' . $r->sname ;

$email = $r->email; // getContactEmailAdd($contactsid);

if( (!isset($email)) || ($email=='') ){
	echo "Mailer Error: Customer has No Email address on the system";

}else{
	if (!isset($_GET['go'])){
		?>

<h4>
	The Quote will be sent to:-

</h4>
Name: <?php echo $name ; ?><br>
	Email: <?php echo $email; ?><br> <br>
<span style="color:#777;">If these details are not correct you can edit them
<a href="/customers/edit.php?id=<?php echo $custid; ?>" target=_top>here</a>.
</span>
<br>
<br>
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
</form>

<?php
	}else{

		$docTitlePrefix = preg_replace('/\W/', '_', $owner->co_name);
		$docTitlePrefix = preg_replace('/__/', '_', $docTitlePrefix);
		$docTitle = $docTitlePrefix . "_Quote_" . $quoteno . '.pdf';
		$docName = $dataDir . "/pdf/quotes/$docTitle";

		// Make PDF
		passthru("perl /srv/ath/src/perl/mng/make_pdf_quote.pl format=file sitesid=" . $sitesid . " id=" . $_GET['id']);

		$name = $r->fname . ' ' . $r->sname;
		$esubject = "Your Quote from " . $owner->co_name;

		$ret = sendGmailEmail($name, $email, $esubject, $htmlBody, $docName, $docTitle);


		# Update DB
		$quotesUpdate = new Quotes();
		$quotesUpdate->setQuotesid($_GET['id']);
		$quotesUpdate->setSent(time());
		$quotesUpdate->updateDB();

		if((isset($_POST['cc']))&&($_POST['cc']==1)){
			$ret .= sendGmailEmail($owner->co_name ,$owner->email,$esubject ,$htmlBody,$docName,$docTitle);

		}
		$logContent = "QuoteID: " . $_GET['id'] . " sent to $name - $email";
		$logresult = logEvent(2, $logContent);


		echo $ret;
	}
}

include "/srv/ath/pub/mng/tmpl/blank_footer.php";

?>
