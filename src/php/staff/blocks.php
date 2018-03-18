<?php

function getQuoteRowHTML($r){

	global $domain;

	$custid = $r->custid;


		$weblink = 'customers.'.$domain;



	$startDate = date('d-m-Y',$r->incept);
	$quoteno = $r->quoteno;
	$quotesid = $r->quotesid;
	$co_name = $r->co_name;
	$colour = $r->colour;
	if((!isset($colour))||($colour=='')||($colour=='#FFFFFF')){
		$colour = '#2c0673';
	}

	$ext_contact = (isset($r->contactsid)) ? getCustExtName($r->contactsid) : '';

	$sqltext = "SELECT items.itemsid,items.content,items.price,items.itemno,items.incept,cust.co_name
	FROM items,quotes,cust
	WHERE items.quotesid=quotes.quotesid
	AND quotes.custid=cust.custid
	AND quoteno='" . $r->quoteno . "'";
	$res = $dbsite->query($sqltext); # or die("Cant get items");
	if (! empty($res)) {

		$priceOK = 1;
		$cnt = 0;
		$itemHTML='';
		$firstitemHTML='';
		foreach($res as $rr) {
		$rr = $res[0];
			if(!$rr['price']){
				$priceOK=0;
			}
			if($cnt>0){
				$itemHTML .= getItemRowMiniHTML($rr);
			}else{
				$firstitemHTML .= getItemRowMiniHTML($rr);
			}
			$cnt++;
		}
	}

	$rand = rand();

	$content = stripslashes($r->content);
	$fromExtMark = '';
	if(($r->origin=='ext')&&(!$priceOK)){
		$fromExtMark = '<span style="color:red;">New from Customer Portal!!!</span>';
	}
	if(($r->origin=='ext')&&($priceOK)&&(!$r->agree)){
		$fromExtMark = 'Awaiting Customer Approval';
	}
	if(($r->origin=='int')&&($priceOK)&&(!$r->agree)){
		$fromExtMark = 'Awaiting Customer Approval';
	}
	if($r->agree){
		$fromExtMark = '<span style="color:green;">Quote Agreed</span>';
	}

	if(($r->live)||($r->origin=='ext')){
		$fromExtMark .= ' - <span style="color:green;">Live and viewable by Customer</span>';
	}else{
		$fromExtMark .= ' - <span style="color:#830682;">Not Live and hidden from Customer</span>';
	}


	$retHTML .= <<<EOF
<li>

<div >
<div style="float:left;width:660px;padding:4px;">

<div style="width:10px;background-color:$colour;float:left;margin-right:5px;">&nbsp;</div>
<a href="/quotes/view.php?id=$quotesid" title="View this Quote"><strong>$quoteno</strong></a> <strong>Date: $startDate</strong>
<strong>$co_name</strong> - ($ext_contact)<br>
Status: $fromExtMark

</div>

<span id=actions>
EOF;
	if($priceOK){
		$retHTML .= <<<EOF
 <a href="/bin/quotes_pdf.pl?id=$quotesid" title="Download PDF">PDF</a>
 <img src="/img/pdf-logo.png" width=20 align=top />
 </a>	|
EOF;
	}
	$retHTML .= <<<EOF
<a href="/quotes/view.php?id=$quotesid">View</a>
 | <a href="/quotes/edit.php?id=$quotesid">Edit</a>
 | <a href="/quotes/print.php?id=$quotesid">Print</a>
 | <a href="/loginas.php?cid=$custid" target="_blank" title="Log In As $co_name">Customer CP</a>

</span>

<br clear=all>

EOF;

	$retHTML .= <<<EOF
<div style="font-size:90%;">

<span style="color:#aaa;">Description:</span> $content<br/>

EOF;

	if($firstitemHTML != ''){
		$itemsMore = $cnt;
		$retHTML .= <<<EOF
<span id=fb$rand><a href="javascript:void(0);" onclick="showHide('$rand')">Show Items ($itemsMore) ... </a></span>
EOF;
	}

	$retHTML .= <<<EOF
	<div id=$rand style="display:none">Quoted Items:<br/>
	$firstitemHTML
	$itemHTML</div>
</div>
EOF;

	$retHTML .= <<<EOF
</div>
</li>
EOF;


	#| <a href="/jobs/add.php?quoteid=$quotesid">Create Job</a>
	return $retHTML;


}

