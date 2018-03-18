<?php

function html_shiftselect($display, $name, $value = "", $showtime = "n", $return = 'print', $epoch = '')
{
    global $errors;
    
    $valueS = date("l", $epoch);
    $value = $value['year'] . "-" . $value['month'] . "-" . $value['day'] . " " . $value['hour'] . ":" . $value['minute'] . ":00";
    
    // print $value;
    $cur_year = intval(date("Y", strtotime("now")));
    
    $date = strtotime($value);
    
    if ($cur_year > intval(date("Y", $date)))
        $cur_year = intval(date("Y", $date));
    $html = "<li style=\"font-size:120%;\">\n";
    $html .= "\n<label for=\"" . $name . "_day\" style=\"width:220px;\">$display</label>\n";
    
    $html .= "<input type=hidden name=\"" . $name . "[day]\" id=\"" . $name . "_day\" value=\"" . intval(date("d", $date)) . "\">\n";
    
    $html .= "<input type=hidden name=\"" . $name . "[month]\" id=\"" . $name . "_month\" value=\"" . intval(date("m", $date)) . "\">\n";
    
    $html .= "<input type=hidden name=\"" . $name . "[year]\" id=\"" . $name . "_year\" value=\"" . intval(date("Y", $date)) . "\">\n";
    
    if ($showtime == "y") {
        
        $html .= " <select class=\"form-control\" name=\"" . $name . "[hour]\" id=\"" . $name . "_hour\" >\n";
        
        for ($i = 0; $i <= 23; $i ++) {
            
            $html .= "\t<option value=\"" . date("H", strtotime("2006-01-01 " . $i . ":00:00")) . "\"";
            if ($i == date("G", $date))
                $html .= " selected=\"selected\"";
            $html .= ">" . date("H", strtotime("2006-01-01 " . $i . ":00")) . "</option>\n";
        }
        
        $html .= "</select>:";
        $html .= "<select class=\"form-control\" name=\"" . $name . "[minute]\" id=\"" . $name . "_min\" >\n";
        
        for ($i = 0; $i <= 59; $i = $i + 5) {
            
            $html .= "\t<option value=\"" . date("i", strtotime("2006-01-01 00:" . $i . ":00")) . "\"";
            if ($i == date("i", $date))
                $html .= " selected=\"selected\"";
            $html .= ">" . date("i", strtotime("2006-01-01 00:" . $i . ":00")) . "</option>\n";
        }
        
        $html .= "</select>\n";
    }
    
    $html .= "</li>\n\n";
    
    if ($return == 'print') {
        print $html;
    } else {
        return $html;
    }
}

function html_file($display, $name, $value = "", $path = "", $id = "", $help = "", $return = 'print')
{
    global $errors;
    
    if (isset($id) && ($id == ""))
        $id = $name;
    
    $html = "<div class=\"form-group row\"><label for=\"$id\"";
    
    if (isset($errors) && in_array($name, $errors))
        $html .= " class=\"error\"";
    
    $html .= " class=\"col-sm-2 form-control-label\">$display</label>\n";
    
    $html .= "<div class=\"col-sm-10\"><input type=\"file\" name=\"$name\" id=\"$id\"  >";
    
    if ($path != "" && $value != "")
        $html .= " Currently set to <a href=\"$path$value\" title=\"$value\">$value</a>.";
    
    if ($help != "") {
        $html .= "<span class=\"help\">$help</span>";
    }
    
    $html .= "</div></div>";
    
    if ($return == 'print') {
        print $html;
    } else {
        return $html;
    }
}

