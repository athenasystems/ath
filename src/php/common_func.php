<?php

function isDev() {
	if (preg_match('/^server\d+/', gethostname())) {
		return false;
	} else {
		return true;
	}
}

function getTotalRows() {
	global $dbsite;

	$sql = "SELECT FOUND_ROWS() AS `found_rows`;";
	$res = $dbsite->query($sql);
	$rows = $res[0];
	$total_rows = $rows->found_rows;
	return $total_rows;
}

function getTotalRowsSys() {
	global $dbsys;

	$sql = "SELECT FOUND_ROWS() AS `found_rows`;";
	$res = $dbsys->query($sql);
	$rows = $res[0];
	$total_rows = $rows->found_rows;
	return $total_rows;
}

function generateFileStr() {
	$fileStr = '';#;
	$possible = "12346789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$maxlength = strlen($possible);

	$i = 0;

	while ($i < 44) {
		$char = substr($possible, mt_rand(0, $maxlength - 1), 1);
		$fileStr .= $char;
		$i ++;
	}

	$ret = mkPath($fileStr);

	return $ret;
}

function mkPath($str){
	$ret= strtolower(substr($str,0,1)) . '/' .
			strtolower(substr($str,1,1)) . '/' .
			$str.time();
	return $ret;
}

function generatePassword($length = 8) {
	$password = "";
	$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
	$maxlength = strlen($possible);

	if ($length > $maxlength) {
		$length = $maxlength;
	}

	$i = 0;

	while ($i < $length) {
		$char = substr($possible, mt_rand(0, $maxlength - 1), 1);
		if (! strstr($password, $char)) {
			$password .= $char;
			$i ++;
		}
	}

	return $password;
}

function siteDets() {
	global $dbsys;
	global $sitesid;

	$sqltext = "SELECT * FROM athcore.sites,athdb$sitesid.adds WHERE sites.sitesid=$sitesid AND sites.addsid=adds.addsid";
	// print $sqltext;
	$res = $dbsys->query($sqltext) or die("Cant get site details");
	$r = $res[0];

	return $r;
}

function getAddress($addsid) {
	global $dbsite;
	global $sitesid;

	$sql = "SELECT * FROM adds WHERE addsid=" . $addsid;
	$res = $dbsite->query($sql) or die("Cant get address");
	$r = $res[0];
	return $r;
}

function logEvent($event, $content) {
	global $dbsite;
	global $staffid;
	global $contactsid;

	$sitelogNew = new Sitelog();
	$sitelogNew->setIncept(time());
	if (isset($staffid) && ($staffid > - 1)) {
		$who = " staffid='$staffid'";
		$sitelogNew->setStaffid($who);
	}
	if (isset($contactsid) && ($contactsid > - 1)) {
		$who = " contactsid='$contactsid'";
		$sitelogNew->setContactsid($who);
	}
	$sitelogNew->setContent($content);
	$sitelogNew->setEventsid($event);

	$db_logevent_id = $sitelogNew->insertIntoDB();

	return $db_logevent_id;
}

function getEpochFromCalPop($calPopDate) {
	$reqd = preg_split("/\-/", $calPopDate);

	$ret = mktime(0, 0, 0, $reqd[1], $reqd[0], $reqd[2]);

	return $ret;
}

function getVAT_Rate($vat_incept) {
	$vat_rate = 0;
	$vat_change_date_1 = 1294099200; // From 17.5% to 20% on 4/1/2011

	if ($vat_incept < $vat_change_date_1) {
		$vat_rate = 0.175;
	} else {
		$vat_rate = 0.2;
	}
	return $vat_rate;
}

function getVatText($vat_rate) {
	$vatTxt = ($vat_rate * 100);
	$vatTxt = $vatTxt . '%';
	return $vatTxt;
}

function getStaffName($staffid) {
	global $dbsite;
	$ret = '';
	$sqltext = "SELECT fname,sname FROM staff
	WHERE staffid=" . $staffid;
	$res = $dbsite->query($sqltext); // or die("Cant get staff");
	if (! empty($res)) {
		$r = $res[0];
		$ret = $r->fname . ' ' . $r->sname;
	}
	return $ret;
}

