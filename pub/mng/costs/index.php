<?php
$page = "Costs";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

$pagetitle = "Costs";
$pagescript = array(
    "/js/mng/costs_selector.js"
);
$pagestyle = array();

$query = ((isset($_GET['q'])) && ($_GET['q'] != '')) ? $_GET['q'] : '';

$from = ((isset($_GET['from'])) && (is_numeric($_GET['from']))) ? $_GET['from'] : 0;
$perpage = ((isset($_GET['perpage'])) && (is_numeric($_GET['perpage']))) ? $_GET['perpage'] : $ppage;
$newfrom = $from + $perpage;

include "/srv/ath/pub/mng/tmpl/header.php";

include "helptab.php";

?>
<h2 style="margin-top: 0px;">
	Costs <a class="btn btn-primary btn-xs" href="/costs/add.php"
		title="Add new cost information">Add new cost information</a>
</h2>
<?php
$sqltext = "SELECT SQL_CALC_FOUND_ROWS * FROM exps,athdb$sitesid.costs
	WHERE athdb$sitesid.costs.expsid=exps.expsid";

if ($query != '') {
    $sqltext .= " AND athdb$sitesid.costs.description LIKE '" . $query . "%' ";
}

$sqltext .= " ORDER BY athdb$sitesid.costs.costsid DESC LIMIT $from,$perpage";
#print $sqltext;
$res = $dbsys->query($sqltext); // or die("Cant get Costs");

$total_rows = getTotalRowsSys();
$endofsearch = ($total_rows <= $newfrom) ? $total_rows : ($newfrom);

if (($endofsearch<=$total_rows) || (isset($_GET['q']))) {

    // $select = customer_select_search("Customer", "custid", $custid,1,'','');
    $searchForm = '<input name="q" id="q" value="' . $query . '"class=" form-control"
	placeholder="Search" type="text">';

    printSearchBar($searchForm, $newfrom, $perpage, $endofsearch, $total_rows);
}

$retHTML = '';
if (! empty($res)) {
    foreach ($res as $r) {
        $retHTML .= getCostMiniRowHTML($r);
    }
}
print $retHTML;
?>
<?php

if ($endofsearch<=$total_rows) {
    printSearchFooter($newfrom, $perpage, $query, $custid, '',  '','', $total_rows);
}

include "/srv/ath/pub/mng/tmpl/footer.php";

?>