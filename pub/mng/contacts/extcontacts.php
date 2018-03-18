<?php

include "/srv/ath/src/php/mng/common.php";

header("Cache-Control: no-cache");

$id = $_GET['q'];

$html = '';
if  ((isset($id))&&(is_numeric($id))){

	$sqltext = "SELECT contactsid, fname,sname,role FROM contacts
	WHERE (fname<>'Company' AND sname<>'Admin')
	AND custid=" . $id . " ORDER BY contactsid";
	$res = $dbsite->query($sqltext); # or die("Cant get customers");

	$html = "<div class=\"form-group row\">";

	#print $sqltext;

	if (! empty($res)) {

		$html .= "<label for=\"contactsid\" class=\"col-sm-2 form-control-label\">Select Contact";
		$html .= "</label><div class=\"col-sm-10\">";

		$html .= "<select class=\"form-control\" name=contactsid>";

		foreach($res as $r) {
			$html .= <<<EOT
<option value="{$r->contactsid}" $sel>{$r->fname} {$r->sname}</option>\n
EOT;
		}
		$html .= "</select></div>\n\n";
	}else {
		$html .= html_hidden('contactsid', $r->contactsid);
	}

	$html .= "</div>\n\n";
}

print $html;

?>