function getStaffDets($staffid) {
	global $dbsite;
	global $sitesid;
	$sqltext = "SELECT * FROM athdb$sitesid.staff WHERE staffid='" . $staffid . "'";
	// print $sqltext;
	$res = $dbsite->query($sqltext); // or die("Cant get staff detail");
	$r = $res[0];

	return $r;
}

function getSiteMods() {
	global $dbsys;
	global $sitesid;

	$sqltext = "SELECT section FROM modules,mods WHERE mods.modulesid=modules.modulesid AND sitesid='" . $sitesid . "'";
	// print $sqltext;
	$res = $dbsys->query($sqltext) or die("Cant get site modules");

	$siteMods = array();

	foreach ($res as $r) {
		$siteMods[$r->section] = 1;
	}
	return $siteMods;
}

function getSiteModName($modid) {
	global $dbsys;

	$sqltext = "SELECT name FROM athcore.modules WHERE modulesid='" . $modid . "'";
	// print $sqltext;
	$res = $dbsys->query($sqltext) or die("Cant get module name");
	$r = $res[0];
	return $r->name;
}

function getSiteModIDs() {
	global $dbsys;
	global $sitesid;
	$sqltext = "SELECT modules.modulesid FROM modules,mods
	WHERE mods.modulesid=modules.modulesid
	AND sitesid='" . $sitesid . "'";
	// print $sqltext;
	$res = $dbsys->query($sqltext) or die("Cant get site moduleids");

	$siteMods = array();

	if (! empty($res)) {
		foreach ($res as $r) {
			$siteModIDs[] = $r->modulesid;
		}
	}
	return $siteModIDs;
}

function getAllSiteModIDs() {
	global $dbsys;

	$sqltext = "SELECT modulesid FROM modules ORDER BY modulesid";
	// print $sqltext;
	$res = $dbsys->query($sqltext) or die("Cant get site moduleids");

	$siteMods = array();

	if (! empty($res)) {
		foreach ($res as $r) {
			$siteModIDs[] = $r->modulesid;
		}
	}
	return $siteModIDs;
}

function getNextInvoiceNo() {
	global $dbsite;
	global $dataDir;

	$sqltext = "SELECT invoiceno FROM invoices ORDER BY invoicesid DESC LIMIT 1";
	$res = $dbsite->query($sqltext); // or die("Cant get last invoices no.");

	if (! empty($res)) {
		$r = $res[0];
		// $invoicenum = intval(substr($r->invoiceno, 3));
		$invoicenum = $r->invoiceno + 1;
	} else {
		// A new Account with no invoices yet
		$invoicenum = file_get_contents($dataDir . '/ino');
	}

	// $nextInvoiceNo = str_pad($invoicenum, 4, '0', STR_PAD_LEFT);

	return $invoicenum;
}

function getNextQuoteNo() {
	global $dbsite;
	global $dataDir;

	$sqltext = "SELECT quoteno FROM quotes ORDER BY quotesid DESC LIMIT 1";
	$res = $dbsite->query($sqltext); // or die("Cant get quoteno");

	if (! empty($res)) {
		$r = $res[0];
		if ($r->quoteno) {
			$quotenum = $r->quoteno + 1;
		} else {
			// A new Account with no quotes yet
			$quotenum = file_get_contents($dataDir . '/qno');
		}
	}
	// $nextQuoteNo = str_pad($quotenum, 4, '0', STR_PAD_LEFT);
	return $quotenum;
}

function getNextJobNo() {
	global $dbsite;

	$sqltext = "SELECT jobno FROM jobs ORDER BY jobsid DESC LIMIT 1";
	$res = $dbsite->query($sqltext); // or die("Cant get job no");

	$jobnum = '1'; // A new Account with no Jobs yet
	if (! empty($res)) {
		$r = $res[0];
		// $jobnum = intval(substr($r->jobno, 3));
		$jobnum = intval($r->jobno) + 1;
	}

	// $nextJobNo = str_pad($jobnum, 4, '0', STR_PAD_LEFT);
	return $jobnum;
}