function getItemRowHTML($r){

	$itemsid = $r->itemsid;
	$content = substr($r->content,0,40);
	$delivery = $r->delivery;
	$price = $r->price;
	$quotesid = $r->quotesid;
	$quoteno = $r->quoteno;
	$co_name = getCustName($r->custid);

	$retHTML .= <<<EOF
<li>

<strong>For $co_name</strong><br>
<span style="font-size:80%;">$content...<br></span>

<span style="font-size:70%;">
Actions:
Quote No: <a href="/quotes/view.php?id=$quotesid" title="View this Quote"><strong>$quoteno</strong></a> |
  <a href="/jobs/add.php?id=$itemsid">Create Job</a>
</span>
</li>
EOF;

	return $retHTML;

}

function getItemRowMiniHTML($r){

	#	items.itemsid,items.content,items.price,jobs.jobno,jobs.incept,jobs.jobsid,cust.co_name


	$startDate = date("d-m-Y",$r->incept);
	$jobno = $r->jobno;
	$jobsid = $r->jobsid;
	$co_name = $r->co_name;

	$itemsid = $r->itemsid;
	$content = stripslashes($r->content);
	$delivery = $r->delivery;
	$price = $r->price;
	$itemNo = $r->itemno;

	$retHTML .= <<<EOF
		<span >Item No: $itemNo | $content | Date: $startDate | $delivery | &pound;$price</span>	<br>
EOF;

	return $retHTML;

}

function getJobRowHTML($r){
	global $owner;

	$startDate = date('d-m-Y',$r->incept);
	$jobno = $r->jobno;
	$jobsid = $r->jobsid;
	$co_name = $r->co_name;
	$colour = $r->colour;
	$quotesid = $r->quotesid;
	$stageName = getStageName($r->stagesid);


	$sqltext = "SELECT items.itemsid,items.content,items.price,items.incept,items.itemno FROM items,jobs WHERE items.itemsid=jobs.itemsid AND jobno='" . $r->jobno . "'";
	$res = $dbsite->query($sqltext); # or die("Cant get items");
	if (! empty($res)) {
		$cnt = 0;
		$itemHTML='';
		$firstitemHTML='';
		foreach($res as $rr) {
		$rr = $res[0];
			if($cnt>0){
				$itemHTML .= getItemRowMiniHTML($rr);
			}else{
				$firstitemHTML .= getItemRowMiniHTML($rr);
			}
			$cnt++;
		}

	}

	$rand = rand();
	$content = stripslashes($r->content);

	$jobWith = getJobWith($jobsid);

	$retHTML .= <<<EOF
<li>
<div >
<div style="float:left;width:290px;padding:4px;"><div style="width:10px;background-color:$colour;float:left;margin-right:5px;">&nbsp;</div>
<a href="/jobs/view.php?id=$jobsid" title="Edit this Job"><strong>$jobno</strong></a> for $co_name<br>
<span style="color:#c92f25;">Stage: $stageName</span>
</div>

EOF;

	$retHTML .= <<<EOF
<span id=actions>
<a href="/jobs/view.php?id=$jobsid">View Job</a>
 | <a href="/quotes/view.php?id=$quotesid">View Quote</a>
EOF;



		$retHTML .= <<<EOF
 | <a href="/jobs/edit.php?id=$jobsid">Edit</a>

EOF;
		# | <a href="/jobs/print.php?id=$jobsid">Print</a>

		$retHTML .= <<<EOF

 | <a href="/invoices/add.php?id=$jobsid">Invoice</a>

EOF;


	//if($r->done){$status = 'Finished:' . date('d-m-Y',$r->done);}else{$status = '<a href="/jobs/finish.php?id=' . $jobsid . '">Mark Finished</a>';}
	//$retHTML .= <<<EOF
	// | $status
	//EOF;

	$retHTML .= <<<EOF
</span>
EOF;

	$retHTML .= <<<EOF
<br clear=all>
EOF;


	$retHTML .= <<<EOF
<div style="font-size:80%;">$content - $firstitemHTML
EOF;
	if($itemHTML != ''){
		$retHTML .= <<<EOF
 ... <span id=fb$rand><a href="javascript:void(0);" onclick="showHide('$rand')">Show More ($cnt)</a></span>
EOF;
	}	$retHTML .= <<<EOF
<div id=$rand style="display:none">$itemHTML</div>
</div>
EOF;



	$retHTML .= <<<EOF
</div>
</li>
EOF;

	return $retHTML;

}

