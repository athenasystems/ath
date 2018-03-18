<?php

function html_shiftselect ($display, $name, $value = "", $showtime = "n", $return = 'print', $epoch='') {
	global $errors;


	$valueS = date("l",$epoch);
	$value = $value['year'] ."-". $value['month'] ."-". $value['day'] . " " . $value['hour'] . ":" . $value['minute'] . ":00";

	#print $value;
	$cur_year = intval(date("Y", strtotime("now")));

	$date = strtotime($value);

	if($cur_year > intval(date("Y", $date))) $cur_year = intval(date("Y", $date));
	$html = "<li style=\"font-size:120%;\">\n";
	$html .= "\n<label for=\"". $name ."_day\" style=\"width:220px;\">$display</label>\n";

	$html .= "<input type=hidden name=\"".$name."[day]\" id=\"". $name ."_day\" value=\"" . intval(date("d", $date)) . "\">\n";

	$html .= "<input type=hidden name=\"".$name."[month]\" id=\"". $name ."_month\" value=\"" . intval(date("m", $date)) . "\">\n";

	$html .= "<input type=hidden name=\"".$name."[year]\" id=\"". $name ."_year\" value=\"" . intval(date("Y", $date)) . "\">\n";

	if($showtime == "y"){

		$html .= " <select class=\"form-control\" name=\"". $name ."[hour]\" id=\"". $name ."_hour\" >\n";

		for($i=0; $i <= 23; $i++){

			$html .= "\t<option value=\"". date("H", strtotime("2006-01-01 ". $i .":00:00")) ."\"";
			if ($i == date("G", $date)) $html .= " selected=\"selected\"";
			$html .= ">". date("H", strtotime("2006-01-01 ". $i .":00"))."</option>\n";

		}

		$html .= "</select>:";
		$html .= "<select class=\"form-control\" name=\"".$name."[minute]\" id=\"". $name ."_min\" >\n";

		for($i=0; $i <= 59; $i=$i+5){

			$html .= "\t<option value=\"". date("i", strtotime("2006-01-01 00:". $i .":00"))."\"";
			if ($i == date("i", $date)) $html .= " selected=\"selected\"";
			$html .= ">". date("i", strtotime("2006-01-01 00:". $i .":00"))."</option>\n";

		}

		$html .= "</select>\n";

	}

	$html .="</li>\n\n";

	if($return=='print'){
		print $html;
	}else{
		return $html;
	}

}

function html_file ($display, $name, $value = "", $path = "", $id = "", $help = "",$return = 'print') {
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

	if($return=='print'){
		print $html;
	}else{
		return $html;
	}
}

function customer_select($display,$name,$selected,$onsub = 0,$refreshcontact = 0) {
	global $errors;

	if((!isset($id))||($id == "")){
		$id = $name;
	}

	$html = "<div class=\"form-group row\"><label for=\"custid\"";

	if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";

	$html .= " class=\"col-sm-2 form-control-label\">$display</label><div class=\"col-sm-10\">\n<select class=\"form-control\" name=custid id=custid";

	if ($onsub == 1){
		$html .= " onchange=\"document.getElementById('from').value=0;document.getElementById('searchform').submit()\"";
	}
	if ($refreshcontact == 1){
		$html .= " onchange=\"refreshContact();\"";
	}

	$html .= " style=\"width:160px;\">";
	$html .= '<option value="0">Select Customer</option>' . "\n";

	$sqltext = "SELECT custid,co_name FROM cust WHERE live=1 ORDER BY co_name";

	$res = $dbsite->query($sqltext); # or die("Cant get customers");

	foreach($res as $r) {


		if($selected == $r->custid){
			$sel = ' selected="selected"';
		}else{
			$sel = '';
		}
		$nid = $r->custid;
		$nname = $r->co_name;
		$html .= <<<EOT
		<option value="$nid" $sel>$nname</option>\n
EOT;

	}
	$html .= "</select></div></div>\n\n";


	print $html;

}