function job_select($display, $name, $custid, $selected)
{
    global $dbsite;
    global $errors;
    
    $html = "<div class=\"form-group row\"><label for=\"$name\"";
    
    if (isset($errors) && in_array($name, $errors))
        $html .= " class=\"error\"";
    
    $html .= " class=\"col-sm-2 form-control-label\">$display</label>
	<div class=\"col-sm-10\">
	<select class=\"form-control\" name=$name>";
    
    $html .= '<option value="0">None</option>' . "\n";
    
    $sqltext = "SELECT jobno,jobsid,incept,co_name,jobs.custid
	FROM jobs,cust
	WHERE jobs.custid=cust.custid";
    
    if ((isset($custid)) && (is_numeric($custid))) {
        $sqltext .= " AND jobs.custid=" . $custid;
    }
    
    $sqltext .= " ORDER BY jobsid DESC";
    
    $res = $dbsite->query($sqltext); // or die("Cant get jobno");
    
    foreach ($res as $r) {
        
        $jobsid = $r->jobsid;
        $jobno = $r->jobno;
        $date = date("d/m/y", $r->incept);
        $co_name = $r->co_name;
        
        if ($selected == $r->jobsid) {
            $sel = ' selected="selected"';
        } else {
            $sel = '';
        }
        
        $html .= <<<EOT
<option value="$jobsid" $sel>Job No: $jobno - $date for $co_name</option>\n
EOT;
    }
    $html .= "</select></div></div>";
    
    print $html;
}

function customer_select($display, $name, $selected, $onsub = 0, $refreshcontact = 0)
{
    global $errors;
    global $dbsite;
    
    $html = "<div class=\"form-group row\"><label for=\"custid\"";
    
    if (isset($errors) && in_array($name, $errors))
        $html .= " class=\"error\"";
    
    $html .= " class=\"col-sm-2 form-control-label\">$display</label><div class=\"col-sm-10\">\n";
    $html .= " <select class=\"form-control\" name=$name id=$name";
    
    if ($onsub == 1) {
        $html .= " onchange=\"document.getElementById('from').value=0;document.getElementById('searchform').submit()\"";
    }
    if ($refreshcontact == 1) {
        $html .= " onchange=\"refreshContact();\"";
    }
    
    if ($onsub == 2) {
        $html .= " onchange=\"refreshJobs();\"";
    }
    
    $html .= " >";
    $html .= '<option value="">Select Customer</option>' . "\n";
    
    $sqltext = "SELECT custid,co_name FROM cust WHERE custid>0 AND live=1 ORDER BY co_name";
    
    $res = $dbsite->query($sqltext); // or die("Cant get customers");
    foreach ($res as $r) {
        
        if ($selected == $r->custid) {
            $sel = ' selected="selected"';
        } else {
            $sel = '';
        }
        $nid = $r->custid;
        $nname = $r->co_name;
        $html .= <<<EOT
		<option value="$nid" $sel>$nname</option>\n
EOT;
    }
    $html .= "</select></div></div>";
    
    print $html;
}

function customer_select_search($display, $name, $selected, $onsub = 0, $refreshcontact = 0, $return = 'print')
{
    global $errors;
    global $dbsite;
    
    $html = "<select class=\"form-control\" name=$name id=$name";
    
    if ($onsub == 1) {
        $html .= " onchange=\"document.getElementById('from').value=0;document.getElementById('searchform').submit()\"";
    }
    if ($refreshcontact == 1) {
        $html .= " onchange=\"refreshContact();\"";
    }
    
    $html .= " >";
    $html .= '<option value="">Search by Customer</option>' . "\n";
    
    $sqltext = "SELECT custid,co_name FROM cust WHERE custid>0 AND live=1 ORDER BY co_name";
    
    $res = $dbsite->query($sqltext); // or die("Cant get customers");
    
    foreach ($res as $r) {
        
        if ($selected == $r->custid) {
            $sel = ' selected="selected"';
        } else {
            $sel = '';
        }
        $nid = $r->custid;
        $nname = $r->co_name;
        $html .= <<<EOT
		<option value="$nid" $sel>$nname</option>\n
EOT;
    }
    $html .= "</select>\n";
    
    if ($return == 'print') {
        print $html;
    } else {
        return $html;
    }
}

function customer_invoice_select($display, $name, $selected, $refreshcontact = 1)
{
    global $errors;
    global $dbsite;
    global $sitesid;
    
    $html = "<div class=\"form-group row\"><label for=\"custid\" class=\"";
    
    if (isset($errors) && in_array($name, $errors))
        $html .= " error";
    
    $html .= " col-sm-2 form-control-label\">$display</label>
	<div class=\"col-sm-10\">\n
	<select class=\"form-control\" style=\"width:300px\" name=custid id=custid";
    
    $html .= " onchange=\"refreshInvoiceContact();\"";
    
    $html .= " >";
    $html .= '<option value="0">Select Customer</option>' . "\n";
    
    $sqltext = "SELECT custid,co_name FROM cust WHERE custid>0 AND live=1  ORDER BY co_name";
    
    $res = $dbsite->query($sqltext); // or die("Cant get customers");
    
    foreach ($res as $r) {
        
        if ($selected == $r->custid) {
            $sel = ' selected="selected"';
        } else {
            $sel = '';
        }
        $nid = $r->custid;
        $nname = $r->co_name;
        $html .= <<<EOT
		<option value="$nid" $sel>$nname</option>\n
EOT;
    }
    $html .= "</select></div></div>";
    
    print $html;
}

