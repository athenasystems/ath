<?php

function getQuoteMailBody($quotesid){

	global $owner;
	global $cust_url;
	global $domain;
	global $dbsite;

	$sqltext = "SELECT * FROM quotes,cust
	WHERE quotes.custid=cust.custid
	AND quotes.quotesid='". $quotesid ."'
	AND quotesid>0 LIMIT 1";

	#print $sqltext;

	$res = $dbsite->query($sqltext); # or die("Cant get quoted");
	if (! empty($res)) {
		$r = $res[0];
	}else{
		return 0;
	}

	$quotedate = date('d-m-Y',$r->incept);

	$r->content = preg_replace("/\r\n/", "<br>" , $r->content);
	#$r->content = preg_replace("/\r/", "<br>" , $r->content);

	$int_contact = getStaffName($r->staffid);

	$retHTML = <<< EOHTML
<br><br>Please find attached your quote from {$owner->co_name}:-<br><br>
EOHTML;

	$user = getCustAdminLogin($r->custid);
	$user=$user['name'];
	$pw=$user['passwd'];

	if( isset($user) && isset($pw)&&($user!='')&&($pw!='')){
		$retHTML .= <<< EOHTML
	<br><br>
	<h2>{$owner->co_name} Customer Control Panel</h2>
You can view all your quotes, and agree to this quote from {$owner->co_name} at our Customer Control Panel.
Your login Details are below.<br><br>

Web Address - $cust_url/quotes/view.php?id=$quotesid<br>
Username: $user<br>
Password: $pw<br><br>

Please keep these details secure. <br><br>
EOHTML;
	}

	$retHTML .= <<< EOHTML

<br clear="both" />
Best Regards,<br><br>

{$owner->co_name}

<br><br>
-- <br>
{$owner->co_name}<br>
{$owner->add1},<br>
	{$owner->add2} {$owner->add3}<br>
	{$owner->city},	{$owner->county}<br>
	{$owner->country}	{$owner->postcode}<br>


	Tel: {$owner->tel}<br>
	Fax: {$owner->fax}<br>
	Email: {$owner->email}<br>
	Website: {$owner->web}

EOHTML;


	return ($retHTML);


}

