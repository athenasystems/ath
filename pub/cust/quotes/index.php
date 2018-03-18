<?php

$page = "Quotes";

include "/srv/ath/src/php/cust/common.php";


$errors = array();

$pagetitle = "Quotes";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/cust/tmpl/header.php";


if(!isset($siteMods['quotes'])){
	?>
<h2>This Athena Module has not been activated</h2>
<?php
include "/srv/ath/pub/cust/tmpl/footer.php";
exit;
}

$query = (isset($_GET['q'])) ? stripcslashes( preg_replace("/^Q/i",'',$_GET['q'])):'';

$from 	 = ((isset($_GET['from']))&&(is_numeric($_GET['from'] ))) ? $_GET['from'] : 0;
$perpage = ((isset($_GET['perpage']))&&(is_numeric($_GET['perpage'] ))) ? $_GET['perpage'] : $ppage;
$newfrom = $from + $perpage;

?>

<div style="float: right;">
	<a class="btn btn-primary" href="/quotes/add" title="Add new quote">
		Request a New Quote</a>
</div>

<h2>Quotes</h2>
<?php
$sqltext = "SELECT SQL_CALC_FOUND_ROWS DISTINCT * FROM quotes,cust
WHERE quotesid>0
AND quotes.custid=cust.custid
AND quotesid>0  AND quotes.custid=" . $custID;

if($query!=''){
	$sqltext .= " AND quotes.quoteno LIKE 'Q" . $query . "%' ";
}
$sqltext .= " ORDER BY quotesid DESC LIMIT $from,$perpage";
$res = $dbsite->query($sqltext); # or die("Cant get quotes");

$total_rows = getTotalRows();
$endofsearch = ($total_rows<=$newfrom) ? $total_rows : ($newfrom) ;

if(($endofsearch<=$total_rows)||(isset($_GET['q']))||($_GET['custid']!='')){

	#$select = customer_select_search("Customer", "custid", $_GET['custid'],1,'','');
	$searchForm ='<input name="q" id="q" value="'.$query.'" class=" form-control"
	placeholder="Quote Number" type="text">'
	;

	printSearchBar($searchForm,$newfrom,$perpage,$endofsearch,$total_rows);



	#perpage_select('Per Page','perpage',$perpage,$query,$custid,'',$contactsid);

}


if (! empty($res)) {
	foreach($res as $r) {

		print getQuoteRowHTML($r);
	}

}

if($endofsearch<=$newfrom){
	printSearchFooter($newfrom,$perpage,$query,  '',  '',  '', '',$total_rows);
}
include "/srv/ath/pub/cust/tmpl/footer.php" ;
?>
