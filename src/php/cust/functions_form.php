<?php

function html_file ($display, $name, $value = "", $path = "", $id = "", $help = "") {
	global $errors;

	if((!isset($id))||($id == "")){
		$id = $name;
	}


	$html = "<li>\n<label for=\"$id\"";

	if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";

	$html .= ">$display</label>\n";


	$html .= "<input type=\"file\" name=\"$name\" id=\"$id\"  />";

	if ($path != "" && $value != "") $html .= " Currently set to <a href=\"$path$value\" title=\"$value\">$value</a>.";

	if($help != ""){
		$html .= "<span class=\"help\">$help</span>";
	}

	$html .= "</li>\n\n";

	print $html;
}

function customer_select($display,$name,$selected) {
	global $dbsite;
	global $errors;

	if((!isset($id))||($id == "")){
		$id = $name;
	}

	$html = "<li>\n<label for=\"custid\"";

	if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";

	$html .= ">$display</label>\n<select class=\"form-control\" name=custid>";

	$html .= '<option value="0">None</option>' . "\n";

	$sqltext = "SELECT custid,co_name FROM cust WHERE live=1 ORDER BY co_name";

	$res = $dbsite->query($sqltext); # or die("Cant get customers");

	foreach($res as $r) {


		if($selected == $r->custid){
			$sel = ' selected="selected"';
		}else{
			$sel = '';
		}
		$auctionsid = $r->custid;
		$auctionTitle = $r->co_name;
		$html .= <<<EOT
<option value="$auctionsid" $sel>$auctionTitle</option>\n
EOT;

	}
	$html .= "</select></li>\n\n";


	print $html;

}

function job_select($display,$name,$custid,$selected) {
	global $dbsite;
	global $errors;

	$html = "<li>\n<label for=\"jobno\"";

	if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";

	$html .= ">$display</label>\n<select class=\"form-control\" name=jobno>";

	$html .= '<option value="0">None</option>' . "\n";

	$sqltext = "SELECT jobs.incept,jobs.jobno,jobs.jobsid FROM jobs,items,quotes,cust WHERE items.itemsid=jobs.itemsid AND items.quotesid=quotes.quotesid AND quotes.custid=cust.custid AND cust.custid= " . $custid . " ORDER BY jobsid DESC";

	$res = $dbsite->query($sqltext); # or die("Cant get jobno");

	foreach($res as $r) {


		$jobsid = $r->jobsid;
		$jobno = $r->jobno;
		$date = date("d/m/y",$r->incept);

		if($selected == $r->jobno){
			$sel = ' selected="selected"';
		}else{
			$sel = '';
		}

		$html .= <<<EOT
<option value="$jobno" $sel>$jobno - $date</option>\n
EOT;

	}
	$html .= "</select></li>\n\n";


	print $html;

}

function jobsid_select($display,$name,$custid,$selected) {
	global $dbsite;
	global $errors;

	$html = "<li>\n<label for=\"$name\"";

	if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";

	$html .= ">$display</label>\n<select class=\"form-control\" name=$name>";

	$html .= '<option value="0">None</option>' . "\n";

	$sqltext = "SELECT jobs.incept,jobs.jobno,jobs.jobsid FROM jobs,items,quotes,cust
	WHERE items.itemsid=jobs.itemsid
	AND items.quotesid=quotes.quotesid
	AND quotes.custid=cust.custid
	AND cust.custid= " . $custid . "
	ORDER BY jobsid DESC";

	$res = $dbsite->query($sqltext); # or die("Cant get Job Select");

	foreach($res as $r) {


		$jobsid = $r->jobsid;
		$jobno = $r->jobno;
		$date = date("d/m/y",$r->incept);

		if($selected == $r->jobsid){
			$sel = ' selected="selected"';
		}else{
			$sel = '';
		}

		$html .= <<<EOT
<option value="$jobsid" $sel>$jobno - $date</option>\n
EOT;

	}
	$html .= "</select></li>\n\n";


	print $html;

}

function quote_select($display,$name,$custid,$selected) {
	global $dbsite;
	global $errors;

	$html = "<li>\n<label for=\"quoteno\"";

	if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";

	$html .= ">$display</label>\n<select class=\"form-control\" name=quoteno>";

	$html .= '<option value="0">None</option>' . "\n";

	$sqltext = "SELECT quotes.content,quotes.incept,quotes.quoteno,cust.co_name FROM quotes,cust WHERE quotes.custid=cust.custid AND cust.custid=" . $custid . " ORDER BY quotesid DESC";

	$res = $dbsite->query($sqltext); # or die("Cant get quoteno");

	foreach($res as $r) {


		$quotesid = $r->quotesid;
		$quoteno = $r->quoteno;
		$date = date("d/m/Y",$r->incept);

		if($selected == $r->quoteno){
			$sel = ' selected="selected"';
		}else{
			$sel = '';
		}

		$html .= <<<EOT
<option value="$quoteno" $sel>$quoteno - $date</option>\n
EOT;

	}
	$html .= "</select></li>\n\n";


	print $html;

}


function itemBlock($i, $itemArray, $itemsid='', $display='none',$last='') {
	global $errors;

	$qitemsid=$itemArray['qitemsid'];
	$itemContent=$itemArray['content'];
	$itemQuantity=$itemArray['quantity'];

	$item = 'item' .$i;

	if(($itemContent != '')||($itemPrice != '')||($itemQuantity != '')){
		$display='block' ;
	}



	$valStateContent = '';
	if(isset($errors) && in_array("item[$i][content]", $errors)){
		$valStateContent = 'has-error';
	}

	$valStateQuantity = '';
	if(isset($errors) && in_array("item[$i][quantity]", $errors)){
		$valStateQuantity = 'has-error';
		$quantityDisplay='block';
		$quantityChk = 'checked="checked"';
	}


	$j = $i + 1;

	$morehtml ='';
	if(($itemContent == '')||($last!='')){

		$morehtml = <<<EOHTML
<br clear="both"><span id="itemrowmore$i" style="font-size:90%;margin-left:153px">
<a href="javascript:void(0);" onclick="document.getElementById('itemrowmore$i').style.display='none';document.getElementById('itemrow$j').style.display='block';">Add another item ...</a>
</span>
<input type="hidden" name="item[$i][itemsid]" id="itemsid$i" value="$itemsid" style="width:50px;">
EOHTML;
	}

	include '/srv/ath/src/php/tmpl/custquote.php';


}

function check_items($items) {
	$errs=array();
	$cnt = 0 ;
	foreach ($items as $item) {

		if(
				($item['content']=='') && ($item['price'] == '')&&($item['quantity']== '')&&
				($item['hours'] == '')&&($item['rate']=='')&& ($cnt>0) &&(!isset($item['swapTo']))
		){
			continue;
		}

		if($item['content']=='') {
			$errs[]="item[$cnt][content]";
		}

		if(($item['quantity']=='')||($item['quantity']==0)||(!is_numeric($item['quantity']))) {
			$errs[]="item[$cnt][quantity]";
		}

		$cnt++;
	}
	return $errs;
}