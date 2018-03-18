<?php

function getQuoteRowHTML($r) {
	global $dbsite;
	global $sitesid;
	global $domain;
	global $siteMods;

	$custid = $r->custid;
	$weblink = 'customers.' . $domain;

	$startDate = date('d-m-Y', $r->incept);
	$quoteno = $r->quoteno;
	$quotesid = $r->quotesid;
	$co_name = $r->co_name;
	$liveq = $r->live;
	$colour = $r->colour;
	if ((! isset($colour)) || ($colour == '') || ($colour == '#FFFFFF')) {
		$colour = '#2c0673';
	}
	$sent = $r->sent;

	// $ext_contact = (isset($r->contactsid)) ? getCustExtName($r->contactsid) : '';

	$sqltext = "SELECT qitems.content,qitems.hours,qitems.rate,qitems.price,
	qitems.quantity,qitems.itemno,qitems.agreed,
	quotes.quotesid,quotes.incept,
	cust.co_name
	FROM qitems,cust,quotes
	WHERE qitems.quotesid=quotes.quotesid
	AND quotes.custid=cust.custid
	AND quoteno='" . $r->quoteno . "'";
	// print "<br>$sqltext";
	$resR = $dbsite->query($sqltext); // or die("Cant get items");
	if (! empty($resR)) {

		$priceOK = 1;
		$agreed = 0;
		$cnt = 0;
		$itemHTML = '';
		$firstitemHTML = '';
		foreach ($resR as $rr) {

			if ($rr->agreed) {
				$agreed++;
			}
			if (! $rr->price) {
				$priceOK = 0;
			}
			if ($cnt > 0) {
				$itemHTML .= getItemRowMiniHTML($rr);
			} else {
				$firstitemHTML .= getItemRowMiniHTML($rr);
			}
			$cnt ++;
		}
	}

	$rand = rand();

	$statusHTML = '';

	if ($siteMods['custport']) {
		$statusHTML = '<br><a href="/quotes/status?id=' . $quotesid .
		 '" title="click here to change a quotes Status">Status:</a>';
		if (($r->origin == 'ext') && (! $priceOK)) {
			$statusHTML = '<span style="color:red;">New from Customer Portal!!!</span>';
		}
		if (($r->origin == 'ext') && ($priceOK) && (! $agreed)) {
			$statusHTML = 'Awaiting Customer Approval';
		}
		if (($r->origin == 'int') && ($priceOK) && (! $agreed)) {
			$statusHTML = 'Awaiting Customer Approval';
		}
		if ($agreed) {
			$statusHTML = '<span style="color:red;">Quote Agreed</span>';
		}

		if (($liveq) || ($r->origin == 'ext')) {
			$statusHTML .= ' - <span style="color:green;">Live and viewable by Customer</span>';
		} else {
			$statusHTML .= ' - <span style="color:#830682;">Not Live (hidden from Customer)</span>';
		}
	}

	$retHTML = <<<EOF
	<div class="panel panel-default">
            <div class="panel-heading">
            <div style="width:10px;background-color:$colour;float:left;margin-right:5px;">&nbsp;</div>
              <h3 class="panel-title">Quote No: $quoteno - For $co_name - $startDate</h3>

            </div>
            <div class="panel-body">
<i class="fa fa-search"></i>
            <a href="/quotes/view?id=$quotesid">View</a>
 |
<i class="fa fa-pencil-square-o"></i>
 <a href="/quotes/edit?id=$quotesid">Edit</a>
 |

<i class="fa fa-file-pdf-o"></i>

<a href="/bin/make_pdf_quote.pl?id={$r->quotesid}&sitesid=$sitesid"
	title="Download PDF">Download PDF</a>

EOF;

	if (isset($siteMods['custport'])) {
		$purl = base64_encode ( '/quotes/view?id=' . $r->quotesid );

		$retHTML .= <<<EOF
 |
	<i class="fa fa-desktop"></i>
 <a
	href="/loginas?cid={$r->custid}&sitesid=$sitesid&passurl=$purl"
	target="_blank" title="Log In As this Customer">Customer's View</a>
EOF;
	}

	$murl = base64_encode("/mail/quote.php?id=" . $quotesid);
	if($sent>0){
		$sent = 'Sent '.date('H:i d/m/Y',$sent);
		$retHTML .= '| <i class="fa fa-envelope" title="'.$sent.'"></i>';
	}else{
		$sent = '';
		$retHTML .= '| <i class="fa fa-envelope-o" title="Not sent yet"></i>';
	}


	$retHTML .= <<<EOF
<form action="/mail/send_owl" method="post"
	enctype="multipart/form-data" style="display: inline;"
	name="emailtocust">
	<a href="javascript:void(0);" onclick="parentNode.submit();">
	Email to Customer
	</a>
	<input type="hidden" name=url value="$murl">
</form>
<br> $statusHTML
EOF;

	if ($firstitemHTML != '') {
		$itemsMore = $cnt;
		$retHTML .= <<<EOF
<br><span id=fb$rand>
<a href="javascript:void(0);" onclick="showHide('$rand')">
<i class="fa fa-level-down"></i>
Show Items ($itemsMore) ... </a></span>
EOF;
	}

	$retHTML .= <<<EOF
           <div id=$rand style="display:none">
<span style="color:#aaa;">Quoted Items:</span><br>
	$firstitemHTML
	$itemHTML</div>

            </div>
          </div>
EOF;

	// | <a href="/jobs/add.php?quoteid=$quotesid">Create Job</a>
	return $retHTML;
}

