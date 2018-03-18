<?php

$section = "Invoices";
$page = "Invoices";

include "/srv/ath/src/php/cust/common.php";

$query = ( (isset($_GET['q']))  &&
		($_GET['q']!='')
) ? $_GET['q'] : '';

$pagetitle = "Invoices";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/cust/tmpl/header.php";


if(!isset($siteMods['invoices'])){
	?>
	<h2>This Athena Module has not been activated</h2>
	<?php
	include "/srv/ath/pub/cust/tmpl/footer.php";
	exit;
	}


?>
<h2 style="margin-top: 0px;">
	Invoices
</h2>

<?php
$from 	 = ((isset($_GET['from']))&&(is_numeric($_GET['from'] ))) ? $_GET['from'] : 0;
$perpage = ((isset($_GET['perpage']))&&(is_numeric($_GET['perpage'] ))) ? $_GET['perpage'] : $ppage;
$newfrom = $from + $perpage;

$sqltext = "SELECT SQL_CALC_FOUND_ROWS
invoices.invoicesid,invoices.paid,invoiceno,invoices.incept,
co_name,colour
FROM invoices,cust
WHERE cust.custid=invoices.custid
AND invoices.custid=$custID
AND invoices.invoiceno LIKE '$query%'
ORDER BY invoicesid DESC LIMIT $from,$perpage";

#print $sqltext;

$res = $dbsite->query($sqltext); # or die("Cant get invoices");

$total_rows = getTotalRows();

$endofsearch = ($total_rows<=$newfrom) ? $total_rows : ($newfrom) ;


if(($endofsearch<=$total_rows)||($query!='')){


	$searchForm ='<input name="q" id="q" value="'.$query.'"
	class=" form-control" placeholder="Search Invoice No" type="text">'
	;

	printSearchBar($searchForm,$newfrom,$perpage,$endofsearch,$total_rows);

}

$retHTML ='';

if (! empty($res)) {
	foreach($res as $r) {

		$retHTML .= getInvoiceRowHTML($r);
	}

}else{
	$retHTML .= <<<EOF
		<div class="alert alert-warning" role="alert">
        <strong>No Invoices found ...</strong>
      </div>
EOF;


}

echo $retHTML ;


if($endofsearch<=$total_rows){
	printSearchFooter($newfrom,$perpage,$query,  '',  '',  '', '',$total_rows);
}

include "/srv/ath/pub/cust/tmpl/footer.php";
?>