function getInvoiceMailBody($invoicesid){

	global $dbsite;
	global $owner;
	global $www_url;

	$sqltext = "SELECT jobs.incept,jobs.jobno,jobs.jobsid,jobs.done,jobs.jobcontent,jobs.notes,
	quotes.quotesid,quotes.content as qcontent,quotes.quoteno,quotes.staffid,
	jobs.custref,quotes.contactsid,cust.co_name,cust.inv_contact,addsid,
	invoices.invoicesid,invoices.invoiceno,invoices.incept as invincept
	FROM jobs,items,quotes,cust,invoices
	WHERE items.itemsid=jobs.itemsid
	AND items.quotesid=quotes.quotesid
	AND jobs.invoicesid = invoices.invoicesid
	AND quotes.custid=cust.custid
	AND jobs.itemsid=items.itemsid
	AND invoices.invoicesid=".  $invoicesid ;
	#print $sqltext;
	$res = $dbsite->query($sqltext); # or die("Cant get quoted");
	if (! empty($res)) {
		$r = $res[0];
	}else{
		return 0;
	}

	$date = date("d/m/Y", $r->invincept);
	$foa = '';
	if( isset($r->inv_contact) && $r->inv_contact!='' && is_numeric($r->inv_contact)){
		$foa = "<br>FAO: " . getCustExtName($r->inv_contact) . "<br>";
	}

	$jobcontent = stripslashes($r->jobcontent);
	$content = stripslashes($r->content);

	$retHTML .= <<<EOHTML
	<div style="text-align:right;">

	<img src="$www_url/img/co.logo.png" border="0" width="247" align="left"><br><br>

	{$owner->co_name}<br>
{$owner->add1},<br>
	{$owner->add2} {$owner->add3}<br>
	{$owner->city},	{$owner->county}<br>
	{$owner->country}	{$owner->postcode}<br>


	Tel: {$owner->tel}<br>
	Fax: {$owner->fax}<br>
	Email: {$owner->email}<br>
	Website: {$owner->web}
</div>
	<br clear="all">
<h1>
	SALES INVOICE
</h1>

	<div style="float:right;text-align:right;">
		<table cellpadding=4>
		<tr>
			<td align=right>Invoice No:</td><td>{$r->invoiceno}</td>
		</tr>
		<tr>
			<td align=right>Date:</td><td>$date</td>
		</tr>
		<tr>
			<td align=right>Your Ref:</td><td>{$r->custref}</td>
		</tr>
		<tr>
			<td align=right>{$owner->co_nick} Job No:</td><td>{$r->jobno}</td>
		</tr>
		<tr>
			<td align=right>VAT Reg No:</td><td>{$owner->vat_no}</td>
		</tr>
		</table>
	</div>
Invoice TO:- {$r->co_name}<br>
	{$r->add1}<br>
	{$r->add2}<br>
	{$r->add3}<br>
	{$r->city}<br>
	{$r->county}<br>
	{$r->postcode}<br>

	$foa

	<br clear="all">


	<span style="font-size:80%;font-weight:bold;">Work Completed</span><br>
	<span style="font-weight:bold;">$jobcontent</span><br><br>

<table  border="0" cellpadding="4" cellspacing="4" width="90%">
  <tr style="font-size:80%;font-weight:bold;"><td valign="top">Details</td><td valign="top">Item Price</td><td valign="top">Quantity</td></tr>

EOHTML;

	$sqltextItems = "SELECT * FROM items WHERE invoicesid='". addslashes($_GET['id']) ."'";

	#print $sqltext;

	$qItems = $dbsite->query($sqltextItems) or die("Cant get items");
	if (! empty($qItems)) {

		foreach($qItems as $rItems) {

			$subtotal = $rItems->quantity * $rItems->price;


			$retHTML .= <<<EOHTML
  <tr>
  <td valign="top">$content</td>
  <td valign="top">&pound;{$rItems->price}</td>
  <td valign="top">X {$rItems->quantity}</td>
  <td style="width: 100px; text-align: center;">&pound; $subtotal</td>
  </tr>

EOHTML;


			$total += $subtotal;
		}

	}


	#$total = $r->quantity * $r->price;
	$total = money_format('%i', $total);

	$vat_rate = getVAT_Rate($r->invincept);
	$vat_rateText = getVatText($vat_rate);

	$vat = money_format('%i', round($total * $vat_rate, 2 ));
	$totalprice = money_format('%i', $total + $vat);

	$retHTML .= <<<EOHTML
</table>
<br><br>
	<div style="float:right;width:350px;text-align:right;font-weight:bold;padding-right:40px;">
    Price &pound;$total<br>
	VAT @ $vat_rateText		= &pound;$vat<br>
	<h3>Amount Due &pound;$totalprice</h3><br>
	</div>
	<br clear="all">

  <br clear="both" />
Best Regards,<br><br>

{$owner->co_name}
<br><br>
EOHTML;


return ($retHTML);


}

function getInvoiceMailBodyShort($invoicesid){

	global $dbsite;
	global $owner;
	global $www_url;
	global $domain;

	$sqltext = "SELECT cust.co_name,cust.inv_contact
	FROM cust,invoices
	WHERE invoices.custid=cust.custid
	AND invoices.invoicesid=".  $invoicesid ;
	//print $sqltext;
	$res = $dbsite->query($sqltext); # or die("Cant get quoted");
	if (! empty($res)) {
		$r = $res[0];
	}else{
		return 0;
	}

	$foa = '';

	if( isset($r->inv_contact) && is_numeric($r->inv_contact) && $r->inv_contact>0){
		$foa =  getCustExtName($r->inv_contact) ;
	}else{
		$foa =  $r->co_name ;
	}

	$retHTML .= <<<EOHTML
<img
src="http://www.$domain/img/email.header.jpg"
 border=0 alt="{$owner->co_name}" title="{$owner->co_name}"><br><br>

Dear $foa,<br><br>
Your latest Invoice from {$owner->co_name} is attached to this email in PDF format.<br><br>

Best Regards,<br><br>

{$owner->co_name}
<br><br>
EOHTML;


return ($retHTML);


}