function getInvoiceRowHTML($r){

	global $owner;

	$co_name = $r->co_name;
	$invoicesid = $r->invoicesid;
	$invoiceno = $r->invoiceno;
	$date = date("d/m/Y",$r->incept);
	$colour = $r->colour;
	$paid = ($r->paid>0) ? "Paid: " . date("d-m-Y",$r->paid) : "<a href=\"/invoices/?go=y&id=$invoicesid\" title=\"Mark as Paid\">Mark as Paid</a>";





	$retHTML .= <<<EOF
	<li>
		<div >
		<div style="float:left;width:660px;padding:4px;">

<div style="width:10px;background-color:$colour;float:left;margin-right:5px;">&nbsp;</div>
		<strong>Invoice No: <a href="/invoices/print.php?id=$invoicesid" title="View and print full the Invoice">$invoiceno</a></strong> - $date<br>
		 For: $co_name
		</div>

		<span id=actions>
		<a href="/invoices/print.php?id=$invoicesid" title="View and print full the Invoice">View/Print</a>	 |
		<a href="javascript:void(0);" onclick="openInvoiceMail('$invoicesid')" title="Email this Invoice to the Customer">Email to Customer</a>	 |
EOF;

	$pdfExists = 0;
	$docTitlePrefix = preg_replace('/\W/', '_', $owner->co_name);
	$docTitlePrefix = preg_replace('/__/', '_', $docTitlePrefix);
	$docTitlePrefix = preg_replace('/__/', '_', $docTitlePrefix);
	$docTitle = $dataDir . "/pdf/invoices/".$docTitlePrefix."_Invoice_" . $invoiceno . '.pdf';
	$docWebName = "/pdf/invoices/".$docTitlePrefix."_Invoice_" . $invoiceno . '.pdf';

	if(file_exists($docTitle)){
		$pdfExists = 1;
		$retHTML .= <<<EOF
		<a href="$docWebName" title="Download PDF">Invoice PDF <img src="/img/pdf-logo.png" width=20 align=top /></a> -
		<a href="/invoices/?go=mkpdf&id=$invoicesid" title="Refresh Invoice PDF">+Refresh</a> |
EOF;

	}else{

		$retHTML .= <<<EOF

		<a href="/invoices/?go=mkpdf&id=$invoicesid" title="Make Invoice PDF">Make Invoice PDF</a> |
EOF;
	}
	$retHTML .= <<<EOF
		$paid
		</span>

	<br clear=all>

	</div>

	</li>
EOF;

	return $retHTML;


}