function getCostMiniRowHTML($r) {
	global $seclevel;

	$startDate = date('d-m-Y', $r->incept);
	$costsid = $r->costsid;
	$expsid = $r->expsid;
	$name = $r->name;
	$supplier = $r->supplier;
	$amount = $r->price;
	$description = $r->description;

	$from = '';
	if ((isset($r->supplier)) && ($r->supplier != '')) {
		$from = 'Supplied by: ' . $r->supplier;
	}

	$retHTML = <<<EOF
<div class="panel panel-default">

<div class="panel-heading">
<h3 class="panel-title">Cost No: $costsid - $startDate | Supplier: $supplier | &pound;$amount</h3>
</div>
<div class="panel-body">
<i class="fa fa-pencil-square-o"></i>
<a href="/costs/edit.php?id=$costsid" title="Edit this cost">Edit</a>  |
Type: $name<br>
$description
</div>

</div>
EOF;

	return $retHTML;
}

function getItemRowHTML($r) {
	$itemsid = $r->itemsid;
	$content = substr($r->content, 0, 40);
	$delivery = $r->delivery;
	$price = $r->price;
	$quotesid = $r->quotesid;
	$quoteno = $r->quoteno;
	$co_name = getCustName($r->custid);

	$retHTML = <<<EOF
<li>
<div >
<div style="float:left;width:90%;padding:4px;">
<span id=actions>
  <a href="/jobs/add.php?id=$itemsid">Create Job</a>
</span>
From Quote No: <a href="/quotes/view.php?id=$quotesid" title="View this Quote"><strong>$quoteno</strong></a><br>
<strong> For $co_name</strong><br>
<span style="font-size:80%;">$content...<br></span>


</div><br clear=all>
</div>
</li>
EOF;

	return $retHTML;
}

function getItemRowMiniHTML($r) {

	// items.itemsid,items.content,items.price,jobs.jobno,jobs.incept,jobs.jobsid,cust.co_name
	$startDate = date("d-m-Y", $r->incept);
	if (isset($r->jobno)) {
		$jobno = $r->jobno;
	} else {
		$jobno = '';
	}
	if (isset($r->jobsid)) {
		$jobsid = $r->jobsid;
	} else {
		$jobno = '';
	}

	// $itemsid = $r->itemsid;
	$content = stripslashes($r->content);
	// $delivery = $r->delivery;

	$itemNo = $r->itemno;
	$retHTML = <<<EOF
	<div style="border:1px solid #ccc;padding:4px;margin:4px;">
EOF;
	if((isset($r->hours))&&($r->hours>0)){

		$lineprice = $r->hours * $r->rate;
		$retHTML .= <<<EOF
		Item No: $itemNo<br>
		<span style="color:#aaa;">Description: $content</span><br>
		    $r->hours Hours @ &pound;$r->rate = &pound;$lineprice
EOF;
	}else{
		$quantity = $r->quantity;
		$price = $r->price;
		$lineprice = $quantity * $price;
		$retHTML .= <<<EOF
		Item No: $itemNo<br>
		<span style="color:#666;">Description: $content</span><br>
		$quantity @ &pound;$price = &pound;$lineprice
EOF;
	}

	$retHTML .= <<<EOF
	</div>
EOF;


	return $retHTML;
}

