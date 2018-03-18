<?php

function getQuoteMailBody($quotesid) {
    global $owner;
    global $cust_url;
    global $domain;

    $sqltext = "SELECT * FROM quotes,cust	WHERE quotes.custid=cust.custid	AND quotes.quotesid='" . $quotesid . "'	AND quotesid>0 LIMIT 1";

    // print $sqltext;

    $res = $dbsite->query($sqltext); // or die("Cant get quoted");
    if (! empty($res)) {
        $r = $res[0];
    } else {
        return 0;
    }

    $quotedate = date('d-m-Y', $r->incept);

    $r->content = preg_replace("/\r\n/", "<br>", $r->content);
    // $r->content = preg_replace("/\r/", "<br>" , $r->content);

    $int_contact = getStaffName($r->staffid);

    $retHTML = <<< EOHTML	<span style="font-size:170%;">{$owner->co_name}</span><br><br>Please find below your quote from {$owner->co_name}:-<br><br>EOHTML;

    $ext_contact = getCustExtName($r->contactsid);

    $retHTML .= <<< EOHTML	<h2>Quote No: {$r->quoteno}</h2>	To: {$r->co_name}<br>	Date: {$quotedate}<br>	Your Contact at {$owner->co_nick}: {$int_contact}<br>	FAO: $ext_contact<br><br>  <div style="width:600px;">Job Description: {$r->content}</div><br><br>  <table width="600" border="0" align="left" cellpadding="4" cellspacing="4"><tr style="vertical-align: top"><td valign="top">&nbsp;</td><td valign="top"><strong>Quantity</strong></td><td valign="top"><strong>Delivery</strong></td><td valign="top"><strong>Unit Price</strong></td><td valign="top"><strong>Total Price</strong></td></tr>EOHTML;

    $quoteTotal = 0;

    $sqltext = "SELECT * FROM items WHERE items.quotesid='" . $r->quotesid . "'";
    $d = $dbsite->query($sqltext) or die("Cant get quotes");
    if (! empty($d)) {

        foreach ($d as $e) {

            $retHTML .= <<< EOHTML  <tr style="vertical-align: top">    <td valign="top">{$e->content}EOHTML;

            $totalLinePrice = $e->quantity * $e->price;

            $retHTML .= <<< EOHTML	</td>    <td valign="top">{$e->quantity}</td>    <td valign="top">{$e->delivery}</td>    <td valign="top">&pound;{$e->price}</td>    <td valign="top">&pound;$totalLinePrice</td>  </tr>EOHTML;

            $quoteTotal = $quoteTotal + $totalLinePrice;
        }
    }

    $retHTML .= <<< EOHTML</table><br clear="both" /><br><div style="text-align:right;font-size:120%;font-weight:bold;width:600px;margin-right:150px">Quote Total Price: &pound;{$quoteTotal}</div>EOHTML;

    $user = getCustAdminLogin($r->custid);
    $user = $user['name'];
    $pw = $user['passwd'];

    if (isset($user) && isset($pw) && ($user != '') && ($pw != '')) {
        $retHTML .= <<< EOHTML	<br><br>	<h2>{$owner->co_name} Customer Control Panel</h2>You can view all your quotes, and agree to this quote from {$owner->co_name} at our Customer Control Panel.Your login Details are below.<br><br>Web Address - $cust_url/quotes/view.php?id=$quotesid<br>Username: $user<br>Password: $pw<br><br>Please keep these details secure. <br><br>EOHTML;
    }

    $retHTML .= <<< EOHTML  <br clear="both" /><br><br>Best Regards,<br><br>{$owner->co_name}<br><br>-- <br>{$owner->co_name}<br>{$owner->add1},<br>	{$owner->add2} {$owner->add3}<br>	{$owner->city},	{$owner->county}<br>	{$owner->country}	{$owner->postcode}<br>	Tel: {$owner->tel}<br>	Fax: {$owner->fax}<br>	Email: {$owner->email}<br>	Website: {$owner->web}EOHTML;

    return ($retHTML);
}

