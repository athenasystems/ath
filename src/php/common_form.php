<?php

function html_button($display, $class = "", $id = "") {
	$html = "<div class=\"text-right\">
	<input type=\"submit\"  value=\"$display\" class=\"btn btn-primary\"";

	if ($id != "")
		$html .= " id=\"$id\" name=\"$id\"";

	$html .= '></div>';

	print $html;
}

function html_pw($display, $name, $value = "", $id = "", $help = "") {
	global $errors;

	if (isset($id) && ($id == ""))
		$id = $name;

	$html = "<div class=\"form-group row\">\n";

	$html .= "<label for=\"$id\" class=\"";
	if (isset($errors) && in_array($name, $errors))
		$html .= "error ";
	$html .= "col-sm-2 form-control-label\">$display</label>\n";

	$html .= "<div class=\"col-sm-10\"><input type=\"password\" name=\"$name\" id=\"$id\" value=\"" . stripslashes($value) . "\" class=\" ";

	if (isset($errors) && in_array($name, $errors))
		$html .= " error";

	$html .= " form-control\"  placeholder=\"$display\">";
	if ($help != "") {
		$html .= '<small class="text-muted">' . $help . '</small>';
	}

	$html .= "</div> </div>";

	print $html;
}

function html_text($display, $name, $value = "", $id = "", $help = "", $return = 'print', $label = 1, $width = "270", $labelwidth = "180") {
	global $errors;

	if (isset($id) && ($id == ""))
		$id = $name;

	$html = "<div class=\"form-group row";
	if (isset($errors) && in_array($name, $errors)){
		$html .= " has-error";
	}
	$html .= "\">\n";
	if ($label) {
		$html .= "<label for=\"$id\" class=\"col-sm-2 form-control-label\">
		$display</label>\n";
	} else {
		$html .= "$display ";
	}

	$html .= "<div class=\"col-sm-10\"><input type=\"text\"
	name=\"$name\" id=\"$id\" value=\"" . stripslashes($value) . "\"
	class=\"form-control\"  placeholder=\"$display\">\n";

	if ($help != "") {
		$html .= '<small class="text-muted">' . $help . '</small>';
	}

	$html .= "</div></div>";

	if ($return == 'print') {
		print $html;
	} else {
		return $html;
	}
}

function custcontact_select($display, $name, $selected, $custid = '') {
	global $dbsite;
	global $errors;

	$sqltext = "SELECT contactsid, fname,sname,role FROM contacts
	WHERE fname<>'Company'
	AND sname<>'Admin'";

	if ((isset($custid)) && (is_numeric($custid)))
		$sqltext .= " AND custid=" . $custid;

	$sqltext .= " ORDER BY contactsid";

	// print $sqltext;
	$res = $dbsite->query($sqltext); // or die("Cant get external contact");
	$html = "<div id=contactlist>";
	if (count($res) > 1) {

		$html = "<div class=\"form-group row\">\n<label for=\"contactsid\"";

		if (isset($errors) && in_array($name, $errors))
			$html .= " class=\"error\"";

		$html .= " class=\"col-sm-2 form-control-label\">$display</label>
		<div class=\"col-sm-10\">
		<select class=\"form-control\" name=contactsid>";

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
		$html .= "</select></div></div>";
	} else {

		$html .= html_hidden('contactsid', $r->contactsid);
	}

	print $html;
}

function form_fail($message = "") {
	global $errors;

	if (isset($errors) && ! empty($errors)) {

		$html = '<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span></button>
		<strong>Ooops - Missing information ...</strong>';
		if ($message != "") {
			$html .= "<p>$message</p>\n";
		} else {
			$html .= "<p>I've highligthed in red what needs sorting out</p>\n";
		}
		foreach ($errors as $value) {
			# $html .= $value . '<br>';
		}
		$html .= "</div>";

		print $html;
	}
}

function html_hidden($name, $value, $return = 'print') {
	$html = "";
	$html .= "<input type=\"hidden\" name=\"$name\" value=\"$value\">\n\n";

	if ($return == 'print') {
		print $html;
	} else {
		return $html;
	}
}