function employee_status_select($display,$name,$selected) {
	global $errors;

	if((!isset($id))||($id == "")){
		$id = $name;
	}

	$html = "<li>\n<label for=\"status\"";

	if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";

	$html .= ">$display</label>";


	$html .= <<<EOT
		<select name=status id=status>
EOT;

	$statii = array('active','retired','left','temp');

	foreach ($statii as $stat){
		if($selected == $stat){
			$sel = ' selected="selected"';
		}else{
			$sel = '';
		}
		$html .= <<<EOT
		<option value="$stat" $sel>$stat</option>\n
EOT;
	}

	$html .= <<<EOT
		</select>
		</li>
EOT;

	print $html;

}

function supplier_select($display,$name,$selected,$onsub = 0,$refreshcontact = 0) {
	global $errors;

	if((!isset($id))||($id == "")){
		$id = $name;
	}

	$html = "<li>\n<label for=\"suppid\"";

	if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";

	$html .= ">$display</label>\n<select class=\"form-control\" name=suppid id=suppid";

	if ($onsub == 1){
		$html .= " onchange=\"document.getElementById('searchform').submit()\"";
	}
	if ($refreshcontact == 1){
		$html .= " onchange=\"refreshContact();\"";
	}

	$html .= ">";
	$html .= '<option value="0">Select Supplier</option>' . "\n";

	$sqltext = "SELECT suppid,co_name FROM supp ORDER BY co_name";

	$res = $dbsite->query($sqltext); # or die("Cant get suppliers");

	foreach($res as $r) {


		if($selected == $r->suppid){
			$sel = ' selected="selected"';
		}else{
			$sel = '';
		}
		$nid = $r->suppid;
		$nname = $r->co_name;
		$html .= <<<EOT
		<option value="$nid" $sel>$nname</option>\n
EOT;

	}
	$html .= "</select></li>\n\n";


	print $html;

}

function times_type_select($display,$name,$selected,$output=1, $label=1) {
	global $errors;
	global $dbsite;

	if((!isset($id))||($id == "")){
		$id = $name;
	}

	$html = "<li style=\"margin:4px;\">\n";

	if($label){
		$html .= "<label for=\"$name\"";
		if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";
		$html .= ">$display</label>\n";
	}else{
		$html .= "$display ";
	}


	$html .= "\n<select class=\"form-control\" name=$name id=$name";


	$html .= ">";
	$html .= '<option value="0">Select Type</option>' . "\n";

	$sqltext = "SELECT times_typesid,name FROM athcore.times_types ORDER BY times_typesid";

	$res = $dbsite->query($sqltext); # or die("Cant get times_types");

	foreach($res as $r) {


		if($selected == $r->times_typesid){
			$sel = ' selected="selected"';
		}else{
			$sel = '';
		}
		$nid = $r->times_typesid;
		$nname = $r->name;
		$html .= <<<EOT
		<option value="$nid" $sel title="$nname">$nname</option>\n
EOT;

	}
	$html .= <<<EOT
		</select>
		</li>
EOT;


	if($output){
		print $html;
	}else{
		return $html;
	}

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

	$reqDate = (($datereq!='')&&($datereq>0)) ? date("d-m-Y", $datereq) : '';
	$offDate = (($dateoff!='')&&($dateoff>0)) ? date("d-m-Y", $dateoff) : '';

	$j = $i + 1;

	$html = <<<EOHTML
<li style="display:$display;white-space:nowrap;border:1px solid #eee;" id="itemrow$i">
<div style="float:left;width:480px;">
<label for="itemcontent$i">Item $j Description</label>

<input type="text" name="item[$i][content]" id="itemcontent$i" value="$itemContent" style="width:490px;" />

</div>
<br clear="all">
<div style="float:left;width:300px;">


<div style="float:left;width:130px;">
<label for="itemdelivery$i">Delivery </label>
<input type="text" name="item[$i][delivery]" id="itemdelivery$i" value="$itemDelivery" style="width:90px;" />
Quantity <input type="text" name="item[$i][quantity]" id="itemquantity$i" value="$itemQuantity" style="width:50px;" />
Price &pound;&nbsp;<input type="text" name="item[$i][price]" id="itemprice$i" value="$itemPrice" style="width:80px;" />
<span style="white-space:nowrap;font-size:80%;">e.g. 2300 or 45.50</span>

</div>

</div>



<br clear="all">

<div style="width:300px;">
<label for="itemdateoff$i">Delivery Date Offered</label>
<input type="text" name="item[$i][dateoff]" id="itemdateoff$i" value="$offDate" style="width:90px;" />
<script language="JavaScript">
	var o_cal = new tcal ({
		'controlname': 'itemdateoff$i'
	});

</script>
EOHTML;

	//		if($datereq>0){
	//			html_hidden("item[$i][datereq]",$datereq);
	//$html .= <<<EOHTML
	// | Customer Requested Date: $reqDate
	//
	//EOHTML;
	//		}else{
	$html .= <<<EOHTML
			<span style="margin-left:30px;">Customer Requested Date:
			<input type="text" name="item[$i][datereq]" id="itemdatereq$i" value="$reqDate" style="width:90px;" /> </span>
<script language="JavaScript">
	var o_cal = new tcal ({
		'controlname': 'itemdatereq$i'
	});

</script>
EOHTML;

	//		}
	$html .= <<<EOHTML
</div>
<input type="hidden" name="item[$i][itemsid]" id="itemsid$i" value="$itemsid" />
<br><br><br>

EOHTML;
	#

	if(($itemContent == '')&&($itemDelivery == '')&&($itemPrice == '')){
		$html .= <<<EOHTML
<br clear="both"><span id="itemrowmore$i" style="font-size:70%;margin-left:153px">
<a href="javascript:void(0);" onclick="document.getElementById('itemrowmore$i').style.display='none';document.getElementById('itemrow$j').style.display='block';">Add another item ...</a>
</span>
EOHTML;
	}

	$html .= <<<EOHTML
</li>
EOHTML;

	print $html;

}