function getInvoiceMailBody($invoicesid) {
    global $owner;
    global $www_url;

    $sqltext = "SELECT jobs.incept,jobs.jobno,jobs.jobsid,jobs.done,jobs.jobcontent,jobs.notes,jobs.custref,	items.content,items.quantity,items.price,	quotes.quotesid,quotes.content as qcontent,quotes.quoteno,quotes.staffid,quotes.contactsid,	cust.co_name,cust.inv_contact,add1,add2,add3,city,county,postcode,cust.login,cust.pw,	invoiceno,invoices.invoicesid,invoices.incept as invincept	FROM jobs,items,quotes,cust,invoices	WHERE items.itemsid=jobs.itemsid	AND items.quotesid=quotes.quotesid	AND quotes.custid=cust.custid	AND jobs.jobsid=invoices.jobsid	AND invoices.invoicesid=" . $invoicesid;

    $res = $dbsite->query($sqltext); // or die("Cant get quoted");
    if (! empty($res)) {
        $r = $res[0];
    } else {
        return 0;
    }

    $date = date("d/m/Y", $r->invincept);
    $foa = '';
    if (isset($r->inv_contact) && $r->inv_contact != '' && is_numeric($r->inv_contact)) {
        $foa = "<br>FAO: " . getCustExtName($r->inv_contact) . "<br>";
    }

    $jobcontent = stripslashes($r->jobcontent);
    $content = stripslashes($r->content);

    $retHTML .= <<<EOHTML	<div style="text-align:right;">	<img src="$www_url/img/co.logo.png" border="0" width="247" align="left"><br><br>	{$owner->co_name}<br>{$owner->add1},<br>	{$owner->add2} {$owner->add3}<br>	{$owner->city},	{$owner->county}<br>	{$owner->country}	{$owner->postcode}<br>	Tel: {$owner->tel}<br>	Fax: {$owner->fax}<br>	Email: {$owner->email}<br>	Website: {$owner->web}</div>	<br clear="all"><h1>	SALES INVOICE</h1>	<div style="float:right;text-align:right;">		<table cellpadding=4>		<tr>			<td align=right>Invoice No:</td><td>{$r->invoiceno}</td>		</tr>		<tr>			<td align=right>Date:</td><td>$date</td>		</tr>		<tr>			<td align=right>Your Ref:</td><td>{$r->custref}</td>		</tr>		<tr>			<td align=right>{$owner->co_nick} Job No:</td><td>{$r->jobno}</td>		</tr>		<tr>			<td align=right>VAT Reg No:</td><td>{$owner->vat_no}</td>		</tr>		</table>	</div>Invoice TO:- {$r->co_name}<br>	{$r->add1}<br>	{$r->add2}<br>	{$r->add3}<br>	{$r->city}<br>	{$r->county}<br>	{$r->postcode}<br>	$foa	<br clear="all">	<span style="font-size:80%;font-weight:bold;">Work Completed</span><br>	<span style="font-weight:bold;">$jobcontent</span><br><br><table  border="0" cellpadding="4" cellspacing="4" width="90%">  <tr style="font-size:80%;font-weight:bold;"><td valign="top">Details</td><td valign="top">Item Price</td><td valign="top">Quantity</td></tr>  <tr>  <td valign="top">$content</td><td valign="top">&pound;{$r->price}</td><td valign="top">X {$r->quantity}</td>  </tr>EOHTML;

    $total = $r->quantity * $r->price;
    $total = money_format('%i', $total);

    $vat_rate = getVAT_Rate($r->invincept);
    $vat_rateText = getVatText($vat_rate);

    $vat = money_format('%i', round($total * $vat_rate, 2));
    $totalprice = money_format('%i', $total + $vat);

    $retHTML .= <<<EOHTML</table><br><br>	<div style="float:right;width:350px;text-align:right;font-weight:bold;padding-right:40px;">    Price &pound;$total<br>	VAT @ $vat_rateText		= &pound;$vat<br>	<h3>Amount Due &pound;$totalprice</h3><br>	</div>	<br clear="all">EOHTML;

    $retHTML .= <<< EOHTML  <br clear="both" />Best Regards,<br><br>{$owner->co_name}<br><br>EOHTML;

    return ($retHTML);
}

