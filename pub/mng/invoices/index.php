<?php


$section = "Invoices";
$page = "Invoices";

include "/srv/ath/src/php/mng/common.php";

$errors = array();


$pagetitle = "Home";
$pagescript = array();
$pagestyle = array();

$query = ( (isset($_GET['q']))  &&
		($_GET['q']!='')
) ? $_GET['q'] : '';

// $contactsid = ( (isset($_GET['contactsid'])) &&
// 		(is_numeric($_GET['contactsid'])) &&
// 		($_GET['contactsid']>0)
// ) ? $_GET['contactsid'] : '';

$custid = ( (isset($_GET['custid'])) &&
		(is_numeric($_GET['custid'])) &&
		($_GET['custid']>0)
) ? $_GET['custid'] : '';


if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

	if((isset($_GET['id']))&&(is_numeric($_GET['id']))&&($_GET['id'])){

		$input['paid'] = time();

		$logContent = 'Invoice Paid for InvoiceID:' . $_GET['id'] ;
		$sqltext = "UPDATE invoices SET paid=". time() ." WHERE invoicesid=" . $_GET['id'];
		$res = $dbsite->db->query($sqltext);

		$logresult = logEvent(26,$logContent);

		$done = 1;
	}

}

if( (isset($_GET['go'])) && ($_GET['go'] == "undopaid") ){

	if((isset($_GET['id']))&&(is_numeric($_GET['id']))&&($_GET['id'])){

		$input['paid'] = 0;

		$logContent = 'Invoice marked UNPaid for InvoiceID:' . $_GET['id'] ;

		$sqltext = "UPDATE invoices SET paid=0 WHERE invoicesid=" . $_GET['id'];
		$res = $dbsite->db->query($sqltext);


		$logresult = logEvent(26,$logContent);

		$done = 1;
	}

}

include "/srv/ath/pub/mng/tmpl/header.php";

include "helptab.php";



if(!isset($siteMods['invoices'])){
	?>
<h2>This Athena Module has not been activated</h2>
<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
exit;
}

?>
<h2 style="margin-top: 0px;">
	Invoices <a class="btn btn-primary btn-xs" href="/invoices/add">Add New
		Invoice</a>
</h2>
<?php
$from 	 = ((isset($_GET['from']))&&(is_numeric($_GET['from'] ))) ? $_GET['from'] : 0;
$perpage = ((isset($_GET['perpage']))&&(is_numeric($_GET['perpage'] ))) ? $_GET['perpage'] : $ppage;
$newfrom = $from + $perpage;

$sqltext = "SELECT SQL_CALC_FOUND_ROWS DISTINCT invoices.invoicesid,
invoices.paid,invoices.sent,
invoiceno,invoices.incept,co_name,colour
FROM invoices,items,jobs,cust
WHERE invoices.invoicesid=jobs.invoicesid
AND jobs.itemsid = items.itemsid
AND jobs.custid=cust.custid";

$searchHelp ='';
if($query!=''){
	$sqltext .= " AND invoices.invoiceno LIKE '" . $query . "%' ";
}

if($custid!=''){
	$sqltext .= " AND jobs.custid=" . $custid . ' ';
	// 	if($contactsid!=''){
	// 		$sqltext .= "AND quotes.contactsid=" . $contactsid . ' ';
	// 	}
}
$sqltext .= " ORDER BY invoicesid DESC LIMIT $from,$perpage";
#print $sqltext;
$res = $dbsite->query($sqltext); # or die("Cant get invoices");

$total_rows = getTotalRows();
$endofsearch = ($total_rows<=$newfrom) ? $total_rows : ($newfrom) ;

if(($endofsearch<=$total_rows)||($query!='')||($_GET['custid']!='')){

	$select = customer_select_search("Customer", "custid", $custid,1,'','');
	$searchForm ='<input name="q" id="q" value="'.$query.'"
	class=" form-control" placeholder="Search Invoice No" type="text">'. $select
	;

	printSearchBar($searchForm,$newfrom,$perpage,$endofsearch,$total_rows);

}

$retHTML = '';

$helpcnt = 1;
if (! empty($res)) {
	foreach($res as $r) {

		if($helpcnt){
			if($query!=''){
				$searchHelp .= 'Invoice No:'.$query . ' ';
			}
			if($custid!=''){
				$searchHelp .= ' Customer:' . $r->co_name;
				if($contactsid!=''){
					$searchHelp .= ' Contact:' . getCustExtName($_GET['contactsid']) ;
				}

			}
			$helpcnt--;
		}
		$retHTML .= getInvoiceRowHTML($r);
	}

	$retHTML .= '';


}else{
	$retHTML .= <<<EOF
		<div class="alert alert-warning" role="alert">
        <strong>No Invoices found ...</strong>
      </div>
EOF;

}

if($searchHelp!=''){
	?>
<span style="color: #333; padding: 6px; margin: 4px;">Searching on: <?php echo $searchHelp ; ?>
</span>
<?php
}

echo $retHTML;


if($endofsearch<=$total_rows){
	printSearchFooter($newfrom,$perpage,$query,  $custid,  '',  '', '',$total_rows);
}


include "/srv/ath/pub/mng/tmpl/footer.php";
?>