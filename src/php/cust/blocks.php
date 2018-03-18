<?php

function getQuoteRowHTML($r){
	global $dbsite;

	global $owner;

	$startDate = date('d-m-Y',$r->incept);
	$quoteno = $r->quoteno;
	$quotesid = $r->quotesid;
	$co_name = $r->co_name;
	$agreecnt = 0;
	$totalprice = 0;

	$ext_contact = (isset($r->contactsid)) ? getCustExtName($r->contactsid) : '';

	$sqltext = "SELECT qitems.content,qitems.price,
	qitems.agreed,qitems.itemno,quotes.incept,cust.co_name
	FROM qitems,cust,quotes
	WHERE qitems.quotesid=quotes.quotesid
	AND quotes.custid=cust.custid
	AND quoteno='" . $r->quoteno . "'";

	$resItems = $dbsite->query($sqltext); # or die("Cant get items");
	if (! empty($resItems)) {
		$cnt = 0;

		$itemHTML='';
		$firstitemHTML='';
		foreach($resItems as $rr) {
			if(isset($rr->price) && is_numeric($rr->price) && ($rr->price>0)){
				$totalprice += $rr->price;
			}
			if(isset($rr->agreed) && is_numeric($rr->agreed) && ($rr->agreed>0)){
				$agreecnt++;
			}
			$itemHTML .= getItemRowMiniHTML($rr,$cnt);
			$cnt++;
		}
	}

	$rand = rand();
	$startDate = date('d-m-Y',$r->incept);
	$content = stripslashes($r->content);

	$fromExtMark = '';

	if($totalprice==0){
		$fromExtMark = 'Status: <span style="color:orange;font-size:90%;">Awaiting Quotation from '.$owner->co_name.'</span>';
		$agreedMark = $agreecnt . ' Items Agreed of '.$cnt ;
	}
	if($totalprice>0){
		$fromExtMark = 'Status: <span style="color:red;font-size:90%;">Awaiting Your Quotation Approval</span> ';
	}

	if($agreecnt){
		if($agreecnt==$cnt){
			$fromExtMark = 'Status: <span style="color:green;font-size:90%;">Quotation Agreed</span>';
			$fromExtMark .= ' <a href="/quotes/view.php?id='.$quotesid.'">View Offer</a>';
			$agreedMark = $agreecnt . ' Items Agreed of '.$cnt ;
		}else{
			$fromExtMark = 'Status: <span style="color:green;font-size:90%;">Quotation Partially Agreed</span>';
			$fromExtMark .= ' <a href="/quotes/view.php?id='.$quotesid.'">View Offer</a>';
			$agreedMark = $agreecnt . ' Items Agreed of '.$cnt ;
		}
	}

	//	if($r->price<1){
	//		$fromExtMark = '<span style="color:red;font-size:130%;">Awaiting Quotation</span>';
	//	}

	if($r->agree==1){
		$fromExtMark = 'Status: Quote Agreed';
	}

	$retHTML = <<<EOF
<div class="panel panel-default">
<div class="panel-heading">
<a href="/quotes/view.php?id=$quotesid" title="View this Quote">
<strong>{$owner->co_nick} Quote No: $quoteno</strong></a>
Date: $startDate - Contact: $ext_contact
</div>
<div class="panel-body">
$fromExtMark<br clear=all>
$agreedMark<br clear=all>

EOF;


	// <strong>
	// <a href="/quotes/files.php?quoteno=$quoteno">Share Files</a> | <a href="/quotes/view.php?id=$quotesid" title="View this Quote">View Quote</a>
	// </strong>


	$moreItemsHTML='';
	if($itemHTML != ''){
		$itemsMore = $cnt;
		$moreItemsHTML .= <<<EOF
<span id=fb$rand><a href="javascript:void(0);" onclick="showHide('$rand')">Show Details ($itemsMore Items) ... </a></span>
EOF;
	}

	$retHTML .= <<<EOF
	$moreItemsHTML
<div id=$rand style="display:none">

$itemHTML</div>

</div>
</div>
EOF;


	#| <a href="/jobs/add.php?quoteid=$quotesid">Create Job</a>
	return $retHTML;


}