function getOrderMailBody($ordersid) {
    global $owner;
    global $www_url;
    global $supp_url;
    global $domain;

    $sqltext = "SELECT * FROM orders,supp	WHERE orders.suppid=supp.suppid	AND orders.ordersid=" . $ordersid;

    $res = $dbsite->query($sqltext); // or die("Cant get order");
    if (! empty($res)) {
        $r = $res[0];
    } else {
        return 0;
    }

    $date = date("d/m/Y", $r->incept);
    $foa = '';

    $content = stripslashes($r->content);

    $retHTML = <<<EOHTML	<div style="text-align:right;">	<img src="$www_url/img/co.logo.png" border="0" width="247" align="left"><br><br>	{$owner->co_name}<br>{$owner->add1},<br>	{$owner->add2} {$owner->add3}<br>	{$owner->city},	{$owner->county}<br>	{$owner->country}	{$owner->postcode}<br>	Tel: {$owner->tel}<br>	Fax: {$owner->fax}<br>	Email: {$owner->email}<br>	Website: {$owner->web}</div>	<br clear="all"><h1>	Invitation to Quote</h1>	<div style="float:right;text-align:right;padding:10px;">		<table cellpadding=4>		<tr>			<td align=right>Order No:</td><td>$ordersid</td>		</tr>		<tr>			<td align=right>Date:</td><td>$date</td>		</tr>		<tr>			<td align=right>{$owner->co_nick} Job No:</td><td>{$r->jobno}</td>		</tr>		<tr>			<td align=right>VAT Reg No:</td><td>114 6698 58</td>		</tr>		</table>	</div>Invitation to:-<br>{$r->co_name}<br>{$r->add1}      {$r->add2}      {$r->add3}<br>{$r->city}      {$r->county}    {$r->postcode}$foa	<br clear="all">	<span style="font-size:90%;font-weight:bold;">Please quote on the following items:-</span><br><table  border="0" cellpadding="4" cellspacing="4" width="440">  <tr style="font-size:80%;font-weight:bold;">  <td valign="top">Description</td>  <td valign="top">Quantity</td>  </tr>  <tr style="font-size:120%;">  <td valign="top">$content</td>  <td valign="top">X {$r->quantity}</td>  </tr></table><br><br>EOHTML;

    $user = getSuppAdminLogin($r->suppid);
    $user = $user['name'];
    $pw = $user['passwd'];

    if (isset($user) && isset($pw) && ($user != '') && ($pw != '')) {

        $retHTML .= <<< EOHTML	<h2>{$owner->co_name} Suppliers Web Site</h2>	You can submit your quote through the {$owner->co_name} Suppliers Web Site. <br>	Use the following link to log into your own private area and submit your quote right now.<br><br>	Address: <a href="$supp_url">$supp_url</a><br>	Username: $user<br>Password: $pw<br><br>		<br>EOHTML;
    }

    $retHTML .= <<< EOHTML<br clear="all"><br clear="both" />Best Regards,<br><br>{$owner->co_name}<br><br>EOHTML;

    return ($retHTML);
}

function getPurchaseOrderMailBody($ordersid) {
    global $owner;
    global $www_url;

    $sqltext = "SELECT * FROM orders,supp	WHERE orders.suppid=supp.suppid	AND orders.ordersid=" . $ordersid;

    $res = $dbsite->query($sqltext); // or die("Cant get order");
    if (! empty($res)) {
        $r = $res[0];
    } else {
        return 0;
    }

    $date = date("d/m/Y", $r->incept);
    $dateok = date("d/m/Y", $r->dateok);
    $priceok = '&pound; ' . $r->priceok;
    $foa = '';

    $content = stripslashes($r->content);

    $retHTML = <<<EOHTML	<div style="text-align:right;"><img src="$www_url/img/co.logo.png" border="0" width="247" align="left"><br><br>{$owner->co_name} Company Limited<br>{$owner->add1},<br>	{$owner->add2} {$owner->add3}<br>	{$owner->city},	{$owner->county}<br>	{$owner->country}	{$owner->postcode}<br>	Tel: {$owner->tel}<br>	Fax: {$owner->fax}<br>	Email: {$owner->email}<br>	Website: {$owner->web}</div>	<br clear="all"><h1>Purchase Order</h1><div style="float:right;text-align:right;padding:10px;"><table cellpadding=4><tr><td align=right>Order No:</td><td>$ordersid</td></tr><tr><td align=right>Date:</td><td>$date</td></tr><tr><td align=right>{$owner->co_nick} Job No:</td><td>{$r->jobno}</td></tr><tr><td align=right>VAT Reg No:</td><td>114 6698 58</td></tr></table></div>To:-<br>{$r->co_name}<br>{$r->add1}      {$r->add2}      {$r->add3}<br>{$r->city}      {$r->county}    {$r->postcode}$foa<br clear="all"><span style="font-size:90%;font-weight:bold;">Please supply the following items as agreed:-</span><br><table  border="0" cellpadding="4" cellspacing="4" width="440"><tr style="font-size:80%;font-weight:bold;"><td valign="top">Description</td><td valign="top">Quantity</td></tr><tr style="font-size:120%;"><td valign="top">$content</td><td valign="top">X {$r->quantity}</td></tr></table><p>Date Agreed: $dateok</p><p>Price Agreed: $priceok</p><br clear="all"><br clear="both" />Best Regards,<br><br>{$owner->co_name}<br><br><br><br>EOHTML;

    return ($retHTML);
}