function staff_select($display, $name, $selected, $output = 1) {
	global $dbsite;
	global $errors;
	global $staffid;

	$sqltext = "SELECT staffid,fname,sname FROM staff
	WHERE status='active'
	AND (fname<>'System' AND sname<>'Administrator')
	AND staffid>1000 ORDER BY staffid";

	$res = $dbsite->query($sqltext); // or die("Cant get staff");

	if (count($res) > 1) {

		$html = "<div class=\"form-group row\">\n<label for=\"staffid\"";

		if (isset($errors) && in_array($name, $errors))
			$html .= " class=\"error\"";

		$html .= " class=\"col-sm-2 form-control-label\">$display</label><div class=\"col-sm-10\">\n<select class=\"form-control\" name=$name id=$name>";

		foreach ($res as $r) {

			if ($selected == $r->staffid) {
				$sel = ' selected="selected"';
			} else {
				$sel = '';
			}
			$nid = $r->staffid;
			$nname = $r->fname . ' ' . $r->sname;
			$html .= <<<EOT
<option value="$nid" $sel>$nname</option>\n
EOT;
		}
		$html .= "</select></div></div>\n\n";
	} else {
		$html = "<div class=\"form-group row\">";
		$html .= html_hidden('staffid', $staffid);
		$html .= "</div>\n\n";
	}

	if ($output) {
		print $html;
	} else {
		return $html;
	}
}

function exps_select($display, $name, $selected, $output = 1) {
	global $dbsys;
	global $errors;

	$sqltext = "SELECT expsid,name FROM exps";

	$res = $dbsys->query($sqltext); // or die("Cant get staff");

	if (! empty($res)) {

		$html = "<div class=\"form-group row";

		if (isset($errors) && in_array($name, $errors))
			$html .= " has-error";

		$html .= "\">\n<label for=\"staffid\" class=\"col-sm-2 form-control-label\">
		$display
		</label>
		<div class=\"col-sm-10\">
		<select class=\"form-control\" name=$name id=$name>";

		$html .= '<option value="">None</option>' . "\n";

		foreach ($res as $r) {

			if ($selected == $r->expsid) {
				$sel = ' selected="selected"';
			} else {
				$sel = '';
			}
			$nid = $r->expsid;
			$nname = $r->name;
			$html .= <<<EOT
<option value="$nid" $sel>$nname</option>\n
EOT;
		}
		$html .= "</select></div></div>\n\n";
	}

	if ($output) {
		print $html;
	} else {
		return $html;
	}
}

function perpage_select($display, $name, $selected, $q = '', $qcustid = '', $qsuppid = '', $qcontactsid = '', $qsd = '', $output = '') {
	global $errors;

	$extra_search = '';
	if ($q != '') {
		$extra_search .= '&' . 'q=' . $q;
	}
	if ($qcustid != '') {
		$extra_search .= '&' . 'custid=' . $qcustid;
	}
	if ($qsuppid != '') {
		$extra_search .= '&' . 'suppid=' . $qsuppid;
	}
	if ($qsd != '') {
		$extra_search .= '&' . 'sd=' . $qsd;
	}

	$onChange = "goPerPage('$extra_search');";

	$html = "<select class=\"form-control\" id=$name name=$name onchange=\"$onChange\">";

	for ($counter = 1; $counter <= 300; $counter = $counter * 2) {

		if ($selected == $counter) {
			$sel = ' selected="selected"';
		} else {
			$sel = '';
		}

		$html .= <<<EOT
<option value="$counter" $sel>$counter per page</option>\n
EOT;
	}

	$html .= "</select>";

	if ($output != '') {
		return $html;
	} else {
		print $html;
	}
}

function html_checkbox($display, $name, $value, $checked = 0, $return = 'print', $id = '') {
	$html = '';

	if ($id == '') {
		$id = $name;
	}

	$html .= "<label for=\"" . $id . "\" class=\"c-input c-checkbox\">" . $display . "";

	$html .= "\n<input type=\"checkbox\" name=\"" . $name . "\" value=\"" . $value . "\" id=\"" . $id . "\"";

	if ($checked)
		$html .= " checked=\"checked\"";

	$html .= "  /></label>";

	if ($return == 'print') {
		print $html;
	} else {
		return $html;
	}
}