function customer_quote_select($display, $name, $selected, $refreshcontact = 1)
{
    global $errors;
    global $dbsite;
    global $sitesid;
    
    $html = "<div class=\"form-group row\"><label for=\"custid\" class=\"";
    
    if (isset($errors) && in_array($name, $errors))
        $html .= " error";
    
    $html .= " col-sm-2 form-control-label\">$display</label>
	<div class=\"col-sm-10\">\n
	<select class=\"form-control\" style=\"width:300px\" name=custid id=custid";
    
    $html .= " onchange=\"refreshQuotesContact();\"";
    
    $html .= " >";
    $html .= '<option value="0">Select Customer</option>' . "\n";
    
    $sqltext = "SELECT custid,co_name FROM cust WHERE custid>0 AND live=1  ORDER BY co_name";
    
    $res = $dbsite->query($sqltext); // or die("Cant get customers");
    
    foreach ($res as $r) {
        
        if ($selected == $r->custid) {
            $sel = ' selected="selected"';
        } else {
            $sel = '';
        }
        $nid = $r->custid;
        $nname = $r->co_name;
        $html .= <<<EOT
		<option value="$nid" $sel>$nname</option>\n
EOT;
    }
    $html .= "</select></div></div>";
    
    print $html;
}

function employee_status_select($display, $name, $selected)
{
    global $errors;
    
    $html = "<div class=\"form-group row\"><label for=\"status\"";
    
    if (isset($errors) && in_array($name, $errors))
        $html .= " class=\"error\"";
    
    $html .= " class=\"col-sm-2 form-control-label\">$display</label><div class=\"col-sm-10\">";
    
    $html .= <<<EOT
		<select name=status id=status>
EOT;
    
    $statii = array(
        'active',
        'retired',
        'left',
        'temp'
    );
    
    foreach ($statii as $stat) {
        if ($selected == $stat) {
            $sel = ' selected="selected"';
        } else {
            $sel = '';
        }
        $html .= <<<EOT
		<option value="$stat" $sel>$stat</option>\n
EOT;
    }
    
    $html .= <<<EOT
		</select></div></div>

EOT;
    
    print $html;
}

function supplier_select($display, $name, $selected, $onsub = 0, $refreshcontact = 0)
{
    global $errors;
    global $dbsite;
    
    $html = "<div class=\"form-group row\">\n<label for=\"suppid\"";
    
    if (isset($errors) && in_array($name, $errors))
        $html .= " class=\"error\"";
    
    $html .= " class=\"col-sm-2 form-control-label\">$display</label><div class=\"col-sm-10\">\n<select class=\"form-control\" name=suppid id=suppid";
    
    if ($onsub == 1) {
        $html .= " onchange=\"document.getElementById('searchform').submit()\"";
    }
    if ($refreshcontact == 1) {
        $html .= " onchange=\"refreshContact();\"";
    }
    
    $html .= ">";
    $html .= '<option value="0">Select Supplier</option>' . "\n";
    
    $sqltext = "SELECT suppid,co_name FROM supp ORDER BY co_name";
    
    $res = $dbsite->query($sqltext); // or die("Cant get suppliers");
    
    foreach ($res as $r) {
        
        if ($selected == $r->suppid) {
            $sel = ' selected="selected"';
        } else {
            $sel = '';
        }
        $nid = $r->suppid;
        $nname = $r->co_name;
        $html .= <<<EOT
		<option value="$nid" $sel>$nname</option>\n
EOT;
    }
    $html .= "</select></div></div>\n\n";
    
    print $html;
}