function getDiaryMiniRowHTML($r){

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

function getDiaryDayHTML($day,$staffid=0){
	$totime = mktime(-1, 0, 0, date("m",$day), date("d",$day)+1,   date("Y",$day));

	$sqltext = "SELECT * FROM diary WHERE incept>=$day AND incept<$totime AND every IS NULL";
	#print $sqltextq . '<br>';
	if($staffid>1){
		$sqltext .= " AND staffid=" . $staffid;
	}
	$sqltext .= " ORDER BY incept";
	$res = $dbsite->query($sqltext); # or die("Cant get diary details");

	$retHTML = <<<EOF
	<li id=diaryday>
EOF;

	$retHTML .= date("l d/m",$day);

	$now = mktime(0, 0, 0, date("m"), date("d"),   date("Y"));

	if($day>=$now){
		$retHTML .= <<<EOF
	<a href="/diary/add.php?incept=$day">Add</a>
EOF;
	}

	foreach($res as $r) {
		$retHTML .= getDiaryMiniRowHTML($r);
	}

	$retHTML .= <<<EOF
	</li>
EOF;
	if(date("l",$day)=='Sunday'){
		$retHTML .= <<<EOF
	<br clear=all />
EOF;
	}
	return $retHTML;

}

function getBlankDiaryDayHTML($day){

	$retHTML = <<<EOF
	<li id=diarydayblank>&nbsp;</li>
EOF;

	if(date("l",$day)=='Sunday'){
		$retHTML .= <<<EOF
	<br clear=all />
EOF;
	}
	return $retHTML;

}

function getContactRowHTML($r){

	global $domain;

	$fname = $r->fname;
	$sname = $r->sname;
	$tel = $r->tel;
	$mob = $r->mob;
	$email = $r->email;
	$contactsid = $r->contactsid;

	$contactString = '';

	if($r->custid){
		$co_name = 'Customer: ' . getCustName($r->custid);
	}elseif($r->suppid){
		$co_name = 'Supplier: ' . getSuppName($r->suppid);
	}else{

	}

	#if($fname != '') $contactString .= ' | Name: ' . $fname . ' ' . $sname;
	if($co_name != '') $contactString .= ' | ' . $co_name;
	if($email != '') $contactString .= ' | <a href="mailto:' . $email . '">' . $email . "</a>";
	if($tel != '') $contactString .= " | Tel: " . $tel;
	$mob = preg_replace("/\s/",'',$mob);
	if($mob != '') $contactString .= " | Mobile: " . $mob ;#. " | <a href=\"/sms/add.php?no=" . $mob . "\">Send SMS</a>";

	$retHTML .= <<<EOF
				<li>

<div >
<div style="float:left;padding:4px;">
				<a href="/contacts/view.php?id=$contactsid" title="View full contact details">
					<strong>$fname $sname</strong></a>
					<span style="font-size:80%;">$contactString</span></div>
	<span id=actions>

			<a href="/contacts/edit.php?id=$contactsid" title="Edit contact">Edit</a>

			</span>

					<br clear=all />
			</div>
		</li>
EOF;

	return $retHTML;


}

function getJobMiniRowHTML($r){
	global $seclevel;

	$startDate = date('d-m-Y',$r->incept);
	$jobno = $r->jobno;
	$jobsid = $r->jobsid;
	$co_name = $r->co_name;
	$colour = $r->colour;
	$quotesid = $r->quotesid;
	$stageName = getStageName($r->stagesid);

	$rand = rand();
	$content = stripslashes($r->content);

	#$jobWith = getJobWith($jobsid);

	$retHTML = <<<EOF
<li>
<div >
<div style="float:left;width:390px;"><div style="width:10px;background-color:$colour;float:left;margin-right:5px;">&nbsp;</div>
<a href="/jobs/view.php?id=$jobsid" title="Edit this Job"><strong>$jobno</strong></a> for $co_name
</div>

EOF;
	if($seclevel<6){
		$retHTML .= <<<EOF
<span id=actions>
<a href="/jobs/view.php?id=$jobsid">View Job</a>
 | <a href="/quotes/view.php?id=$quotesid">View Quote</a>
 | <a href="/jobs/print.php?id=$jobsid">Print</a>
EOF;

		if($seclevel < 2){
			$retHTML .= <<<EOF
 | <a href="/jobs/edit.php?id=$jobsid">Edit</a>
 | <a href="/delivery/delivery.php?jobsid=$jobsid">Delivery Note</a> <a href="/delivery/compliance.php?jobsid=$jobsid">+</a>
 | <a href="/invoices/add.php?id=$jobsid">Invoice</a>
EOF;
		}



		$retHTML .= <<<EOF
</span>
EOF;
	}
	$retHTML .= <<<EOF
<br clear=all>

</div>
</li>

EOF;

	return $retHTML;

}

function getQuoteMiniRowHTML($r){
	global $seclevel;



	$sqltext = "SELECT items.price
	FROM items,quotes,cust
	WHERE items.quotesid=quotes.quotesid
	AND quotes.custid=cust.custid
	AND quoteno='" . $r->quoteno . "'";
	$res = $dbsite->query($sqltext); # or die("Cant get items");
	if (! empty($res)) {

		$priceOK = 1;
		$cnt = 0;
		$itemHTML='';
		$firstitemHTML='';
		foreach($res as $rr) {
		$rr = $res[0];
			if(!$rr['price']){
				$priceOK=0;
			}
		}
	}




	$startDate = date('d-m-Y',$r->incept);
	$quoteno = $r->quoteno;
	$quotesid = $r->quotesid;
	$co_name = $r->co_name;
	$colour = $r->colour;
	$ext_contact = (isset($r->contactsid)) ? getCustExtName($r->contactsid) : '';

	$rand = rand();

	$content = stripslashes($r->content);
	$fromExtMark = '';
	if(($r->origin=='ext')&&(!$priceOK)){
		$fromExtMark = '<br>Quote Status: <span style="color:red;">New from Customer Portal!!!</span>';
	}
	if(($r->origin=='ext')&&($priceOK)&&(!$r->agree)){
		$fromExtMark = '<br>Quote Status: Awaiting Customer Approval';
	}
	if(($r->origin=='int')&&($priceOK)&&(!$r->agree)){
		$fromExtMark = '<br>Quote Status: Awaiting Customer Approval';
	}
	if($r->agree){
		$fromExtMark = '<br><span style="color:green;font-size:100%;">Quote Agreed</span>';
	}

	$retHTML = <<<EOF
<li>

<div >
<div style="float:left;width:460px;"><div style="width:10px;background-color:$colour;float:left;margin-right:5px;">&nbsp;</div>
<a href="/quotes/view.php?id=$quotesid" title="View this Quote"><strong>$quoteno</strong></a>
<span style="font-size:90%;">$co_name - ($ext_contact)</span> - $fromExtMark</div>

EOF;

	if($seclevel<6){
		$retHTML .= <<<EOF
<span id=actions>
<a href="/quotes/view.php?id=$quotesid">View</a>
 | <a href="/quotes/print.php?id=$quotesid">Print</a>
EOF;

		if($seclevel<2){
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

function getRequestQuoteRowHTML($r){
	global $domain;
	$suppid = $r->suppid;

		$weblink = 'suppliers.'.$domain;


	$startDate = date('d-m-Y',$r->incept);
	$co_name = $r->co_name;

	$ordersid = $r->ordersid;
	$content = stripslashes($r->content);

	$fromExtMark = '';

	if($r->priceoff<1){
		$fromExtMark = '<span style="color:#830682;">Awaiting Quotation</a>';
	}
	if($r->priceoff>1){
		$fromExtMark = '<span style="color:red;font-size:110%;">Quotation Submitted</a>';
	}
	if($r->agree){
		$fromExtMark = '<span style="color:green;">Quote Agreed</a>';
	}

	$retHTML .= <<<EOF
<li>

<div >
<div style="float:left;width:360px;">
<a href="/orders/view.php?id=$ordersid" title="View this Quote">
<strong>Quote Request No: $ordersid</strong></a> for $co_name

<br>
$fromExtMark
</div>
EOF;

	$retHTML .= <<<EOF

<span id=actions>

<a href="/orders/view.php?id=$ordersid" title="View this Quote">View Quote Request</a> |
<a href="/loginas.php?sid=$suppid" target="_blank" title="Log In As $co_name">Supplier CP</a>

EOF;

	$retHTML .= <<<EOF
</span>
EOF;

	$retHTML .= <<<EOF

<br clear=all>
EOF;

	$retHTML .= <<<EOF
<span style="font-size:90%;"> Date: $startDate</span>

<br clear=all>
Quote for:- $content
</li>
EOF;

	#| <a href="/jobs/add.php?quoteid=$quotesid">Create Job</a>
	return $retHTML;


}

function getInvoiceMiniRowHTML($r){
	global $seclevel;

	$co_name = $r->co_name;
	$invoicesid = $r->invoicesid;
	$invoiceno = $r->invoiceno;
	$date = date("d/m/Y",$r->incept);
	$colour = $r->colour;

	$retHTML .= <<<EOF
				<li>
		<li>

<div >
<div style="float:left;width:560px;">
<div style="width:10px;background-color:$colour;float:left;margin-right:5px;">&nbsp;</div>

<strong><a href="/invoices/print.php?id=$invoicesid" title="View and print full the Invoice">Invoice No: $invoiceno</a></strong> - $date for $co_name

</div>
EOF;


	$retHTML .= <<<EOF
		<span id=actions>
<a href="/invoices/print.php?id=$invoicesid" title="View and print full the Invoice">View/Print</a>	 |
<a href="javascript:void(0);" onclick="openInvoiceMail('$invoicesid')" title="Email this Invoice to the Customer">Email to Customer</a>
</span>
EOF;


	$retHTML .= <<<EOF
<br clear=all>
</li>
EOF;

	return $retHTML;


}

function getSiteLogMiniRowHTML($r){
	global $seclevel;
	$totals[$r->eventsid]++;
	$incept = date('d-m-Y h:i A',$r->incept);
	$staffName = getStaffName($r->staffid);

	$retHTML .= <<<EOF

	<li>

<div >
<div style="width:10px;background-color:$colour;float:left;margin-right:5px;">&nbsp;</div>


<div style="width:150px;float:left;font-size:70%;">$incept</div>
<div style="width:100px;float:left;font-size:70%;"> $staffName</div>
<div style="width:250px;float:left;font-size:70%;"> {$r->name} </div>
<br clear=all>
 </div>
EOF;

	$retHTML .= <<<EOF
</li>
EOF;

	return $retHTML;


}

function getOrdersRowHTML($r) {

	$co_name = $r->co_name;
	$ordersid = $r->ordersid;
	$orderno = $r->orderno;
	$date = date("d/m/Y",$r->incept);
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