function fileBlock($i, $display='none') {
	global $errors;

	#$htmlFile = html_file("Add file to Quote?", "quotefile[$i]",'','','','','return');
	$j = $i + 1;
	$name="quotefile$i";
	$id = $name;
	$title="Add file to Quote?";

	$html .= <<<EOHTML

	<li style="display:$display;white-space:nowrap;border:1px solid #eee;" id="filerow$i">
EOHTML;

	$html .= "<label for=\"$id\"";

	if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";

	$html .= ">$title</label>\n";

	$html .= "<input type=\"file\" name=\"$name\" id=\"$id\"  />";

	if($help != ""){
		$html .= "<span class=\"help\">$help</span>";
	}


	$html .= <<<EOHTML
<br clear="both">

<span id="filerowmore$i" style="font-size:70%;margin-left:153px">
<a href="javascript:void(0);" onclick="document.getElementById('filerowmore$i').style.display='none';document.getElementById('filerow$j').style.display='block';">Add another file ...</a>
</span>

</li>

EOHTML;

	print $html;

}

function quote_select($display,$name,$selected,$onsub = 0) {
	global $errors;

	if((!isset($id))||($id == "")){
		$id = $name;
	}

	$html = "<li>\n<label for=\"quoteno\"";

	if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";

	$html .= ">$display</label>\n<select class=\"form-control\" name=quoteno";

	if ($onsub == 1){
		$html .= " onchange=\"document.getElementById('searchform').submit()\"";
	}

	$html .= ">";
	$html .= '<option value="0">No Quote</option>' . "\n";

	$sqltext = "SELECT quoteno FROM quotes WHERE quotesid>0 ORDER BY quotesid DESC LIMIT 24";

	$res = $dbsite->query($sqltext); # or die("Cant get quotes");

	foreach($res as $r) {


		if($selected == $r->quoteno){
			$sel = ' selected="selected"';
		}else{
			$sel = '';
		}
		$nid = $r->quoteno;

		$html .= <<<EOT
<option value="$nid" $sel>$nid</option>\n
EOT;

	}
	$html .= "</select></li>\n\n";


	print $html;

}