function tablerow($desc, $content) {
	$ret = <<< EOHTML

<div class="form-group row">
<label for="itemcontent" class=" col-sm-2 form-control-label">$desc</label>
	<div class="col-sm-10">
$content
</div>
</div>


EOHTML;

	print $ret;
}

function tablerow_li($desc, $content) {
	$ret = <<< EOHTML
<li>
				<div style="margin:4px;">
				<div style="float:left;width:160px;text-align:right;padding:4px;">
				<span style="font-size:70%;color:#999999;">$desc</span>
				</div>
				<div style="float:left;width:560px;padding:4px;">
				$content
				</div>
				</div><br clear="all">
</li>
EOHTML;

	print $ret;
}

function getIntAdminLogin($sid) {
	global $dbsite;

	$sqltext = "SELECT usr,init,staffid
	FROM pwd
	WHERE staffid = 1000
	LIMIT 1";
	// AND logon NOT LIKE \"AA%\"
	// AND athdb$sid.staff.status='active'
	// print $sqltext;exit;

	$res = $dbsite->query($sqltext); // or die("Cant get Athena login details");
	$user = array();
	if (! empty($res)) {
		foreach ($res as $r) {
			$user['sitesid'] = $sid;
			$user['staffid'] = $r->staffid;
			$user['usr'] = $r->usr;
			$user['pw'] = $r->init;
		}
	}
	return ($user);
}

function getCustAdminLogin($custid) {
	global $dbsite;

	$sqltext = "SELECT contactsid,usr,init FROM pwd
	WHERE custid=$custid
	ORDER BY contactsid LIMIT 1";

	$res = $dbsite->query($sqltext); // or die("Cant get customer login details");
	$user = array();
	// print $sqltext;
	if (! empty($res)) {
		$r = $res[0];
		$user['contactsid'] = $r->contactsid;
		$user['usr'] = $r->usr;
		$user['pw'] = $r->init;
	}

	return ($user);
}

function getStaffLogin($stfid) {
	global $dbsite;

	$sqltext = "SELECT usr,init FROM pwd WHERE staffid=$stfid LIMIT 1";

	$res = $dbsite->query($sqltext); // or die("Cant get staff login details");
	$user = array();

	if (! empty($res)) {
		$r = $res[0];
		$user['staffid'] = $stfid;
		$user['usr'] = $r->usr;
		$user['pw'] = $r->init;
	}

	return ($user);
}

function getSuppAdminLogin($suppid) {
	global $dbsite;

	$sqltext = "SELECT contactsid,usr,init FROM pwd
	WHERE suppid=$suppid
	ORDER BY contactsid LIMIT 1";
	// print $sqltext;
	$res = $dbsite->query($sqltext); // or die("Cant get supplier login details");
	$user = array();

	if (! empty($res)) {
		$r = $res[0];
		$user['contactsid'] = $r->contactsid;
		$user['usr'] = $r->usr;
		$user['pw'] = $r->init;
	}

	return ($user);
}

function getSuppName($suppid) {
	global $dbsite;

	$sqltext = "SELECT co_name FROM supp WHERE suppid=" . $suppid;
	$res = $dbsite->query($sqltext); // or die("Cant get supp name");
	if (! empty($res)) {
		$r = $res[0];
		$ret = $r->co_name;
	}

	return $ret;
}

function getCustName($custid) {
	global $dbsite;

	$sqltext = "SELECT co_name FROM cust WHERE custid=" . $custid;
	$res = $dbsite->query($sqltext); // or die("Cant get customer name");
	if (! empty($res)) {
		$r = $res[0];
		$ret = $r->co_name;
	}

	return $ret;
}