function html_textarea($display, $name, $value = "", $id = "", $tinymce = "", $help = "") {
	global $errors;

	if (isset($id) && ($id == ""))
		$id = $name;

	$html = "<div class=\"form-group row\"><label for=\"$id\" class=\"";

	if (isset($errors) && in_array($name, $errors))
		$html .= " error";

	$html .= " col-sm-2 form-control-label\">$display</label>
	<div class=\"col-sm-10\">\n";
	$html .= "<textarea name=\"$name\" rows=\"4\" cols=\"30\" id=\"$id\" class=\"form-control ";

	if (isset($errors) && in_array($name, $errors)) {
		$html .= "error ";
	}

	$html .= "\">" . stripslashes($value) . "</textarea>\n";

	if ($help != "") {
		$html .= "<span class=\"help\">$help</span>";
	}

	$html .= "</div></div>";

	print $html;
}

function html_dateselect($display, $name, $value = "", $showtime = "n", $return = 'print') {
	global $errors;

	if ($value == "") {
		if ($showtime == "n") {
			$value = date("Y-m-d", strtotime("now"));
		} else {
			$value = date("Y-m-d H:i:s", strtotime("now"));
		}
	} elseif (is_array($value)) {
		$value = $value['year'] . "-" . $value['month'] . "-" . $value['day'] . " " . $value['hour'] . ":" . $value['minute'] . ":00";
	}
	// print $value;
	$cur_year = intval(date("Y", strtotime("now")));

	$date = strtotime($value);

	if ($cur_year > intval(date("Y", $date)))
		$cur_year = intval(date("Y", $date));

	$html = "<div class=\"form-group row\"><label for=\"" . $name . "_day\"";
	if (in_array($name, $errors))
		$html .= " class=\"error\"";
	$html .= " class=\"col-sm-2 form-control-label\">$display</label>\n";
	$html .= "<div class=\"col-sm-10\"><select class=\"c-select\" name=\"" . $name . "[day]\" id=\"" . $name . "_day\" class=\"";
	if (in_array($name, $errors))
		$html .= " error";

	$html .= "\">\n";

	for ($i = 1; $i <= 31; $i ++) {

		$html .= "\t<option value=\"$i\"";
		if ($i == intval(date("d", $date)))
			$html .= " selected=\"selected\"";
		$html .= ">$i</option>\n";
	}

	$html .= "</select>\n";
	$html .= "<select class=\"c-select\" name=\"" . $name . "[month]\" id=\"" . $name . "_month\" class=\"";
	if (in_array($name, $errors))
		$html .= " error";

	$html .= "\">\n";

	for ($i = 1; $i < 13; $i ++) {

		$html .= "\t<option value=\"" . date("m", strtotime("2006-" . $i . "-01")) . "\"";

		if ($i == intval(date("m", $date)))
			$html .= " selected=\"selected\"";

		$html .= ">" . date("F", strtotime("2006-" . $i . "-01")) . "</option>\n";
	}

	$html .= "</select>\n";
	$html .= "<select  name=\"" . $name . "[year]\" id=\"" . $name . "_year\" class=\"c-select";
	if (in_array($name, $errors))
		$html .= " error";

	$html .= "\">\n";

	$cur_yr = 1970;
	while ($cur_yr < date("Y", strtotime("now +10 year"))) {

		$html .= "\t<option value=\"$cur_yr\"";
		if ($cur_yr == intval(date("Y", $date)))
			$html .= " selected=\"selected\"";
		$html .= ">$cur_yr</option>\n";

		$cur_yr ++;
	}

	$html .= "</select>\n";

	if ($showtime == "y") {

		$html .= " at <select class=\"c-select\" name=\"" . $name . "[hour]\" id=\"" . $name . "_hour\" >\n";

		for ($i = 0; $i <= 23; $i ++) {

			$html .= "\t<option value=\"" . date("H", strtotime("2006-01-01 " . $i . ":00:00")) . "\"";
			if ($i == date("G", $date))
				$html .= " selected=\"selected\"";
			$html .= ">" . date("H", strtotime("2006-01-01 " . $i . ":00")) . "</option>\n";
		}

		$html .= "</select>:";
		$html .= "<select class=\"c-select\" name=\"" . $name . "[minute]\" id=\"" . $name . "_min\" >\n";

		for ($i = 0; $i <= 59; $i ++) {

			$html .= "\t<option value=\"" . date("i", strtotime("2006-01-01 00:" . $i . ":00")) . "\"";
			if ($i == date("i", $date))
				$html .= " selected=\"selected\"";
			$html .= ">" . date("i", strtotime("2006-01-01 00:" . $i . ":00")) . "</option>\n";
		}

		$html .= "</select>\n";
	}

	$html .= "</div></div>";

	if ($return == 'print') {
		print $html;
	} else {
		return $html;
	}
}