function getJobItemsRowMiniHTML($r) {
	global $dbsite;

	// items.itemsid,items.content,items.price,jobs.jobno,jobs.incept,jobs.jobsid,cust.co_name

	if (isset($r->jobno)) {
		$jobno = $r->jobno;
	} else {
		$jobno = '';
	}
	if (isset($r->jobsid)) {
		$jobsid = $r->jobsid;
	} else {
		$jobno = '';
	}

	$itemsid = $r->itemsid;
	$content = stripslashes($r->content);

	$retHTML = <<<EOF
		<span >$content  </span>

EOF;

	return $retHTML;
}

function getJobRowHTML($r) {
	global $dbsite;
	global $sitesid;
	global $owner;

	$startDate = date('d-m-Y', $r->incept);
	$jobno = $r->jobno;
	$jobsid = $r->jobsid;
	$co_name = $r->co_name;
	$colour = $r->colour;
	$invoicesid = $r->invoicesid;
	// $stageName = getStageName($r->stagesid);

	$sqltext = "SELECT items.itemsid,items.content,
	items.price,jobs.incept
	FROM items,jobs
	WHERE items.itemsid=jobs.itemsid
	AND jobno='" . $r->jobno . "'";

	$res = $dbsite->query($sqltext); // or die("Cant get items");
	if (! empty($res)) {

		$itemHTML = '';
		foreach ($res as $rr) {
			$rr = $res[0];

			$itemHTML .= getJobItemsRowMiniHTML($rr);
		}
	}

	$rand = rand();

	// $jobWith = getJobWith($jobsid);
	$startDate = date("d-m-Y", $r->incept);

	$retHTML = <<<EOF

	<div class="panel panel-default">
            <div class="panel-heading">
            <div style="width:10px;background-color:$colour;float:left;margin-right:5px;">&nbsp;</div>
              <h3 class="panel-title">Job No: $jobno For $co_name - $startDate</h3>
            </div>
            <div class="panel-body">

<i class="fa fa-search"></i>	<a href="/jobs/view.php?id=$jobsid">View Job</a>
	 |<i class="fa fa-pencil-square-o"></i>
  <a href="/jobs/edit.php?id=$jobsid">Edit</a>

EOF;

	if ($r->done) {
		$status = 'Finished:' . date('d/m/Y', $r->done);
	} else {
		$status = '<a href="/jobs/finish.php?id=' . $jobsid . '">Mark Finished</a>';
	}

	$sqltext3 = "SELECT invoices.incept
	FROM invoices,jobs
	WHERE invoices.invoicesid=jobs.invoicesid
	AND jobsid='" . $r->jobsid . "'";

	$res3 = $dbsite->query($sqltext3); // or die("Cant get invoices.incept");

	if (! empty($res3)) {
		$r3 = $res3[0];
		if ((isset($r3->incept)) && ($r3->incept > 0)) {
			$status .= ' | Invoiced: ' . date('d/m/Y', $r3->incept);
		}
	}

	$retHTML .= <<<EOF
	| $status

	<br clear=all>
<p>$itemHTML</p>

	</div>
</div>

EOF;

	return $retHTML;
}