function getItemRowMiniHTML($r,$cnt){

	#	items.itemsid,items.content,items.price,jobs.jobno,jobs.incept,jobs.jobsid,cust.co_name


	$startDate = date("d-m-Y",$r->incept);
	$itemsid = $r->itemsid;
	$content = stripslashes($r->content);

	$price = $r->price;

	$cnt++;

	$agreedTxt = '';
	if(isset($r->agreed) && (is_numeric($r->agreed))){
		if($r->agreed >0){
			$agreeDate = date("d/m/Y",$r->agreed);
			$agreedTxt = "<br><span style=\"color:green;\">Quotation Agreed on $agreeDate</span>";
		}
	}



	$retHTML = <<<EOF
		<br>
		<div id=subblock>
		Item $cnt - $content <br>
		<strong>Price:</strong> &pound;$price
		 $agreedTxt </div>
EOF;

	return $retHTML;

}

function getJobRowHTML($r){
	global $dbsite;
	global $owner;

	$startDate = date('d-m-Y',$r->incept);
	$jobno = $r->jobno;
	$jobsid = $r->jobsid;
	$co_name = $r->co_name;


	$sqltext = "SELECT items.itemsid,items.content,items.price,items.incept,
	jobs.done,jobs.jobno
	FROM items,jobs
	WHERE items.itemsid=jobs.itemsid
	AND jobno='" . $r->jobno . "'";
	$res = $dbsite->query($sqltext); # or die("Cant get items");
	if (! empty($res)) {
		$cnt = 0;
		$itemHTML='';
		$firstitemHTML='';
		foreach($res as $rr) {

			$itemHTML .= getItemRowMiniHTML($rr,$cnt);

			$cnt++;
		}

	}

	$rand = rand();

	$status = ($r->done>0) ? 'Finished: ' . date("d/m/Y",$r->done) : 'Live - in Progress';
	$retHTML = <<<EOF



	<div class="panel panel-default">
            <div class="panel-heading">

	<h3 class="panel-title">
<a href="/jobs/view.php?id=$jobsid">{$owner->co_nick} Job No: $jobno</a>
</h3>
            </div>
            <div class="panel-body">


<a href="/jobs/files.php?jobno=$jobno">Share Files</a>
 | <a href="/jobs/view.php?id=$jobsid">View Job</a>


<br clear=all>

Start Date: $startDate | Status: $status

<div>
EOF;

	if($itemHTML != ''){
		$retHTML .= <<<EOF
<span id=fb$rand><a href="javascript:void(0);" onclick="showHide('$rand')">Show More</a></span>
EOF;
	}	$retHTML .= <<<EOF
<div id=$rand style="display:none">

$itemHTML

	</div>
	</div>
</div>
EOF;



	$retHTML .= <<<EOF
</div>
</li>
EOF;

	return $retHTML;

}

function getInvoiceRowHTML($r){
	global $sitesid;

	$co_name = $r->co_name;
	$invoiceno = $r->invoiceno;
	$invoicesid = $r->invoicesid;
	$date = date("d/m/Y",$r->incept);
	$retHTML = <<<EOF
<div class="panel panel-default">
   <div class="panel-heading">

        <h3 class="panel-title">Invoice No: $invoiceno - Date: $date</h3>
    </div>
    <div class="panel-body">

<a href="/bin/download_pdf_invoice.pl?id=$invoicesid&sid=$sitesid" title="Download a PDF of this Invoice">
<i class="fa fa-file-pdf-o"></i>
</a>
<a href="/bin/download_pdf_invoice.pl?id=$invoicesid&sid=$sitesid" title="Download a PDF of this Invoice">
Download PDF</a>

</div>
</div>

EOF;

	return $retHTML;


}