function check_required($required, $array, $notZero = 0) {
	# Checks specific fields to see
	# if they're blank / not set
	#
	$errors = array();

	foreach($required as $key => $r){

		if(is_array($array[$r])){
			if(empty($array[$r])){
				$errors[] = $key;
			}
		}else{
			if($array[$r] == "" || !isset($array[$r])){
				$errors[] = $r;
			}
			if($notZero && ($array[$r] == "0" )){
				$errors[] = $r;
			}
		}

	}

	return $errors;
};



function addDBAddress($input) {

	# Add to Address table
	# Insert into DB
	$addsNew = new Adds();
	$addsNew->setAdd1($_POST['add1']);
	$addsNew->setAdd2($_POST['add2']);
	$addsNew->setAdd3($_POST['add3']);
	$addsNew->setCity($_POST['city']);
	$addsNew->setCounty($_POST['county']);
	$addsNew->setCountry($_POST['country']);
	$addsNew->setPostcode($_POST['postcode']);
	$addsNew->setTel($_POST['tel']);
	$addsNew->setMob($_POST['mob']);
	$addsNew->setFax($_POST['fax']);
	$addsNew->setEmail($_POST['email']);
	$addsNew->setWeb($_POST['web']);
	// 	$addsNew->setFacebook($_POST['facebook']);
	// 	$addsNew->setTwitter($_POST['twitter']);
	// 	$addsNew->setLinkedin($_POST['linkedin']);

	$ret = $addsNew->insertIntoDB();
	return $ret;
}

function updateDBAddress($input,$addsid) {
	# Add to Address table
	$addDetails = array('add1', 'add2', 'add3', 'city', 'county', 'country', 'postcode', 'tel','mob', 'fax', 'email', 'web');


	$addsUpdate = new Adds();

	$addsUpdate->setAddsid($addsid);
	$addsUpdate->setAdd1($_POST['add1']);
	$addsUpdate->setAdd2($_POST['add2']);
	$addsUpdate->setAdd3($_POST['add3']);
	$addsUpdate->setCity($_POST['city']);
	$addsUpdate->setCounty($_POST['county']);
	$addsUpdate->setCountry($_POST['country']);
	$addsUpdate->setPostcode($_POST['postcode']);
	$addsUpdate->setTel($_POST['tel']);
	$addsUpdate->setMob($_POST['mob']);
	$addsUpdate->setFax($_POST['fax']);
	$addsUpdate->setEmail($_POST['email']);
	$addsUpdate->setWeb($_POST['web']);
	// 	$addsUpdate->setFacebook($addsid['facebook']);
	// 	$addsUpdate->setTwitter($addsid['twitter']);
	// 	$addsUpdate->setLinkedin($addsid['linkedin']);

	$ret = $addsUpdate->updateDB();


	return $ret;
}