function getInvoiceRowHTML($r) {
	global $dataDir;
	global $owner;
	global $sitesid;
	global $from;

	$co_name = $r->co_name;
	$invoicesid = $r->invoicesid;
	$invoiceno = $r->invoiceno;
	$date = date("d/m/Y", $r->incept);
	$colour = $r->colour;
	$sent = $r->sent;

	$paidLink = "<a href=\"/invoices/?from=$from&go=y&id=$invoicesid\" title=\"Mark as Paid\">Mark as Paid</a>";
	$nonpaidLink = "<a href=\"/invoices/?from=$from&go=undopaid&id=$invoicesid\" title=\"Mark as Not Paid\"> Undo</a>";

	$paid = ($r->paid > 0) ? "Paid: " . date("d-m-Y", $r->paid) . $nonpaidLink : $paidLink;

	$emailurl = base64_encode("/mail/invoice?id=" . $r->invoicesid);

	$retHTML = <<<EOF


	<div class="panel panel-default">
   <div class="panel-heading">
        <div style="width:10px;background-color:$colour;float:left;margin-right:5px;">&nbsp;</div>

        <h3 class="panel-title">Invoice No: $invoiceno</a> For: $co_name</strong> - $date


        $co_name</h3>
    </div>
    <div class="panel-body">

   <i class="fa fa-search"></i>
<a href="/invoices/view?id=$invoicesid" title="View the Invoice">View</a>

|
    <i class="fa fa-pencil-square-o"></i>

		<a href="/invoices/edit?id=$invoicesid" title="Edit the Invoice">Edit</a>

		 | <i class="fa fa-file-pdf-o"></i>
		 <a	href="/bin/make_pdf_invoice.pl?id=$invoicesid&sid=$sitesid"
	title="Download PDF"> Download PDF </a>  |
	<i class="fa fa-money"></i>  $paid

 | <i class="fa fa-file-pdf-o"></i>
		 <a	href="/bin/make_pdf_delnote.pl?id=$invoicesid&sid=$sitesid"
	title="Download Delivery Note"> Delivery Note </a> 
EOF;


if($sent>0){
	$sent = 'Sent '.date('H:i d/m/Y',$sent);
	$retHTML .= '| <i class="fa fa-envelope" title="'.$sent.'"></i>';
}else{
	$sent = '';
	$retHTML .= '| <i class="fa fa-envelope-o" title="Not sent yet"></i>';
}


$retHTML .= <<<EOF


	<form action="/mail/send_owl" method="post"
		enctype="multipart/form-data" style="display: inline;">
		<a href="javascript:void(0);" onclick="parentNode.submit();">Email
			to Customer
		</a> <input type="hidden" name=url value="$emailurl">
	</form>


    </div>
</div>


EOF;

	return $retHTML;
}

function getDiaryMiniRowHTML($r) {
	$diaryid = $r->diaryid;
	$done = $r->done;
	$title = stripslashes($r->title);
	$content = stripslashes(htmlentities($r->content));
	$staffName = getStaffName($r->staffid);

	$retHTML .= <<<EOF
<div style="font-size:80%;border:1px solid #999;">
<a href="/diary/view.php?id=$diaryid" title="View Diary Item"><strong>$staffName</strong> $title</a>
</div>
EOF;

	return $retHTML;
}

function getDiaryDayHTML($day, $staffid = 0) {
	global $dbsite;
	global $sitesid;
	$totime = mktime(- 1, 0, 0, date("m", $day), date("d", $day) + 1, date("Y", $day));

	$sqltext = "SELECT * FROM diary
	WHERE incept>=$day
	AND incept<$totime
	AND every IS NULL";
	// print $sqltextq . '<br>';
	// if($staffid>99999999999999999999999999){
	// $sqltext .= " AND staffid=" . $staffid;
	// }
	$sqltext .= " ORDER BY incept";
	$resDiary = $dbsite->query($sqltext); // or die("Cant get diary details");

	$retHTML = <<<EOF
	<li id=diaryday>
EOF;

	$retHTML .= date("l d/m", $day);

	$now = mktime(0, 0, 0, date("m"), date("d"), date("Y"));

	if ($day >= $now) {
		$retHTML .= <<<EOF
	<a href="/diary/add.php?incept=$day">Add</a>
EOF;
	}

	if (! empty($resDiary)) {
		foreach ($resDiary as $rDiary) {
			$retHTML .= getDiaryMiniRowHTML($rDiary);
		}
	}

	$retHTML .= <<<EOF
	</li>
EOF;
	if (date("l", $day) == 'Sunday') {
		$retHTML .= <<<EOF
	<br clear=all />
EOF;
	}
	return $retHTML;
}

function getBlankDiaryDayHTML($day) {
	$retHTML = <<<EOF
	<li id=diarydayblank>&nbsp;</li>
EOF;

	if (date("l", $day) == 'Sunday') {
		$retHTML .= <<<EOF
	<br clear=all />
EOF;
	}
	return $retHTML;
}

