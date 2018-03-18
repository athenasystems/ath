<?php
$section = "Quotes";

$page = "Quotes";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

$pagetitle = "Quotes";
$pagescript = array();
$pagestyle = array();

$query = ((isset($_GET['q'])) && ($_GET['q'] != '')) ? $_GET['q'] : '';

$contactsid = ((isset($_GET['contactsid'])) && (is_numeric($_GET['contactsid'])) && ($_GET['contactsid'] > 0)) ? $_GET['contactsid'] : '';

$custid = ((isset($_GET['custid'])) && (is_numeric($_GET['custid'])) && ($_GET['custid'] > 0)) ? $_GET['custid'] : '';

$from = ((isset($_GET['from'])) && (is_numeric($_GET['from']))) ? $_GET['from'] : 0;
$perpage = ((isset($_GET['perpage'])) && (is_numeric($_GET['perpage']))) ? $_GET['perpage'] : $ppage;
$newfrom = $from + $perpage;

include "/srv/ath/pub/mng/tmpl/header.php";
include "helptab.php";

if (! isset($siteMods['quotes'])) {
    ?>
<h2>This Athena Module has not been activated</h2>
<?php
    include "/srv/ath/pub/mng/tmpl/footer.php";
    exit();
}

?>
<h2 style="margin-top: 0px;">
	Quotes <a class="btn btn-primary btn-xs" href="/quotes/add"
		title="Add new quote">Add a New Quote</a> <a
		class="btn btn-primary btn-xs" href="/rfq" title="Requests for Quote">Requests
		for Quote</a>
</h2>
<?php
$sqltext = "SELECT SQL_CALC_FOUND_ROWS DISTINCT quotes.quotesid, quotes.staffid,
quotes.custid, quotes.contactsid, quotes.quoteno, quotes.incept, quotes.origin,
quotes.agree, quotes.live, quotes.content,quotes.notes,quotes.sent,
cust.fname, cust.sname, cust.co_name, cust.contact, cust.addsid,
cust.inv_email, cust.inv_contact, cust.colour
FROM quotes,cust
WHERE quotesid>0
AND quotes.custid=cust.custid
AND quotes.origin<>'tasks'
AND quotesid>0 ";

$query = preg_replace('/Q/', '', $query);

if ($query != '') {
    $sqltext .= "AND quotes.quoteno LIKE '" . $query . "%' ";
}

if ($custid != '') {
    $sqltext .= "AND quotes.custid=" . $custid . ' ';

    if ($contactsid != '') {
        $sqltext .= "AND quotes.contactsid=" . $contactsid . ' ';
    }
}
$sqltext .= "ORDER BY quotesid DESC LIMIT $from,$perpage";
// print $sqltext;
$res = $dbsite->query($sqltext); // or die("Cant get Quotes");

$total_rows = getTotalRows();
$endofsearch = ($total_rows <= $newfrom) ? $total_rows : ($newfrom);

if (($endofsearch<=$total_rows) || (isset($_GET['q'])) || ($custid != '')) {

    $select = customer_select_search("Customer", "custid", $custid, 1, '', '');
    $searchForm = '<input name="q" id="q" value="' . $query . '" class=" form-control"
	placeholder="Quote Number" type="text">' . $select;

    printSearchBar($searchForm, $newfrom, $perpage, $endofsearch, $total_rows);

    // perpage_select('Per Page','perpage',$perpage,$query,$custid,'',$contactsid);
}

$helpcnt = 1;
$retHTML = '';
if (! empty($res)) {
    foreach ($res as $rq) {

        if ($helpcnt) {
            if ($query != '') {
                $searchHelp .= 'Quote No:' . $query . ' ';
            }
            if ($custid != '') {
                $searchHelp .= ' Customer:' . $rq->co_name;
                if ($contactsid != '') {
                    $searchHelp .= ' Contact:' . getCustExtName($rq->contactsid);
                }
            }
            $helpcnt --;
        }

        $retHTML .= getQuoteRowHTML($rq);
    }
} else {
    $retHTML .= <<<EOF
		<div class="alert alert-warning" role="alert">
        <strong>No Quotes found ...</strong>
      </div>


EOF;
}
$retHTML .= '';

if ((isset($searchHelp)) && ($searchHelp != '')) {
    ?>

<div>
	Searching on:
	<?php echo $searchHelp ; ?>
</div>
<?php
}
print $retHTML;

if ($endofsearch<=$total_rows) {
    printSearchFooter($newfrom, $perpage, $query, $custid, '', '', '', $total_rows);
}

include "/srv/ath/pub/mng/tmpl/footer.php";
?>