function getOrderMailBody($ordersid,$suppid){

	global $dbsite;
	global $owner;
	global $www_url;
	global $supp_url;
	global $domain;


	$sqltext = "SELECT * FROM orders WHERE ordersid=". $ordersid ;

	$res = $dbsite->query($sqltext); # or die("Cant get order");
	if (! empty($res)) {
		$r = $res[0];
	}else{
		return 0;
	}

	$sqltext = "SELECT * FROM supp,adds WHERE adds.addsid=supp.addsid AND supp.suppid=". $suppid ;

	$resSupp = $dbsite->query($sqltext); # or die("Cant get supplier");
	if (! empty($resSupp)) {
		$r = $resSupp[0];
	}else{
		return 0;
	}
	$date = date("d/m/Y", $r->incept);
	$foa = '';

	$content = stripslashes($r->content);

	#<img src="$www_url/img/co.logo.png" border="0" width="247" align="left"><br><br>

	$retHTML = <<<EOHTML
	<div style="text-align:right;">



	{$owner->co_name}<br>
{$owner->add1},<br>
	{$owner->add2} {$owner->add3}<br>
	{$owner->city},	{$owner->county}<br>
	{$owner->country}	{$owner->postcode}<br>


	Tel: {$owner->tel}<br>
	Fax: {$owner->fax}<br>
	Email: {$owner->email}<br>
	Website: {$owner->web}
</div>
	<br clear="all">
<h1>
	Invitation to Quote
</h1>

	<div style="float:right;text-align:right;padding:10px;">
		<table cellpadding=4>
		<tr>
			<td align=right>Order No:</td><td>$ordersid</td>
		</tr>
		<tr>
			<td align=right>Date:</td><td>$date</td>
		</tr>
		<tr>
			<td align=right>{$owner->co_nick} Job No:</td><td>{$r->jobno}</td>
		</tr>
		<tr>
			<td align=right>VAT Reg No:</td><td>114 6698 58</td>
		</tr>
		</table>
	</div>
Invitation to:-<br>
{$rSupp['co_name']}<br>
{$rSupp['add1']}      {$rSupp['add2']}      {$rSupp['add3']}<br>
{$rSupp['city']}      {$rSupp['county']}    {$rSupp['postcode']}

$foa

	<br clear="all">


	<span style="font-size:90%;font-weight:bold;">Please quote on the following items:-</span><br>

<table  border="0" cellpadding="4" cellspacing="4" width="440">

  <tr style="font-size:80%;font-weight:bold;">
  <td valign="top">Description</td>
  <td valign="top">Quantity</td>
  </tr>

  <tr style="font-size:120%;">
  <td valign="top">$content</td>
  <td valign="top">X {$r->quantity}</td>
  </tr>

</table>

<br><br>
EOHTML;

$user = getSuppAdminLogin($suppid);
$user=$user['name'];
$pw=$user['passwd'];

if( isset($user) && isset($pw)&&($user!='')&&($pw!='')){

	$retHTML .= <<< EOHTML
	<h2>{$owner->co_name} Suppliers Web Site</h2>
	You can submit your quote through the {$owner->co_name} Suppliers Web Site. <br>
	Use the following link to log into your own private area and submit your quote right now.<br><br>

	Address: <a href="$supp_url">$supp_url</a><br>
	Username: $user<br>
Password: $pw<br><br>

	<br>
EOHTML;
}

$retHTML .= <<< EOHTML

<br clear="all">

<br clear="both" />

Best Regards,<br><br>

{$owner->co_name}
<br><br>
EOHTML;


return ($retHTML);


}