function getContactRowHTML($r) {
	global $domain;

	$fname = $r->fname;
	$sname = $r->sname;
	$tel = $r->tel;
	$mob = $r->mob;
	$email = $r->email;
	$contactsid = $r->contactsid;
	$colour = '';

	$contactString = '';

	if ($r->custid) {
		$co_name = 'Customer: ' . getCustName($r->custid);
		$colour = getCustColour($r->custid);
	} elseif ($r->suppid) {
		$co_name = 'Supplier: ' . getSuppName($r->suppid);
	} else {}

	// if($fname != '') $contactString .= ' | Name: ' . $fname . ' ' . $sname;
	if ($co_name != '')
		$contactString .= $co_name;
	if ($email != '')
		$contactString .= ' | <a href="mailto:' . $email . '">' . $email . "</a>";
	if ($tel != '')
		$contactString .= " | Tel: " . $tel;
	$mob = preg_replace("/\s/", '', $mob);
	if ($mob != '')
		$contactString .= " | Mobile: " . $mob; // . " | <a href=\"/sms/add.php?no=" . $mob . "\">Send SMS</a>";

	$retHTML = <<<EOF


	<div class="panel panel-default">
   <div class="panel-heading">
        <div style="width:10px;background-color:$colour;float:left;margin-right:5px;">&nbsp;</div>
        <h3 class="panel-title">$fname $sname</h3>
    </div>
    <div class="panel-body">
        $contactString

        <i class="fa fa-pencil-square-o"></i>
 	<a href="/contacts/edit.php?id=$contactsid" title="Edit contact">Edit</a>

        </div>
</div>


EOF;

	return $retHTML;
}

function getJobMiniRowHTML($r) {
	global $seclevel;

	$startDate = date('d-m-Y', $r->incept);
	$jobno = $r->jobno;
	$jobsid = $r->jobsid;
	$co_name = $r->co_name;
	$colour = $r->colour;
	$quotesid = $r->quotesid;
	$stageName = getStageName($r->stagesid);

	$rand = rand();
	$content = stripslashes($r->content);

	// $jobWith = getJobWith($jobsid);

	$retHTML = <<<EOF
<li>
<div >
<div style="float:left;width:390px;"><div style="width:10px;background-color:$colour;float:left;margin-right:5px;">&nbsp;</div>
<a href="/jobs/view.php?id=$jobsid" title="Edit this Job"><strong>$jobno</strong></a> for $co_name
</div>
<span id=actions>
<a href="/jobs/view.php?id=$jobsid">View Job</a>
 | <a href="/jobs/edit.php?id=$jobsid">Edit</a>
</span>
<br clear=all>

</div>
</li>

EOF;

	return $retHTML;
}

function getQuoteMiniRowHTML($r) {
	global $dbsite;
	global $seclevel;
	global $sitesid;

	$sqltext = "SELECT items.price
	FROM items,quotes,cust
	WHERE items.quotesid=quotes.quotesid
	AND quotes.custid=cust.custid
	AND quoteno='" . $r->quoteno . "'";
	$res = $dbsite->query($sqltext); // or die("Cant get items");
	if (! empty($res)) {

		$priceOK = 1;
		$cnt = 0;
		$itemHTML = '';
		$firstitemHTML = '';
		foreach ($res as $rr) {
			$rr = $res[0];
			if (! $rr['price']) {
				$priceOK = 0;
			}
		}
	}

	$startDate = date('d-m-Y', $r->incept);
	$quoteno = $r->quoteno;
	$quotesid = $r->quotesid;
	$co_name = $r->co_name;
	$colour = $r->colour;
	$ext_contact = (isset($r->contactsid)) ? getCustExtName($r->contactsid) : '';

	$rand = rand();

	$content = stripslashes($r->content);
	$statusHTML = '';
	if (($r->origin == 'ext') && (! $priceOK)) {
		$statusHTML = '<br>Quote Status: <span style="color:red;">New from Customer Portal!!!</span>';
	}
	if (($r->origin == 'ext') && ($priceOK) && (! $r->agree)) {
		$statusHTML = '<br>Quote Status: Awaiting Customer Approval';
	}
	if (($r->origin == 'int') && ($priceOK) && (! $r->agree)) {
		$statusHTML = '<br>Quote Status: Awaiting Customer Approval';
	}
	if ($r->agree) {
		$statusHTML = '<br><span style="color:green;font-size:100%;">Quote Agreed</span>';
	}

	$retHTML = <<<EOF
<li>

<div >
<div style="float:left;"><div style="width:10px;background-color:$colour;float:left;margin-right:5px;">&nbsp;</div>
<a href="/quotes/view.php?id=$quotesid" title="View this Quote"><strong>$quoteno</strong></a>
<span style="font-size:90%;">$co_name - ($ext_contact)</span>
$statusHTML
</div>

EOF;

	if ($seclevel < 6) {
		$retHTML .= <<<EOF
<span id=actions>
<a href="/quotes/view.php?id=$quotesid">View</a>
 | <a href="/quotes/print.php?id=$quotesid">Print</a>
EOF;

		if ($seclevel < 2) {
			$retHTML .= <<<EOF
 | <a href="/quotes/edit.php?id=$quotesid">Edit</a>
EOF;
		}
		$retHTML .= '</span>';
	}

	$retHTML .= <<<EOF

<br clear=all>

</div>
</li>
EOF;

	return $retHTML;
}