function cleanurl($input,$lc) {

	$valid = "A B C D E F G H I J K L M N O P Q R S T U V W X Y Z a b c d e f g h i j k l m n o p q r s t u v w x y z 1 2 3 4 5 6 7 8 9 0 _";
	$valids = explode(" ", $valid);
	$valids[] = " ";

	for($i=0; $i<strlen($input); $i++){
		$char = substr($input, $i, 1);

		if(in_array($char, $valids)) $new .= $char;
	}

	if($lc == 'y'){
		$cleanver = strtolower($new);
	}else{
		$cleanver = $new;
	}

	$wordarray = explode(" ", $cleanver);
	while(count($wordarray)>=7) array_pop($wordarray);
	$cleanver = implode("-", $wordarray);

	$cleanver = trim(str_replace("--", "-", $cleanver), "-");

	return $cleanver;

}

function file_upload ($forminput, $savepath = "uploads/", $lc = "y") {
	$filename = $_FILES[$forminput]['name'];

	$ext = array_reverse(explode(".", $_FILES[$forminput]['name']));
	$extension = $ext[0];

	unset($ext[0]);

	$bits = array_reverse($ext);

	$file = implode("", $bits);

	$filename = cleanurl($file,'y') .".". $extension;
	$savefile = $savepath . $filename;
	#print $savefile;exit;
	$savepath .= '/';
	assert( is_dir($savepath) );
	assert(is_uploaded_file($_FILES[$forminput]['tmp_name']));
	assert( file_exists($_FILES[$forminput]['tmp_name']) );
	if(move_uploaded_file($_FILES[$forminput]['tmp_name'], $savefile)){
		chmod($savefile, 0777);
		assert(file_exists($savefile));
		return $filename;
	}else{
		// 		print $_FILES[$forminput]['error'];
		// 		exit;
	}

	return NULL;
}

function file_share_upload ( $dataid ,$forminput, $origin = 'I' ) {
	global $dbsite;
	global $dataDir;
	# $dataid is the Quote or Job No
	# Origin I means uploaded by Owner, C by customer and S by supplier
	#

	$filename = $_FILES[$forminput]['name'];

	$ext = array_reverse(explode(".", $_FILES[$forminput]['name']));
	$extension = $ext[0];

	unset($ext[0]);

	$bits = array_reverse($ext);

	$file = implode("", $bits);

	$filename = $dataid . '.' . $origin . '.' . cleanurl($file,'y') .".". $extension;
	$savefile = $dataDir . '/upload/' . $filename;
	#print $savefile;exit;

	assert( is_dir($dataDir. '/upload/') );

	assert(is_uploaded_file($_FILES[$forminput]['tmp_name']));

	assert( file_exists($_FILES[$forminput]['tmp_name']) );

	if(move_uploaded_file($_FILES[$forminput]['tmp_name'], $savefile)){

		$type = substr($dataid, 0, 1);

		if ($type == 'J'){
			$sqltext = "SELECT filestr FROM jobs,items,quotes,cust WHERE
			jobs.itemsid=items.itemsid
			AND items.quotesid=quotes.quotesid
			AND quotes.custid=cust.custid
			AND jobno='$dataid'";
			$qq = $dbsite->query($sqltext) or die("Cant get cust file store");
			$rr = $qq[0];

		}elseif($type == 'Q'){
			$sqltext = "SELECT filestr FROM quotes,cust WHERE
			quotes.custid=cust.custid
			AND	quoteno='$dataid'";
			$qq = $dbsite->query($sqltext) or die("Cant get cust file store");
			$rr = $qq[0];

		}else{
			return 0;
		}

		$zip = new ZipArchive();
		$zipfilename = "/srv/ath/var/files/cust/". $rr->filestr ."/$filename.zip";

		if ($zip->open($zipfilename, ZIPARCHIVE::CREATE)!==TRUE) {
			exit("cannot open <$zipfilename>\n");
		}
		$zip->addFile($savefile,$filename);
		$zip->close();

		chmod($savefile, 0777);
		assert(file_exists($savefile));
		return $filename;
	}else{
		// 		print $_FILES[$forminput]['error'];
		// 		exit;
	}

	return NULL;
}
