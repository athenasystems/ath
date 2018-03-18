<?php

function getRequestQuoteRowHTML($r){

	global $owner;

	$startDate = date('d-m-Y',$r->incept);
	$orderno = $r->orderno;
	$ordersid = $r->ordersid;
	$co_name = $r->co_name;
	$ext_contact = (isset($r->contactsid)) ? getSuppExtName($r->contactsid) : '';

	$rand = rand();
	$startDate = date('d-m-Y',$r->incept);
	$content = stripslashes($r->content);
	$fromExtMark = '';
	if((!$r->incept)&&(!$r->agree)){
		$fromExtMark = '<span style="color:red;font-size:130%;">Awaiting Quotation</span>';
	}
	if(($r->priceoff>0)&&(!$r->agree)){
		$fromExtMark = '<span style="color:red;font-size:130%;">Awaiting Quotation Approval</span>';
	}

	if($r->priceoff<0.00001){
		$fromExtMark = '<span style="color:red;font-size:130%;">Awaiting Quotation</span>';
	}
	if($r->agree){
		$fromExtMark = '<span style="color:red;font-size:130%;">Quote Agreed</span>';
	}

	$retHTML .= <<<EOF
<li>

<div style="border:1px #ccc solid;padding:6px;font-size:90%;">
<div style="float:left;width:360px;">
<a href="/quotes/view.php?id=$ordersid" title="View this Request for Quote">
<strong>Request for Quote No: $ordersid</strong></a> <br>
	$fromExtMark
</div>

<span style="float:right;font-size:90%;width:490px;text-align:right;">
<strong>

<a href="/quotes/view.php?id=$ordersid" title="View this Request for Quote">View Request for Quote</a>
</strong>

</span>

<br clear=all>

<span style="font-size:90%;"> Contact: $ext_contact - Date: $startDate</span>

<br clear=all>

</li>
EOF;

	return $retHTML;


}

function getOrdersRowHTML($r){

	global $owner;

	$startDate = date('d-m-Y',$r->incept);
	$orderno = $r->orderno;
	$ordersid = $r->ordersid;
	$co_name = $r->co_name;
	$ext_contact = (isset($r->contactsid)) ? getSuppExtName($r->contactsid) : '';

	$rand = rand();
	$startDate = date('d-m-Y',$r->incept);
	$content = stripslashes($r->content);
	$fromExtMark = '';

	if($r->agree){
		$fromExtMark = '<span style="color:red;font-size:130%;">Quote Agreed</span>';
	}

	$retHTML .= <<<EOF
<li>

<div style="border:1px #ccc solid;padding:6px;font-size:90%;">
<div style="float:left;width:360px;">
<a href="/orders/view.php?id=$ordersid" title="View this order"><strong>{$owner->co_nick} Order No: $ordersid</strong></a> <br>
	$fromExtMark
</div>

<span style="float:right;font-size:90%;width:490px;text-align:right;">
<strong>

<a href="/quotes/view.php?id=$ordersid" title="View this order">View order</a>
</strong>

</span>

<br clear=all>

<span style="font-size:90%;"> Contact: $ext_contact - Date: $startDate</span>

<br clear=all>

</li>
EOF;

	return $retHTML;


}

function getItemRowMiniHTML($r,$cnt){

	$startDate = date("d-m-Y",$r->incept);
	$jobno = $r->jobno;
	$jobsid = $r->jobsid;
	$co_name = $r->co_name;

	$itemsid = $r->itemsid;
	$content = stripslashes($r->content);
	$delivery = $r->delivery;
	$price = $r->price;

	$cnt++;

	$retHTML .= <<<EOF
		<br><strong>Item $cnt:</strong> <span >$content | <strong>Delivery:</strong> $delivery | <strong>Price:</strong> &pound;$price</span>
EOF;

	return $retHTML;

}

function getJobRowHTML($r){

	global $owner;

	$startDate = date('d-m-Y',$r->incept);
	$jobno = $r->jobno;
	$jobsid = $r->jobsid;
	$co_name = $r->co_name;
	$quotesid = $r->quotesid;


	$sqltext = "SELECT items.itemsid,items.content,items.price,items.incept,jobs.done FROM items,jobs WHERE items.itemsid=jobs.itemsid AND jobno='" . $r->jobno . "'";
	$res = $dbsite->query($sqltext); # or die("Cant get items");
	if (! empty($res)) {
	$cnt = 0;
	$itemHTML='';
	$firstitemHTML='';
	foreach($res as $rr) {
		$rr = $res[0];
	if($cnt>0){
		$itemHTML .= getItemRowMiniHTML($rr,$cnt);
	}else{
		$firstitemHTML .= getItemRowMiniHTML($rr,$cnt);
	}
	$cnt++;
	}

	}

	$rand = rand();
	$content = stripslashes($r->content);
	$status = ($r->done>0) ? 'Finished: ' . date("d/m/Y",$r->done) : 'Live - in Progress';
	$retHTML .= <<<EOF
<li>
<div style="border:1px #ccc solid;padding:6px;font-size:90%;">
<div style="float:left;width:260px;">
<strong><a href="/jobs/view.php?id=$jobsid">{$owner->co_nick} Job No: $jobno</a></strong></div>

<span style="float:right;font-size:90%;width:490px;text-align:right;">
<strong>
<a href="/jobs/files.php?jobno=$jobno">Share Files</a>
 | <a href="/jobs/view.php?id=$jobsid">View Job</a>
</strong>
</span>

<br clear=all>
<span style="font-size:90%;font-weight:bold;">
Start Date:</span> $startDate | <span style="font-size:90%;font-weight:bold;">Status:</span> $status

<div style="font-size:90%;">$content - $firstitemHTML
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



?>