function getPurchaseOrderMailBody($ordersid,$suppid){
	global $dbsite;
	global $owner;
	global $www_url;


	$sqltext = "SELECT * FROM orders,order_req,supp
	WHERE order_req.orderid=orders.ordersid
	AND order_req.suppid=supp.suppid
	AND order_req.suppid=$suppid
	AND orders.ordersid=$ordersid" ;

	$res = $dbsite->query($sqltext); # or die("Cant get order");
	if (! empty($res)) {
		$r = $res[0];
	}else{
		return 0;
	}

	$date = date("d/m/Y", $r->incept);
	$dateok = date("d/m/Y", $r->dateok);
	$priceok = '&pound; ' . $r->priceok;
	$foa = '';

	$content = stripslashes($r->content);

	$retHTML = <<<EOHTML
	<div style="text-align:right;">

{$owner->co_name} Company Limited<br>
{$owner->add1},<br>
	{$owner->add2} {$owner->add3}<br>
	{$owner->city},	{$owner->county}<br>
	{$owner->country}	{$owner->postcode}<br>


	Tel: {$owner->tel}<br>
	Fax: {$owner->fax}<br>
	Email: {$owner->email}<br>
	Website: {$owner->web}
</div>
	<br clear="all">
<h1>
Purchase Order
</h1>

<div style="float:right;text-align:right;padding:10px;">
<table cellpadding=4>
<tr>
<td align=right>Order No:</td><td>$ordersid</td>
</tr>
<tr>
<td align=right>Date:</td><td>$date</td>
</tr>
<tr>
<td align=right>{$owner->co_nick} Job No:</td><td>{$r->jobno}</td>
</tr>
<tr>
<td align=right>VAT Reg No:</td><td>114 6698 58</td>
</tr>
</table>
</div>
To:-<br>
{$r->co_name}<br>
{$r->add1}      {$r->add2}      {$r->add3}<br>
{$r->city}      {$r->county}    {$r->postcode}

$foa
<br clear="all">


<span>Please supply the following items as agreed:-</span><br>

<table  border="0" cellpadding="4" cellspacing="4" width="440">

<tr>
<td valign="top">Description</td>
<td valign="top">Quantity</td>
</tr>

<tr>
<td valign="top">$content</td>
<td valign="top">X {$r->quantity}</td>
</tr>

</table>
<p>Date Agreed: $dateok</p>
<p>Price Agreed: $priceok</p>
<br clear="all">

<br clear="both" />

Best Regards,<br><br>

{$owner->co_name}
<br><br>
<br><br>

EOHTML;


return ($retHTML);


}

function sendCustAccessMail($custid){

	global $sitesid;
	global $dbsite;
	global $owner;
	global $cust_url;
	global $domain;

	$sqltext = "SELECT usr,init,email,co_name,fname,sname FROM pwd,cust,adds
	WHERE pwd.custid=cust.custid AND
	cust.addsid=adds.addsid AND
	cust.custid=$custid LIMIT 1". $custid ;
	#echo $sqltext;
	$res = $dbsite->query($sqltext); # or die("Cant get contacts details");
	#echo $q->num_rows;
	if (! empty($res)) {
		$r = $res[0];

		$user=$r->usr;
		$pw=decrypt($r->init);

		#echo		$user . ' ' . $pw ;

		if( isset($user) && isset($pw)&&($user!='')&&($pw!='')){
			$htmlBody = <<<EOHTML

			<img
src="http://www.$domain/img/email.header.jpg"
 border=0 alt="{$owner->co_name}" title="{$owner->co_name}">
<br><br>

<h2>{$owner->co_name} Control Panel Access Details</h2>
Your Access Details for the {$owner->co_name} Control Panel are below.<br><br>

Web Address - http://{$owner->subdom}.athena.systems/login<br>
Username: $user<br>
Password: $pw<br><br>

Please keep these details secure. <br><br>

Many thanks<br><br>

{$owner->co_name}<br><br>

EOHTML;

$n = $r->fname.' '.$r->sname;
if($n==' '){
	$n=$r->co_name;
}

sendGmailEmail($n,$r->email,$owner->co_name.' Control Panel Access',$htmlBody);

$ret = 'Sent mail to ' . $r->co_name . ',' . $r->email;
return $ret;

		}else{
			$ret = 'Mail not sent - Customer not known';
			return $ret;
		}
	}else{
		$ret = 'Mail not sent - Customer unknown';
		return $ret;
	}
}