function getRequestQuoteRowHTML($r) {
	global $domain;
	global $dbsite;
	global $sitesid;

	$suppid = $r->suppid;

	$weblink = 'suppliers.' . $domain;

	$startDate = date('d-m-Y', $r->incept);
	$ordersid = $r->ordersid;
	$content = stripslashes($r->content);

	$retHTML .= <<<EOF
<li>
<div >

<strong>Quote Request No: $ordersid</strong>

EOF;

	$retHTML .= <<<EOF
<span id=actions>
<a href="/orders/send?id=$ordersid" title="Add Suppliers">Add Suppliers</a>
</span>
EOF;

	// |<a href="/orders/view.php?id=$ordersid" title="View this Quote">View Quote Request</a>

	$retHTML .= <<<EOF

Date: $startDate
<br clear=all>
Quote for:- $content

EOF;

	$sqltext = "SELECT * FROM order_req WHERE orderid=$ordersid ORDER BY order_reqid";
	$qq = $dbsite->query($sqltext) or die("Cant get order req supp");
	if ($qq->num_rows > 0) {

		$retHTML .= "<br><span style='color:#666;font-size:90%'>Sent to - </span>";

		foreach ($qq as $rr) {
			$suppid = $rr['suppid'];
			$suppname = getSuppName($suppid);

			$statusHTML = '';
			if ($rr['mailed']) {
				$statusHTML .= ' <span style="color:green;">Email Sent</a></span> |	';
			} else {
				$statusHTML .= ' <span style="color:#666;">Email Not Sent</a></span> |	';
			}
			if ($rr['agree']) {
				$statusHTML .= '<span style="color:green;">Quote Agreed</a></span>';
			} else {

				if ($rr['priceoff'] < 0.0001) {
					$statusHTML .= '<span style="color:#830682;">Awaiting Quotation</a></span>';
				}
				if ($rr['priceoff'] > 0.0001) {
					$statusHTML .= '<span style="color:red;">Quotation Submitted</a></span>  |	';
					$statusHTML .= '<a href="/orders/view_offer?id=' . $ordersid . '&suppid=' . $suppid . '" title="View Offer">View Offer</a>';
				}
			}

			$purl = base64_encode("/quotes/view.php?id=" . $ordersid);

			$retHTML .= <<<EOF
<div style="border:1px solid #aaa;margin:4px;padding:4px;background-color:#eee;font-size:90%;">
<span id=actions>
EOF;
			if ($rr['agree']) {
				$retHTML .= <<<EOF
<a href="/orders/print.po?id=$ordersid&suppid=$suppid" title="Print Purchase Order">Print Purchase Order</a> |
EOF;
			} else {
				$retHTML .= <<<EOF
<a href="/orders/print?id=$ordersid&suppid=$suppid" title="Print Quote Request">Print Quote Request</a> |
EOF;
			}
			$retHTML .= <<<EOF
<i class="fa fa-desktop"></i>
 <a href="/loginas.php?sid=$suppid&sitesid=$sitesid&passurl=$purl" target="_blank" title="Supplier's View">Supplier's View</a>
</span>

<span style="font-size:110%;">$suppname</span>
<br>
<span style="color: #999;">Order Status:</span>  $statusHTML

			<br clear=all>

		</div>
EOF;
		}
	}
	$retHTML .= <<<EOF
		</span>
</li>
EOF;

	return $retHTML;
}

function getInvoiceMiniRowHTML($r) {
	global $seclevel;

	$co_name = $r->co_name;
	$invoicesid = $r->invoicesid;
	$invoiceno = $r->invoiceno;
	$date = date("d/m/Y", $r->incept);
	$colour = $r->colour;

	$retHTML = <<<EOF
<li>

<div >
<div style="float:left;">

<div style="width:10px;background-color:$colour;float:left;margin-right:5px;">&nbsp;</div>

<strong><a href="/invoices/print.php?id=$invoicesid" title="View and print full the Invoice">Invoice No: $invoiceno</a></strong> - $date for $co_name

</div>

<span id=actions>
<a href="/invoices/print.php?id=$invoicesid" title="View and print full the Invoice">View/Print</a>
</span>

<br clear=all>
</div>
</li>
EOF;

	return $retHTML;
}