function sendCustAccessMail($custid) {
    global $owner;

    global $cust_url;
    global $domain;

    $sqltext = "SELECT co_name,email,logon,pw FROM cust WHERE custid=" . $custid;
    $res = $dbsite->query($sqltext); // or die("Cant get customers details");
    if (! empty($res)) {
        $r = $res[0];

        $user = $r->logon;
        $pw = $r->pw;

        if (isset($user) && isset($pw) && ($user != '') && ($pw != '')) {
            $htmlBody = <<<EOHTML	<div style="text-align:right;">	<img src="http://www.$domain/img/co.logo.png" border="0" width="247" align="left"><br><br>{$owner->co_name}<br>{$owner->add1},<br>	{$owner->add2} {$owner->add3}<br>	{$owner->city},	{$owner->county}<br>	{$owner->country}	{$owner->postcode}<br>	Tel: {$owner->tel}<br>	Fax: {$owner->fax}<br>	Email: {$owner->email}<br>	Website: {$owner->web}</div><br clear="all"><h2>Customer Control Panel Access Details</h2>Your Access Details for the {$owner->co_name} Customer Control Panel are below.<br><br>Web Address - http://www.$domain/login<br>Username: $user<br>Password: $pw<br><br>Please keep these details secure. <br><br>Many thanks<br><br>{$owner->co_name}<br><br>EOHTML;

            sendGmailEmail($r->co_name, $r->email, $owner->co_name . ' Control Panel Access', $htmlBody);

            $ret = 'Sent mail to ' . $r->co_name . ',' . $r->email;
            return $ret;
        } else {
            $ret = 'Mail not sent - Customer not known';
            return $ret;
        }
    } else {
        $ret = 'Mail not sent - Customer not known';
        return $ret;
    }
}

function sendSuppAccessMail($suppid) {
    global $owner;

    global $www_url;
    global $supp_url;
    global $domain;

    $sqltext = "SELECT co_name,email,logon,pw FROM supp WHERE suppid=" . $suppid;
    $res = $dbsite->query($sqltext); // or die("Cant get suppliers details");
    if (! empty($res)) {
        $r = $res[0];

        $user = $r->logon;
        $pw = $r->pw;

        $htmlBody = <<<EOHTML	<div style="text-align:right;">	<img src="$www_url/img/co.logo.png" border="0" width="247" align="left"><br><br>	{$owner->co_name}<br>	{$owner->add1},<br>	{$owner->add2} {$owner->add3}<br>	{$owner->city},	{$owner->county}<br>	{$owner->country}	{$owner->postcode}<br>	Tel: {$owner->tel}<br>	Fax: {$owner->fax}<br>	Email: {$owner->email}<br>	Website: {$owner->web}</div><br clear="all"><h2>Suppliers Control Panel Access Details</h2>Your Access Details for the {$owner->co_name} Suppliers Control Panel are below.<br><br>Web Address - http://www.$domain/login<br>Username: $user<br>Password: $pw<br><br>Please keep these details secure. <br><br>Many thanks<br><br>{$owner->co_name}<br><br>EOHTML;

        sendGmailEmail($r->co_name, $r->email, $owner->co_name . ' Control Panel Access', $htmlBody);

        $ret = 'Sent mail to ' . $r->co_name . ',' . $r->email;
        return $ret;
    } else {
        $ret = 'Mail not sent - Customer not known';
        return $ret;
    }
}
