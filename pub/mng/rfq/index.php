<?php
$section = "Contacts";
$page = "Suppliers";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

$pagetitle = "Requests for Quotes";
$pagescript = array();
$pagestyle = array();

$query = ( (isset($_GET['q']))  &&
		($_GET['q']!='')
) ? $_GET['q'] : '';

$co_name = ( (isset($_GET['q'])) &&
		($_GET['q']!='')
) ? $_GET['q'] : '';

$rfqid = ( (isset($_POST['rfqid'])) &&
		($_POST['rfqid']!='')
) ? $_POST['rfqid'] : '';


if ((isset($_GET['go'])) && ($_GET['go'] == "y") && ($rfqid != '') ) {

	$sqltext = "SELECT * FROM rfq WHERE rfqid=$rfqid LIMIT 1";

	$resA = $dbsite->query($sqltext);
	$rA = $resA[0];

	if ((!isset($rA->co_name))||($rA->co_name == ''))  {
		$_POST['co_name'] = $rA->fname .' '.$rA->sname;
	}else{
		$_POST['co_name'] = $rA->co_name;
	}

	$_POST['fname'] = $rA->fname;
	$_POST['sname'] = $rA->sname;
	$_POST['content'] = $rA->content;
	$_POST['email'] = $rA->email;
	$_POST['tel'] = $rA->tel;

	$post = $_POST;
	$cid = addCustomer($post);

	header("Location: /quotes/add?rfqid=$rfqid&id=" . $cid);


}


include "/srv/ath/pub/mng/tmpl/header.php";

#include "/srv/ath/pub/mng/contacts/linkstab.php";
?>

<h2 style="margin-top: 0px;">
	Request for Quotes
</h2>


<?php
$from 	 = ((isset($_GET['from']))&&(is_numeric($_GET['from'] ))) ? $_GET['from'] : 0;
$perpage = ((isset($_GET['perpage']))&&(is_numeric($_GET['perpage'] ))) ? $_GET['perpage'] : $ppage;
$newfrom = $from + $perpage;

$sqltext = "SELECT SQL_CALC_FOUND_ROWS *
FROM rfq
WHERE (fname LIKE \"$query%\" OR sname LIKE \"$query%\")
ORDER BY incept DESC
LIMIT $from,$perpage";
#print $sqltext;
$res = $dbsite->query($sqltext); # or die("Cant get Suppliers");

$total_rows = getTotalRows();
$endofsearch = ($total_rows<=$newfrom) ? $total_rows : ($newfrom) ;

if(($endofsearch<=$total_rows)||(isset($_GET['q']))){

	$searchForm ='<label for="q"></label>
	<input type="text" id="q" name="q" value="'.$query.'" style="width: 260px;"
	placeholder="Search By Name">
	<input type="submit" value="Search">
	<input type="hidden" id="from" name="from" value="'.$from.'">';
	printSearchBar($searchForm,$newfrom,$perpage,$endofsearch,$total_rows);

	$suppid = (isset($suppid)) ? $suppid:'';
	$contactsid = (isset($contactsid)) ? $contactsid:'';
}

$retHTML = '';


if (! empty($res)) {
	foreach($res as $r) {


		$date = date("d/m/Y H:i",$r->incept);
		$co_name = $r->co_name;
		$fname = $r->fname;
		$sname = $r->sname;
		$content = $r->content;
		$email = $r->email;
		$tel = $r->tel;
		#$fname = $r->colour;

		$retHTML .= <<<EOF
<div class="panel panel-default">
	<div class="panel-heading">
		$date From: $fname $sname $co_name
		<div style="float:right">
		<form action="{$_SERVER['PHP_SELF']}?go=y"
	enctype="multipart/form-data" method="post">

	<fieldset class="form-group">
		<input value="Quote" class="btn-xs btn-primary" type="submit">
<input type="hidden" name="rfqid" value="{$r->rfqid}">

	</fieldset>
</form>
		</div>
	</div>
	<div class="panel-body">Email: $email<br>
	Tel: $tel<br><br>
	$content	<!--
		<a href="/suppliers/view.php?id=$suppid">View Full Details</a> |
	-->
	</div>
</div>
EOF;
	}

}else{
	$retHTML .= <<<EOF
			No Requests for Quotes found ...
EOF;

}

echo $retHTML;

if($endofsearch<=$total_rows){
	printSearchFooter($newfrom,$perpage,$query,  '',  '',  '', '',$total_rows);
}

include "/srv/ath/pub/mng/tmpl/footer.php";
?>