function getSiteLogMiniRowHTML($r) {
	global $seclevel;

	$incept = date('d-m-Y h:i A', $r->incept);
	$staffName = getStaffName($r->staffid);

	$retHTML = <<<EOF

	<li>

<div >
<div style="width:150px;float:left;font-size:90%;">$incept</div>
<div style="width:100px;float:left;font-size:90%;"> $staffName</div>
<div style="width:200px;float:left;font-size:90%;"> {$r->name} </div>
<br clear=all>
</div>

</li>
EOF;

	return $retHTML;
}

function getOrdersRowHTML($r) {
	$co_name = $r->co_name;
	$ordersid = $r->ordersid;
	$orderno = $r->orderno;
	$date = date("d/m/Y", $r->incept);
	$colour = $r->colour;

	$retHTML .= <<<EOF

		<li>

<div >
<div style="border:1px #ccc solid;padding:6px;font-size:90%;">
<div style="float:left;width:460px;">
<div style="width:10px;background-color:$colour;float:left;margin-right:5px;">&nbsp;</div>

<strong><a href="/orders/print.php?id=$ordersid" title="View and print full the Invoice">Order No: $orderno</a></strong> - $date for $co_name

</div>
<span style="float:right;font-size:90%;width:360px;text-align:right;">
			<a href="/orders/print.php?id=$ordersid" title="View and print full the Invoice">View/Print</a>	 |
			<a href="javascript:void(0);" onclick="openInvoiceMail('$ordersid')" title="Email this Invoice to the Customer">Email to Customer</a>
			</span>

<br clear=all>
</div>
		</li>
EOF;

	return $retHTML;
}

function getInvoiceableJobs($custid, $post) {
	global $dbsite;

	$now = time();

	// items.dateok<$now AND

	$query = "SELECT items.itemsid, items.content,jobs.done,jobs.jobno,jobs.jobsid
	FROM items,jobs
	WHERE jobs.itemsid=items.itemsid
	AND (jobs.invoicesid IS NULL OR jobs.invoicesid=0)
	AND jobs.custid=$custid
	ORDER BY items.incept DESC";
	// print $query;

	$retHTML = <<<EOF
	<style>
	input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(1.5); /* IE */
  -moz-transform: scale(1.5); /* FF */
  -webkit-transform: scale(1.5); /* Safari and Chrome */
  -o-transform: scale(1.5); /* Opera */
  padding: 10px;
}
	</style>
EOF;

	$htmlresult = $dbsite->query($query); // or die("Cant get Completed Items");

	if (! empty($htmlresult)) {

		$retHTML .= "<h4 id=modulesubtitle>Jobs in the system ... </h4>
		You can add jobs to this invoice from below<br><br>";

		$values = array();
		if ((isset($post['itemsid'])) && (is_array($post['itemsid']))) {
			$itemsidsPosted = $post['itemsid'];
			foreach ($itemsidsPosted as $itemValues) {
				$values[] = $itemValues;
			}
		}
		foreach ($htmlresult as $htmlrow) {

			$checked = (is_array($values) && in_array($htmlrow->itemsid, $values)) ? ' checked="checked"' : '';
			$cid = 'jobsid[]_check_' . $htmlrow->jobsid;
			$content = stripslashes($htmlrow->content);
			$retHTML .= <<<EOF

<div class="panel panel-default">
            <div class="panel-heading">
EOF;
			$retHTML .= <<<EOH
	<input class="auto clickable" type="checkbox" name="jobsid[]"
	value="{$htmlrow->jobsid}" id="$cid" $checked >
EOH;

			$retHTML .= '<label for="' . $cid . '"';

			if (isset($errors) && in_array('itemsid', $errors))
				$retHTML .= " class=\"error\"";

			$retHTML .= '>';
			$retHTML .= <<<EOF
			&nbsp;&nbsp;
			<strong> Job No: {$htmlrow->jobno}</strong>
			</label>
			</div>
            <div class="panel-body">
		$content
 </div>
 </div>

EOF;
		}
	} else {
		return;
	}

	return $retHTML;
}