function getCustColour($custid) {
	global $dbsite;

	$sqltext = "SELECT colour FROM cust WHERE custid=" . $custid;
	$res = $dbsite->query($sqltext); // or die("Cant get customer name");
	if (! empty($res)) {
		$r = $res[0];
		$ret = $r->colour;
	}

	return $ret;
}

function getUsrFromStaffID($stfid) {
	global $dbsite;

	$sqltext = "SELECT usr FROM pwd WHERE staffid=" . $stfid;
	$res = $dbsite->query($sqltext); // or die("Cant get usr name");
	if (! empty($res)) {
		$r = $res[0];
		$ret = $r->usr;
	}

	return $ret;
}

function getCustExtName($contactsid) {
	global $dbsite;

	$sqltext = "SELECT fname,sname FROM contacts WHERE contactsid=" . $contactsid;
	$resCustExtName = $dbsite->query($sqltext); // or die("Cant get contact name");
	if (! empty($resCustExtName)) {
		$rCustExtName = $resCustExtName[0];
		$ret = $rCustExtName->fname . ' ' . $rCustExtName->sname;
	}

	return $ret;
}

function getContactName($contactsid) {
	global $dbsite;

	$sqltext = "SELECT fname,sname FROM contacts WHERE contactsid=" . $contactsid;
	$res = $dbsite->query($sqltext); // or die("Cant get contact name");
	if (! empty($res)) {
		$r = $res[0];
		$ret = $r->fname . ' ' . $r->sname;
	}

	return $ret;
}

function getQuoteNoByID($quotesid) {
	global $dbsite;

	$sqltext = "SELECT quoteno FROM quotes WHERE quotesid='" . $quotesid . "'";
	$res = $dbsite->query($sqltext); // or die("Cant get quoteno");

	if (! empty($res)) {
		$r = $res[0];
		$ret = $r->quoteno;
	}

	return $ret;
}

function getCustEmailAdd($custid) {
	global $dbsite;

	$sqltext = "SELECT adds.email
	FROM cust,adds
	WHERE cust.addsid=adds.addsid
	AND custid=$custid LIMIT 1";

	$res = $dbsite->query($sqltext); // or die("Cant get customer email address.");

	if (! empty($res)) {
		$r = $res[0];
		$ret = $r->email;
	}

	return $ret;
}

function getContactEmailAdd($contactsid) {
	global $dbsite;

	$sqltext = "SELECT adds.email
	FROM contacts,adds
	WHERE contacts.addsid=adds.addsid
	AND contactsid=$contactsid LIMIT 1";

	$res = $dbsite->query($sqltext); // or die("Cant get contacts email address.");

	if (! empty($res)) {
		$r = $res[0];
		$ret = $r->email;
	}

	return $ret;
}

function getJobNoByID($jobsid) {
	global $dbsite;

	$sqltext = "SELECT jobno FROM jobs WHERE jobsid='" . $jobsid . "'";
	$res = $dbsite->query($sqltext); // or die("Cant get jobno");

	if (! empty($res)) {
		$r = $res[0];
		$ret = $r->jobno;
	}

	return $ret;
}

function getSiteIDs() {
	global $dbsys;
	$sids = array();
	$sqltext = "SELECT sitesid FROM sites WHERE status='active'";
	$res = $dbsys->query($sqltext); // or die("Cant get customer name");
	if (! empty($res)) {
		foreach ($res as $r) {
			$sids[] = $r->sitesid;
		}
	}

	return $sids;
}

function getCostName($expsid) {
	global $dbsys;
	$sqltext = "SELECT name FROM exps WHERE expsid=$expsid ";

	// print "<br>" . $sqltext . "<br>";
	$res = $dbsys->query($sqltext); // or die("Cant get cost name");
	$r = $res[0];

	$rtnValue = $r->name;

	return $rtnValue;
}

function getModuleName($modulesid) {
	global $dbsys;
	$sqltext = "SELECT name FROM modules WHERE modulesid=$modulesid ";

	// print "<br>" . $sqltext . "<br>";
	$res = $dbsys->query($sqltext); // or die("Cant get cost name");
	$r = $res[0];

	$rtnValue = $r->name;

	return $rtnValue;
}