function jobsid_select($display,$name,$selected) {
	global $errors;

	$html = "<li>\n<label for=\"$name\"";

	if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";

	$html .= ">$display</label>\n<select class=\"form-control\" name=$name>";

	$html .= '<option value="0">None</option>' . "\n";

	$sqltext = "SELECT jobs.incept,jobs.jobno,jobs.jobsid FROM jobs,items,quotes,cust
	WHERE items.itemsid=jobs.itemsid
	AND items.quotesid=quotes.quotesid
	AND quotes.custid=cust.custid
	ORDER BY jobsid DESC";

	$res = $dbsite->query($sqltext); # or die("Cant get Job Select");

	foreach($res as $r) {


		$jobsid = $r->jobsid;
		$jobno = $r->jobno;
		$date = date("d/m/y",$r->incept);

		if(($selected == $r->jobsid)&&($r->jobsid)){
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

function jobsid_hours_select($display,$name,$selected) {
	global $errors;

	$html = "<li>\n<label for=\"$name\"";

	if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";

	$html .= ">$display</label>\n<select class=\"form-control\" name=$name>";

	$html .= '<option value="0">None</option>' . "\n";

	$sqltext = "SELECT jobs.incept,jobs.jobno,jobs.jobsid FROM jobs,items,quotes,cust
	WHERE items.itemsid=jobs.itemsid
	AND items.quotesid=quotes.quotesid
	AND quotes.custid=cust.custid
	ORDER BY jobsid DESC";

	$res = $dbsite->query($sqltext); # or die("Cant get Job Select");

	foreach($res as $r) {


		$jobsid = $r->jobsid;
		$jobno = $r->jobno;
		$date = date("d/m/y",$r->incept);

		if(($selected == $r->jobsid)&&($r->jobsid)){
			$sel = ' selected="selected"';
		}else{
			$sel = '';
		}

		$html .= <<<EOT
<option value="$jobsid" $sel>$jobno - $date</option>\n
EOT;

	}
	$html .= "</select><input type='submit' value='Go'></li>\n\n";


	print $html;

}

function jobsid_delivery_select($display,$name,$selected) {
	global $errors;

	$html = "<li>\n<label for=\"$name\"";

	if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";

	$html .= ">$display</label>\n<select class=\"form-control\" name=$name id=$name onchange='job_del_refresh();'>";

	$html .= '<option value="0">None</option>' . "\n";

	$sqltext = "SELECT jobs.incept,jobs.jobno,jobs.jobsid FROM jobs,items,quotes,cust
	WHERE items.itemsid=jobs.itemsid
	AND items.quotesid=quotes.quotesid
	AND quotes.custid=cust.custid

	ORDER BY jobsid DESC";
	#AND (jobs.stagesid=7 OR jobs.stagesid=8)
	$res = $dbsite->query($sqltext); # or die("Cant get Job Select");

	foreach($res as $r) {


		$jobsid = $r->jobsid;
		$jobno = $r->jobno;
		$date = date("d/m/y",$r->incept);

		if(($selected == $r->jobsid)&&($r->jobsid)){
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

function suppliercontact_select($display,$name,$selected,$suppid='') {
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

function event_select($display,$name,$selected) {
	global $errors;

	if((!isset($id))||($id == "")){
		$id = $name;
	}

	$html = "<li>\n<label for=\"eventsid\"";

	if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";

	$html .= ">$display</label>\n<select class=\"form-control\" name=eventsid>";

	$html .= '<option value="0">All Events</option>' . "\n";

	$sqltext = "SELECT * FROM athcore.events ORDER BY eventsid";

	$res = $dbsite->query($sqltext); # or die("Cant get eventsid");

	foreach($res as $r) {


		$eventsid = $r->eventsid;
		$eventName = $r->name;

		if($selected == $r->eventsid){
			$sel = ' selected="selected"';
		}else{
			$sel = '';
		}

		$html .= <<<EOT
<option value="$eventsid" $sel>$eventName</option>\n
EOT;

	}
	$html .= "</select> </li>\n\n";


	print $html;

}

function yes_no_select($display,$name,$selected=0) {
	global $errors;

	if((!isset($id))||($id == "")){
		$id = $name;
	}

	$html = "<li>\n<label for=\"$name\"";

	if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";

	$html .= ">$display</label>\n<select class=\"form-control\" name=$name>";

	if($selected == 0){
		$html .= '<option value="0" selected="selected">No</option>' . "\n";
	}else{
		$html .= '<option value="0">No</option>' . "\n";
	}

	if($selected == 1){
		$html .= '<option value="1" selected="selected">Yes</option>' . "\n";
	}else{
		$html .= '<option value="1">Yes</option>' . "\n";
	}

	$html .= "</select> </li>\n\n";


	print $html;

}

function supp_class_select($display,$name,$selected) {
	global $errors;

	if((!isset($id))||($id == "")){
		$id = $name;
	}

	$html = "<li>\n<label for=\"eventsid\"";

	if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";

	$html .= ">$display</label>\n<select class=\"form-control\" name=$name>";

	$html .= '<option value="0">Select Status</option>' . "\n";

	$sta = array("Customer Nominated","3rd Party Registration Required (e.g., mandated by customer, Nadcap or required by business)","Stockists","Sub-contracted product (e.g., Wet Processing, Welding, Machining, NDT etc.)","Indirect Supplier (e.g. Toolmakers, Calibration houses, Transport ETC.)","Delegation of Verification");

	foreach($sta as $status){

		if($selected == $status){
			$sel = ' selected="selected"';
		}else{
			$sel = '';
		}

		$html .= <<<EOT
<option value="$status" $sel>$status</option>\n
EOT;

	}
	$html .= "</select> </li>\n\n";


	print $html;

}

function supplier_status_select($display,$name,$selected) {
	global $errors;

	if((!isset($id))||($id == "")){
		$id = $name;
	}

	$html = "<li>\n<label for=\"eventsid\"";

	if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";

	$html .= ">$display</label>\n<select class=\"form-control\" name=$name>";

	$html .= '<option value="0">Select Status</option>' . "\n";

	$sta = array("Approved","Conditionally Approved","Dissapproved");

	foreach($sta as $status){

		if($selected == $status){
			$sel = ' selected="selected"';
		}else{
			$sel = '';
		}

		$html .= <<<EOT
<option value="$status" $sel>$status</option>\n
EOT;

	}
	$html .= "</select> </li>\n\n";


	print $html;

}

function days_select($display,$name,$selected) {
	global $errors;

	if((!isset($id))||($id == "")){
		$id = $name;
	}

	$html = "<li>\n<label for=\"days\"";

	if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";

	$html .= ">$display</label>\n<select class=\"form-control\" name=days>";

	$html .= '<option value="1">1 Day</option>' . "\n";

	for ( $counter = 7; $counter <= 370; $counter += 7) {

		if($selected == $counter){
			$sel = ' selected="selected"';
		}else{
			$sel = '';
		}

		$html .= <<<EOT
<option value="$counter" $sel>$counter Days</option>\n
EOT;

	}

	$html .= "</select> <input type=submit name=todo value=Go class=clickable /> </li>\n\n";


	print $html;

}

function recur_select($display,$name,$selected) {
	global $errors;

	if((!isset($id))||($id == "")){
		$id = $name;
	}

	$html = "<li>\n<label for=\"every\"";

	if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";

	$html .= ">$display</label>\n<select class=\"form-control\" name=every>";

	$html .= '<option value="0">Select Time Interval</option>' . "\n";

	$intervals = array("Day","Week","Month","Quarter","Year");
	$intervalues = array("d","w","m","q","y");

	for ( $counter = 0; $counter <= 4; $counter++) {

		if($selected == $intervalues[$counter]){
			$sel = ' selected="selected"';
		}else{
			$sel = '';
		}
		$val = $counter + 1;
		$html .= <<<EOT
<option value="$intervalues[$counter]" $sel>$intervals[$counter]</option>\n
EOT;

	}

	$html .= "</select></li>";

	print $html;

}

function html_radios($display, $name, $group, $selected='', $return='print') {

	global $errors;

	//	$html = "<li><h2";
	//	if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";
	//	$html .=" >$display</h2>\n";

	foreach($group as $item => $display){
		$html .= '<span style="border:1px solid #999;padding:2px;margin:1px;">';

		$html .= "<label for=\"{$item}_radio_\"";
		if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";
		$html .= "  style=\"margin:2px;padding;1px;\">$display</label>\n";

		$html .= "<input type=\"radio\" name=\"$name\" id=\"{$item}_radio_\" value=\"$item\"";

		if(isset($selected) && ($selected == $item)) $html .= " checked=\"checked\"";

		if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";

		$html .= "></span>\n";

	}

	$html .= "<br clear=all /></li>\n\n";


	if($return=='print'){
		print $html;
	}else{
		return $html;
	}
}