function times_type_select($display, $name, $selected, $output = 1, $label = 1)
{
    global $errors;
    global $dbsys;
    
    $html = "<li style=\"margin:4px;\">\n";
    
    if ($label) {
        $html .= "<label for=\"$name\"";
        if (isset($errors) && in_array($name, $errors))
            $html .= " class=\"error\"";
        $html .= ">$display</label>\n";
    } else {
        $html .= "$display ";
    }
    
    $html .= "\n<select class=\"form-control\" name=$name id=$name";
    
    $html .= ">";
    $html .= '<option value="0">Select Type</option>' . "\n";
    
    $sqltext = "SELECT times_typesid,name FROM athcore.times_types ORDER BY times_typesid";
    
    $res = $dbsys->query($sqltext) or die("Cant get times_types");
    
    foreach ($res as $r) {
        
        if ($selected == $r->times_typesid) {
            $sel = ' selected="selected"';
        } else {
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
    
    if ($output) {
        print $html;
    } else {
        return $html;
    }
}

function itemBlock($i, $itemArray, $itemsid = '', $display = 'none', $last = '')
{
    global $errors;
    global $siteMods;
    
    $qitemsid = $itemArray['qitemsid'];
    $itemContent = $itemArray['content'];
    $itemSinglePrice = $itemArray['singleprice'];
    $itemQuantity = $itemArray['quantity'];
    $itemPrice = $itemArray['price'];
    $itemHours = $itemArray['hours'];
    $itemRate = $itemArray['rate'];
    
    $item = 'item' . $i;
    
    $quantityDisplay = 'none';
    $hourlyDisplay = 'none';
    $priceDisplay = 'none';
    
    $priceChk = '';
    $hoursChk = '';
    $quantityChk = '';
    
    if (is_numeric($itemSinglePrice) && ($itemSinglePrice > 0)) {
        $priceDisplay = 'block';
        $priceChk = 'checked="checked"';
    } elseif (is_numeric($itemPrice) && ($itemPrice > 0)) {
        $quantityDisplay = 'block';
        $quantityChk = 'checked="checked"';
    } elseif (is_numeric($itemQuantity) && ($itemQuantity > 0)) {
        $quantityDisplay = 'block';
        $quantityChk = 'checked="checked"';
    } elseif (is_numeric($itemHours) && ($itemHours > 0)) {
        $hourlyDisplay = 'block';
        $hoursChk = 'checked="checked"';
    }
    
    if (isset($_POST[item][$i]['swapTo'])) {
        
        if ($_POST[item][$i]['swapTo'] == 'price') {
            $priceDisplay = 'block';
            $priceChk = 'checked="checked"';
            $display = 'block';
        }
        
        if ($_POST[item][$i]['swapTo'] == 'quantity') {
            $quantityDisplay = 'block';
            $quantityChk = 'checked="checked"';
            $display = 'block';
        }
        
        if ($_POST[item][$i]['swapTo'] == 'hours') {
            $hourlyDisplay = 'block';
            $hoursChk = 'checked="checked"';
            $display = 'block';
        }
    }
    
    if ($display == 'dev') {
        if (($i == 0)) {
            $priceDisplay = 'block';
        } elseif (($i % 2)) {
            $quantityDisplay = 'block';
        } else {
            $hourlyDisplay = 'block';
        }
        $display = 'block';
    }
    
    if (($itemContent != '') || ($itemPrice != '') || ($itemHours != '')) {
        $display = 'block';
    }
    
    // $itemLineTotal=$itemPrice;
    
    $valStateContent = '';
    if (isset($errors) && in_array("item[$i][content]", $errors)) {
        $valStateContent = 'has-error';
    }
    
    $valStateRadio = '';
    if (isset($errors) && in_array("item[$i][swapTo]", $errors)) {
        $valStateRadio = 'has-error';
    }
    
    $valStateSinglePrice = '';
    if (isset($errors) && in_array("item[$i][singleprice]", $errors)) {
        $valStateSinglePrice = 'has-error';
        $priceDisplay = 'block';
        $priceChk = 'checked="checked"';
    }
    
    $valStateQuantity = '';
    if (isset($errors) && in_array("item[$i][quantity]", $errors)) {
        $valStateQuantity = 'has-error';
        $quantityDisplay = 'block';
        $quantityChk = 'checked="checked"';
    }
    $valStatePrice = '';
    if (isset($errors) && in_array("item[$i][price]", $errors)) {
        $valStatePrice = 'has-error';
        $quantityDisplay = 'block';
        $quantityChk = 'checked="checked"';
    }
    
    $valStateHours = '';
    if (isset($errors) && in_array("item[$i][hours]", $errors)) {
        $valStateHours = 'has-error';
        $hourlyDisplay = 'block';
        $hoursChk = 'checked="checked"';
    }
    $valStateRate = '';
    if (isset($errors) && in_array("item[$i][rate]", $errors)) {
        $valStateRate = 'has-error';
        $hourlyDisplay = 'block';
        $hoursChk = 'checked="checked"';
    }
    
    $j = $i + 1;
    
    $stockblock = '';
    if (isset($siteMods['stock'])) {
        $stockSelect = stock_select('Stock', 'stockid', '', $i);
        $stockblock = <<<EOHTML
<div style="float: right;">$stockSelect
<a href="javascript:void(0);" onclick="addStockToItem($i)">
Add Stock Item</a>
</div>
EOHTML;
    }
    $morehtml = '';
    if (($itemContent == '') || ($last != '')) {
        $morehtml = <<<EOHTML
<br clear="both"><span id="itemrowmore$i">
<a href="javascript:void(0);" onclick="document.getElementById('itemrowmore$i').style.display='none';document.getElementById('itemrow$j').style.display='block';">Add another item ...</a>
</span>
EOHTML;
    }
    
    include '/srv/ath/src/php/tmpl/item.php';
    
    // print $html;
}

function check_items($items)
{
    $errs = array();
    $cnt = 0;
    foreach ($items as $item) {
        
        if (($item['content'] == '') && ($item['price'] == '') && ($item['quantity'] == '') && ($item['hours'] == '') && ($item['rate'] == '') && ($cnt > 0) && (! isset($item['swapTo']))) {
            continue;
        }
        
        if ($item['content'] == '') {
            // && (($item['price'] != '')||($item['quantity']!= '')||($item['hours'] != '')||($item['rate']!=''))){
            $errs[] = "item[$cnt][content]";
        }
        
        if ((! isset($item['swapTo'])) && ($_GET['d'] != 1)) {
            $errs[] = "item[$cnt][swapTo]";
        }
        
        // if($item['content'] != ''){
        
        if (($item['swapTo'] == 'price') && (($item['singleprice'] == '') || ($item['singleprice'] == 0))) {
            $errs[] = "item[$cnt][singleprice]";
        }
        
        if (($item['swapTo'] == 'quantity') && (($item['price'] == '') || ($item['price'] == 0))) {
            $errs[] = "item[$cnt][price]";
        }
        
        if (($item['swapTo'] == 'quantity') && (($item['quantity'] == '') || ($item['quantity'] == 0))) {
            $errs[] = "item[$cnt][quantity]";
        }
        
        if (($item['swapTo'] == 'hours') && (($item['hours'] == '') || ($item['hours'] == 0))) {
            $errs[] = "item[$cnt][hours]";
        }
        
        if (($item['swapTo'] == 'hours') && (($item['rate'] == '') || ($item['rate'] == 0))) {
            $errs[] = "item[$cnt][rate]";
        }
        // }
        $cnt ++;
    }
    return $errs;
}

function fileBlock($i, $display = 'none')
{
    global $errors;
    
    // $htmlFile = html_file("Add file to Quote?", "quotefile[$i]",'','','','','return');
    $j = $i + 1;
    $name = "quotefile$i";
    $title = "Add file to Quote?";
    
    $html .= <<<EOHTML

	<li style="display:$display;white-space:nowrap;border:1px solid #eee;" id="filerow$i">
EOHTML;
    
    $html .= "<label for=\"$name\"";
    
    if (isset($errors) && in_array($name, $errors))
        $html .= " class=\"error\"";
    
    $html .= ">$title</label>\n";
    
    $html .= "<input type=\"file\" name=\"$name\" id=\"$name\"  >";
    
    if ($help != "") {
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

function quote_select($display, $name, $selected, $onsub = 0)
{
    global $errors;
    global $dbsite;
    
    $html = "<li>\n<label for=\"quoteno\"";
    
    if (isset($errors) && in_array($name, $errors))
        $html .= " class=\"error\"";
    
    $html .= ">$display</label>\n<select class=\"form-control\" name=quoteno";
    
    if ($onsub == 1) {
        $html .= " onchange=\"document.getElementById('searchform').submit()\"";
    }
    
    $html .= ">";
    $html .= '<option value="0">No Quote</option>' . "\n";
    
    $sqltext = "SELECT quoteno FROM quotes WHERE quotesid>0 ORDER BY quotesid DESC LIMIT 24";
    
    $res = $dbsite->query($sqltext); // or die("Cant get quotes");
    
    foreach ($res as $r) {
        
        if ($selected == $r->quoteno) {
            $sel = ' selected="selected"';
        } else {
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

function jobsid_select($display, $name, $selected)
{
    global $errors;
    global $dbsite;
    
    $html = "<li>\n<label for=\"$name\"";
    
    if (isset($errors) && in_array($name, $errors))
        $html .= " class=\"error\"";
    
    $html .= ">$display</label>\n<select class=\"form-control\" name=$name>";
    
    $html .= '<option value="0">None</option>' . "\n";
    
    $sqltext = "SELECT jobs.incept,jobs.jobno,jobs.jobsid FROM jobs,items,quotes,cust
	WHERE items.itemsid=jobs.itemsid
	AND items.quotesid=quotes.quotesid
	AND quotes.custid=cust.custid
	ORDER BY jobsid DESC";
    
    $res = $dbsite->query($sqltext); // or die("Cant get Job Select");
    
    foreach ($res as $r) {
        
        $jobsid = $r->jobsid;
        $jobno = $r->jobno;
        $date = date("d/m/y", $r->incept);
        
        if (($selected == $r->jobsid) && ($r->jobsid)) {
            $sel = ' selected="selected"';
        } else {
            $sel = '';
        }
        
        $html .= <<<EOT
<option value="$jobsid" $sel>$jobno - $date</option>\n
EOT;
    }
    $html .= "</select></li>\n\n";
    
    print $html;
}

function jobsid_hours_select($display, $name, $selected)
{
    global $errors;
    global $dbsite;
    
    $html = "<li>\n<label for=\"$name\"";
    
    if (isset($errors) && in_array($name, $errors))
        $html .= " class=\"error\"";
    
    $html .= ">$display</label>\n<select class=\"form-control\" name=$name>";
    
    $html .= '<option value="0">None</option>' . "\n";
    
    $sqltext = "SELECT jobs.incept,jobs.jobno,jobs.jobsid FROM jobs,items,quotes,cust
	WHERE items.itemsid=jobs.itemsid
	AND items.quotesid=quotes.quotesid
	AND quotes.custid=cust.custid
	ORDER BY jobsid DESC";
    
    $res = $dbsite->query($sqltext); // or die("Cant get Job Select");
    
    foreach ($res as $r) {
        
        $jobsid = $r->jobsid;
        $jobno = $r->jobno;
        $date = date("d/m/y", $r->incept);
        
        if (($selected == $r->jobsid) && ($r->jobsid)) {
            $sel = ' selected="selected"';
        } else {
            $sel = '';
        }
        
        $html .= <<<EOT
<option value="$jobsid" $sel>$jobno - $date</option>\n
EOT;
    }
    $html .= "</select><input type='submit' value='Go'></li>\n\n";
    
    print $html;
}

function jobsid_delivery_select($display, $name, $selected)
{
    global $errors;
    global $dbsite;
    
    $html = "<li>\n<label for=\"$name\"";
    
    if (isset($errors) && in_array($name, $errors))
        $html .= " class=\"error\"";
    
    $html .= ">$display</label>\n<select class=\"form-control\" name=$name id=$name onchange='job_del_refresh();'>";
    
    $html .= '<option value="0">None</option>' . "\n";
    
    $sqltext = "SELECT jobs.incept,jobs.jobno,jobs.jobsid FROM jobs,items,quotes,cust
	WHERE items.itemsid=jobs.itemsid
	AND items.quotesid=quotes.quotesid
	AND quotes.custid=cust.custid

	ORDER BY jobsid DESC";
    // AND (jobs.stagesid=7 OR jobs.stagesid=8)
    $res = $dbsite->query($sqltext); // or die("Cant get Job Select");
    
    foreach ($res as $r) {
        
        $jobsid = $r->jobsid;
        $jobno = $r->jobno;
        $date = date("d/m/y", $r->incept);
        
        if (($selected == $r->jobsid) && ($r->jobsid)) {
            $sel = ' selected="selected"';
        } else {
            $sel = '';
        }
        
        $html .= <<<EOT
<option value="$jobsid" $sel>$jobno - $date</option>\n
EOT;
    }
    $html .= "</select></li>\n\n";
    
    print $html;
}

function suppliercontact_select($display, $name, $selected, $suppid = '')
{
    global $errors;
    global $dbsite;
    
    $html = "<div id=contactlist><label for=\"contactsid\"";
    
    if (isset($errors) && in_array($name, $errors))
        $html .= " class=\"error\"";
    
    $html .= ">$display</label>\n<select class=\"form-control\" name=contactsid><option value=\"0\">None</option>\n";
    
    $sqltext = "SELECT contactsid, fname,sname,role FROM contacts";
    if ((isset($suppid)) && (is_numeric($suppid)))
        $sqltext .= " WHERE suppid=" . $suppid;
    $sqltext .= " ORDER BY contactsid";
    
    // print $sqltext;
    $res = $dbsite->query($sqltext); // or die("Cant get customers");
    
    foreach ($res as $r) {
        
        if ($selected == $r->contactsid) {
            $sel = ' selected="selected"';
        } else {
            $sel = '';
        }
        
        $html .= <<<EOT
<option value="{$r->contactsid}" $sel>{$r->fname} {$r->sname}</option>\n
EOT;
    }
    $html .= "</select></div>";
    
    print $html;
}

function stock_select($display, $name, $selected, $i)
{
    global $errors;
    global $dbsite;
    
    $sqltext = "SELECT name,price FROM stock";
    $sqltext .= " ORDER BY stockid";
    // print $sqltext;
    $res = $dbsite->query($sqltext); // or die("Cant get customers");
    
    $html = "<select  name=stockid$i id=stockid$i>";
    
    foreach ($res as $r) {
        
        if ($selected == $r->stockid) {
            $sel = ' selected="selected"';
        } else {
            $sel = '';
        }
        
        $html .= <<<EOT
<option value="{$r->price}" $sel>{$r->name}</option>\n
EOT;
    }
    $html .= "</select>";
    
    return $html;
}

function event_select($display, $name, $selected)
{
    global $errors;
    global $dbsys;
    
    $html = "<li>\n<label for=\"eventsid\"";
    
    if (isset($errors) && in_array($name, $errors))
        $html .= " class=\"error\"";
    
    $html .= ">$display</label>\n<select class=\"form-control\" name=eventsid>";
    
    $html .= '<option value="0">All Events</option>' . "\n";
    
    $sqltext = "SELECT * FROM athcore.events ORDER BY eventsid";
    
    $res = $dbsys->query($sqltext) or die("Cant get eventsid");
    
    foreach ($res as $r) {
        
        $eventsid = $r->eventsid;
        $eventName = $r->name;
        
        if ($selected == $r->eventsid) {
            $sel = ' selected="selected"';
        } else {
            $sel = '';
        }
        
        $html .= <<<EOT
<option value="$eventsid" $sel>$eventName</option>\n
EOT;
    }
    $html .= "</select> </li>\n\n";
    
    print $html;
}

function yes_no_select($display, $name, $selected = 0)
{
    global $errors;
    
    $html = "<li>\n<label for=\"$name\"";
    
    if (isset($errors) && in_array($name, $errors))
        $html .= " class=\"error\"";
    
    $html .= ">$display</label>\n<select class=\"form-control\" name=$name>";
    
    if ($selected == 0) {
        $html .= '<option value="0" selected="selected">No</option>' . "\n";
    } else {
        $html .= '<option value="0">No</option>' . "\n";
    }
    
    if ($selected == 1) {
        $html .= '<option value="1" selected="selected">Yes</option>' . "\n";
    } else {
        $html .= '<option value="1">Yes</option>' . "\n";
    }
    
    $html .= "</select> </li>\n\n";
    
    print $html;
}

function supp_class_select($display, $name, $selected)
{
    global $errors;
    
    $html = "<li>\n<label for=\"eventsid\"";
    
    if (isset($errors) && in_array($name, $errors))
        $html .= " class=\"error\"";
    
    $html .= ">$display</label>\n<select class=\"form-control\" name=$name>";
    
    $html .= '<option value="0">Select Status</option>' . "\n";
    
    $sta = array(
        "Customer Nominated",
        "3rd Party Registration Required (e.g., mandated by customer, Nadcap or required by business)",
        "Stockists",
        "Sub-contracted product (e.g., Wet Processing, Welding, Machining, NDT etc.)",
        "Indirect Supplier (e.g. Toolmakers, Calibration houses, Transport ETC.)",
        "Delegation of Verification"
    );
    
    foreach ($sta as $status) {
        
        if ($selected == $status) {
            $sel = ' selected="selected"';
        } else {
            $sel = '';
        }
        
        $html .= <<<EOT
<option value="$status" $sel>$status</option>\n
EOT;
    }
    $html .= "</select> </li>\n\n";
    
    print $html;
}

function supplier_status_select($display, $name, $selected)
{
    global $errors;
    
    $html = "<li>\n<label for=\"eventsid\"";
    
    if (isset($errors) && in_array($name, $errors))
        $html .= " class=\"error\"";
    
    $html .= ">$display</label>\n<select class=\"form-control\" name=$name>";
    
    $html .= '<option value="0">Select Status</option>' . "\n";
    
    $sta = array(
        "Approved",
        "Conditionally Approved",
        "Dissapproved"
    );
    
    foreach ($sta as $status) {
        
        if ($selected == $status) {
            $sel = ' selected="selected"';
        } else {
            $sel = '';
        }
        
        $html .= <<<EOT
<option value="$status" $sel>$status</option>\n
EOT;
    }
    $html .= "</select> </li>\n\n";
    
    print $html;
}

function days_select($display, $name, $selected)
{
    global $errors;
    
    $html = "<li>\n<label for=\"days\"";
    
    if (isset($errors) && in_array($name, $errors))
        $html .= " class=\"error\"";
    
    $html .= ">$display</label>\n<select class=\"form-control\" name=days>";
    
    $html .= '<option value="1">1 Day</option>' . "\n";
    
    for ($counter = 7; $counter <= 370; $counter += 7) {
        
        if ($selected == $counter) {
            $sel = ' selected="selected"';
        } else {
            $sel = '';
        }
        
        $html .= <<<EOT
<option value="$counter" $sel>$counter Days</option>\n
EOT;
    }
    
    $html .= "</select> <input type=submit name=todo value=Go class=clickable > </li>\n\n";
    
    print $html;
}

function recur_select($display, $name, $selected)
{
    global $errors;
    
    $html = "<li>\n<label for=\"every\"";
    
    if (isset($errors) && in_array($name, $errors))
        $html .= " class=\"error\"";
    
    $html .= ">$display</label>\n<select class=\"form-control\" name=every>";
    
    $html .= '<option value="0">Select Time Interval</option>' . "\n";
    
    $intervals = array(
        "Day",
        "Week",
        "Month",
        "Quarter",
        "Year"
    );
    $intervalues = array(
        "d",
        "w",
        "m",
        "q",
        "y"
    );
    
    for ($counter = 0; $counter <= 4; $counter ++) {
        
        if ($selected == $intervalues[$counter]) {
            $sel = ' selected="selected"';
        } else {
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

function html_radios($display, $name, $group, $selected = '', $return = 'print')
{
    global $errors;
    
    // $html = "<li><h2";
    // if(isset($errors) && in_array($name, $errors)) $html .= " class=\"error\"";
    // $html .=" >$display</h2>\n";
    
    foreach ($group as $item => $display) {
        $html .= '';
        
        $html .= "<label for=\"{$item}_radio_\" class=\"radio-inline";
        if (isset($errors) && in_array($name, $errors))
            $html .= " error";
        $html .= "\">\n";
        
        $html .= "<input type=\"radio\" name=\"$name\" 
        id=\"{$item}_radio_\" value=\"$item\" class=\"";
        
        if (isset($errors) && in_array($name, $errors))
            $html .= " error";
        
            $html .= "\"";
            
        if (isset($selected) && ($selected == $item))
            $html .= " checked=\"checked\"";
        
            
        $html .= ">$display</label>\n";
    }
    
    $html .= "<br clear=all ></li>\n\n";
    
    if ($return == 'print') {
        print $html;
    } else {
        return $html;
    }
}