function getContactDets($contid) {
	global $dbsite;

	$sqltext = "SELECT contacts.contactsid, contacts.fname, contacts.sname,contacts.role ,
	adds.add1, adds.add2, adds.add3, adds.city, adds.county, adds.country,
	adds.postcode, adds.tel, adds.fax, adds.email, adds.web
	FROM contacts,adds
	WHERE contacts.addsid=adds.addsid
	AND contacts.contactsid=" . $contid;
	// print $sqltext;
	$res = $dbsite->query($sqltext); // or die("Cant get contacts details");

	$r = $res[0];

	return $r;
}

function getNoOfItemsInQuote($quotesid) {
	global $dbsite;
	$sqltext = "SELECT COUNT(qitemsid) as cnt FROM qitems WHERE quotesid='" . $quotesid . "'";
	$res = $dbsite->query($sqltext); // or die("Cant get quoted itemsid");

	if (! empty($res)) {
		$r = $res[0];
		$ret = $r->cnt;
	}

	return $ret;
}

function getJobNoByItem($itemsid) {
	global $dbsite;
	$sqltext = "SELECT jobno from jobs,items where jobs.itemsid=items.itemsid and items.itemsid=" . $itemsid;
	$res = $dbsite->query($sqltext); // or die("Cant get itemsid jobno");
	$r = $res[0];
	return $r->jobno;
}

function getEventName($eventsid) {
	global $dbsys;
	$sqltext = "SELECT name FROM athcore.events WHERE eventsid=" . $eventsid;
	$res = $dbsys->query($sqltext) or die("Cant get eventsid details");
	$r = $res[0];
	return $r->name;
}

function getPathToFilesReal($id) {
	global $dataDir;

	$type = substr($id, 0, 1);
	$prefixyr = substr($id, 1, 2);

	if ($type == 'J') {
		$path = $dataDir . '/jobs/J' . $prefixyr . '/' . $id;
	} elseif ($type == 'Q') {
		$path = $dataDir . '/quotes/Q' . $prefixyr . '/' . $id;
	} else {
		return 0;
	}

	if (! file_exists($path)) {

		mkDataDir($id);
	}

	return $path;
}

function mkDataDir($id) {
	global $dataDir;

	$type = substr($id, 0, 1);
	$prefixyr = substr($id, 1, 2);

	if ($type == 'J') {
		$path = $dataDir . '/jobs/J' . $prefixyr . '/' . $id;
		mkFolder($path);
	} elseif ($type == 'Q') {
		$path = $dataDir . '/quotes/Q' . $prefixyr . '/' . $id;
		mkFolder($path);
	} elseif ($type == 'I') {
		$path = $dataDir . '/invoices/I' . $prefixyr . '/' . $id;
		mkFolder($path);
	} else {
		return 0;
	}

	return $path;
}

function mkFolder($path) {
	if (! file_exists($path)) {

		$old_umask = umask(0);
		mkdir($path, 0777, true);
		umask($old_umask);
	}
}

function printSearchBar($insert, $newfrom, $perpage, $endofsearch, $total_rows) {
	$from = $newfrom - $perpage;

	$shownfrom = $from + 1;
	$searchRes = "Showing $shownfrom - $endofsearch of $total_rows";

	$out = <<< EOF
<div class="row" style="border: 1px #eee solid; padding: 6px; margin: 4px;">
	<div style="float: left; text-align: right; margin-top: 6px;">
		<form action="{$_SERVER['PHP_SELF']}" method="get"
			name=contactlist onsubmit="document.getElementById('from').value=0;"
			class="form-inline" id=searchform>
			$insert
			<input type="hidden" id="from" name="from"
				value="$from">
				<a class="btn btn-default btn" onclick="parentNode.submit();"
				href="javascript:void(0);" title="Search">Go</a>
		</form>
	</div>

	<div style="float: right; text-align: right;">
		<span style="font-size: 90%;">$searchRes</span><br>

EOF;

	$out .= goBackAPage($from);
	if (($from > 0) && ($total_rows > $newfrom)) {
		$out .= ' - ';
	}
	$out .= goForwardAPage($total_rows, $newfrom);

	$out .= <<< EOF
	</div>
</div>
<br clear="all">
EOF;

	print $out;
}

