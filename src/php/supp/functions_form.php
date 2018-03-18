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

	$sqltext = "SELECT jobs.incept,quotes.content,jobs.jobno,jobs.jobsid,jobs.done,cust.co_name,items.quotesid FROM jobs,items,quotes,cust WHERE items.itemsid=jobs.itemsid AND items.quotesid=quotes.quotesid AND quotes.custid=cust.custid AND cust.custid= " . $custid . " ORDER BY jobsid DESC";

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
	$itemSinglePrice=$itemArray['singleprice'];
	$itemQuantity=$itemArray['quantity'];
	$itemPrice=$itemArray['price'];
	$itemHours=$itemArray['hours'];
	$itemRate=$itemArray['rate'];

	$item = 'item' .$i;

	if(($itemContent != '')||($itemDelivery != '')||($itemPrice != '')){
		$display='block' ;
	}

	$j = $i + 1;

	#<input type="text" name="item[$i][content]" id="itemcontent$i" value="$itemContent" style="width:290px;" />

	$html = <<<EOHTML
<li style="display:$display;white-space:nowrap;border:1px solid #999;padding:10px;" id="itemrow$i">
<div style="float:left;width:480px;">
<h2>Quote Item $j</h2>
<label for="itemcontent$i">Description</label>

<textarea name="item[$i][content]" id="itemcontent$i" style="width:390px;height:70px;">$itemContent</textarea>

<br>
<label for="itemquantity$i">Quantity </label>
<input type="text" name="item[$i][quantity]" id="itemquantity$i" value="$itemQuantity" style="width:50px;" />
<br clear=all><ol>
EOHTML;

	$html .= html_dateselect ("Requested Date", "item[$i][datereq]", $datereq, 'n' , 'return');

	$html .= <<<EOHTML
</ol>
<br clear=all>
</div>

<div style="float:left;width:300px;">

<div style="float:left;width:130px;">
</div>

</div>

<br><br><br>
<input type="hidden" name="item[$i][itemsid]" id="itemsid$i" value="$itemsid" style="width:50px;" />
EOHTML;

	if(($itemContent == '')&&($itemDelivery == '')&&($itemPrice == '')){
		$html .= <<<EOHTML
<br clear="both"><span id="itemrowmore$i" style="font-size:90%;margin-left:153px">
<a href="javascript:void(0);" onclick="document.getElementById('itemrowmore$i').style.display='none';document.getElementById('itemrow$j').style.display='block';">Add another item ...</a>
</span>
EOHTML;
	}

	$html .= <<<EOHTML
</li>
EOHTML;

	print $html;

}

function suppliercontact_select($display,$name,$selected,$suppid='') {
	global $dbsite;
	global $errors;

		if((!isset($id))||($id == "")){
		$id = $name;
	}

	$html = "<li>\n<div id=contactlist><label for=\"contactsid\"";

	if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";

	$html .= ">$display</label>\n<select class=\"form-control\" name=contactsid><option value=\"0\">None</option>\n";

	$sqltext = "SELECT contactsid, fname,sname,role FROM contacts";
	if ( (isset($suppid)) && (is_numeric($suppid)) ) $sqltext .= " WHERE suppid=" . $suppid ;
	$sqltext .= " ORDER BY contactsid";

	#print $sqltext;
	$res = $dbsite->query($sqltext); # or die("Cant get customers");

	foreach($res as $r) {


		if($selected == $r->contactsid){
			$sel = ' selected="selected"';
		}else{
			$sel = '';
		}

		$html .= <<<EOT
<option value="{$r->contactsid}" $sel>{$r->fname} {$r->sname}</option>\n
EOT;

	}
	$html .= "</select></div></li>\n\n";

	print $html;

}