function goBackAPage($from) {
	$out = '';
	if ($from > 0) {
		$out = <<< EOF
<a href="javascript:void(0);" onclick="goBackAPage($from);">&lt;-- Previous</a>
EOF;
	}
	return $out;
}

function goForwardAPage($total_rows, $newfrom) {
	$out = '';
	if ($total_rows > $newfrom) {
		$out = <<< EOF
<a href="javascript:void(0);" onclick="goNextPage($newfrom);">Next --&gt;</a>
EOF;
	}
	return $out;
}

function printSearchFooter($newfrom, $perpage, $id, $custid = '', $suppid = '', $contactsid = '', $sd = '', $total_rows) {
	$from = $newfrom - $perpage;

	$out = <<< EOF
<form action="{$_SERVER['PHP_SELF']}" method="get"
	name=contactlist onsubmit="document.getElementById('from').value=0;">
	<div class="row">
		<div class="col-md-4">
			<div style="margin: 0; text-align: left;">
EOF;

	$out .= goBackAPage($from);

	$out .= <<< EOF
			</div>
		</div>
		<div class="col-md-4" style="text-align: center;">
EOF;
	// $out .= "$newfrom > $perpage";
	$out .= perpage_select('Per Page', 'perpage', $perpage, $id, $custid, $suppid, $contactsid, $sd, 'string');

	$out .= <<< EOF
    </div>
		<div class="col-md-4">
			<div style="margin: 0; text-align: right;">
EOF;
	$out .= goForwardAPage($total_rows, $newfrom);

	$out .= <<< EOF
			</div>
		</div>
	</div>
</form>
EOF;
	print $out;
}

function getRandonHTMLColour() {
	$rand_hex = '';
	for ($i = 0; $i < 3; $i ++) {
		$rand_hex .= str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
	}
	$rand_hex = '#' . $rand_hex;
}

function getChatBox() {
	$chatBox = <<< EOF

<div id=chatpanel
style="border:solid 1px #eee;background-color:#fff;z-index:3000; position:fixed; bottom:0; right:20px; width:120px; height:27px;">

	    <div title="Click to Show/Hide Chat"
	    style=" height:25px;background-color:#245580;"
	    onclick="showHideChatPanel();">
	    <div style="margin-left:8px;color:#fff;">Chat</div>
	   </div>


		<div  id=chatroom
			style="height: 260px; overflow-x: hidden; overflow-y: auto;padding:2px;">
		</div>

		<div>
			<form action="javascript:void(0);" enctype="multipart/form-data"
				method="post" onsubmit="doChat();" accept-charset="UTF-8"
				autocomplete="off">
				<input type="text" id="qchat" name="qchat" value=""
						placeholder="Type here..." class="form-control">
					<!--<input type="submit" value=Send> -->
			</form>
		</div>


	<div id=fb></div>

</div>
EOF;
	return $chatBox;
}

function tailCustom($filepath, $lines = 1, $adaptive = true) {
	// Open file
	$f = @fopen($filepath, "rb");
	if ($f === false)
		return false;
	// Sets buffer size
	if (! $adaptive)
		$buffer = 4096;
	else
		$buffer = ($lines < 2 ? 64 : ($lines < 10 ? 512 : 4096));
	// Jump to last character
	fseek($f, - 1, SEEK_END);
	// Read it and adjust line number if necessary
	// (Otherwise the result would be wrong if file doesn't end with a blank line)
	if (fread($f, 1) != "\n")
		$lines -= 1;

	// Start reading
	$output = '';
	$chunk = '';
	// While we would like more
	while (ftell($f) > 0 && $lines >= 0) {
		// Figure out how far back we should jump
		$seek = min(ftell($f), $buffer);
		// Do the jump (backwards, relative to where we are)
		fseek($f, - $seek, SEEK_CUR);
		// Read a chunk and prepend it to our output
		$output = ($chunk = fread($f, $seek)) . $output;
		// Jump back to where we started reading
		fseek($f, - mb_strlen($chunk, '8bit'), SEEK_CUR);
		// Decrease our line counter
		$lines -= substr_count($chunk, "\n");
	}
	// While we have too many lines
	// (Because of buffer size we might have read too many)
	while ($lines ++ < 0) {
		// Find first newline and remove all text before that
		$output = substr($output, strpos($output, "\n") + 1);
	}
	// Close file and return
	fclose($f);
	return trim($output);
}

function getChat($noOfLines, $room = 'chat') {
	global $dbsite;
	global $owner;
	$ret = '';

	$chatfile = '/srv/ath/var/data/' . $owner->filestr . '/chat/' . $room;

	$chat = tailCustom($chatfile, $noOfLines);

	$lines = preg_split('/\n/', $chat);
	$out = '';
	foreach ($lines as $line) {

		if (preg_match('/\w/', $line)) {
			$parts = preg_split('/\t/', $line);
			$name = getStaffName($parts[0]);
			$date = date('d/m/y H:i:s', $parts[1]);
			$msg = base64_decode($parts[2]);
			$out .= <<<EOF
<div ><a href="" title="Sent: $date">$name</a>: $msg</div>
EOF;
		}
	}

	$out .= <<<EOF
<div id=endofchat></div>
EOF;
	return $out;
}

function putChat($txt, $room = 'chat') {
	global $owner;
	global $staffid;
	$chatfile = '/srv/ath/var/data/' . $owner->filestr . '/chat/' . $room;

	if ((isset($txt)) && ($txt != '')) {

		// $msg = base64_decode ( $txt);

		$line = $staffid . "\t" . time() . "\t" . $txt . "\n";

		file_put_contents($chatfile, $line, FILE_APPEND | LOCK_EX);
	}
	$out = '';
	return $out;
}

function wereGood($msg) {
	$confirms=array("We're good","Looks good","Alright","Sorted","Got it","Happy days","Nice","Cool");
	$head = $confirms[mt_rand(0, count($confirms) - 1)];
	echo <<<EOF
	<div class="alert alert-success" role="alert">
	<strong>$head...</strong><br>
	 $msg
</div>
EOF;
}
function wereBad($msg) {
	$confirms=array("Hmmmm","Ooopps","Ok, there was a problem","Houston, we have a problem","Whoops","Oh no","Wait up","Trouble at t'mill");
	$head = $confirms[mt_rand(0, count($confirms) - 1)];
	echo <<<EOF
	<div class="alert alert-warning" role="alert">
	<strong>$head...</strong><br>
	 $msg
</div>
EOF;
}
function chkUppercase($string) {
	return preg_match_all('/[A-Z]/', $string, $matches);
	return count($matches[0]);
}

function chkLowercase($string) {
	return preg_match_all('/[a-z]/', $string, $matches);
	return count($matches[0]);
}

function chkDigit($string) {
	return preg_match_all('/\d/', $string, $matches);
	return count($matches[0]);
}

function noOfStaff() {
	global $dbsite;
	$sqltext = "SELECT COUNT(staffid) as cnt FROM staff";
	$res = $dbsite->query($sqltext);
	$r = $res[0];
	return $r->cnt;
}

function qitemExits($qitemsid) {
	global $dbsite;
	if(!is_numeric($qitemsid)){
		return 0;
	}
	$sqltext = "SELECT qitemsid from qitems where qitemsid=" . $qitemsid;
	$res = $dbsite->query($sqltext);
	if(empty($res)){
		return 0;
	}else{
		return 1;
	}
	return 0;
}