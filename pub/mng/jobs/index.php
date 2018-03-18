<?php
$section = "Jobs";
$page = "Jobs";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

if ((isset($_GET['go'])) && ($_GET['go'] == "mkpdf")) {

    passthru("perl /srv/ath/src/perl/mng/root_delivery_note.pl " . $_GET['id']);
}

$pagetitle = "Jobs";
$pagescript = array();
$pagestyle = array();

$query = ((isset($_GET['q'])) && ($_GET['q'] != '')) ? $_GET['q'] : '';

$contactsid = ((isset($_GET['contactsid'])) && (is_numeric($_GET['contactsid'])) && ($_GET['contactsid'] > 0)) ? $_GET['contactsid'] : '';

$custid = ((isset($_GET['custid'])) && (is_numeric($_GET['custid'])) && ($_GET['custid'] > 0)) ? $_GET['custid'] : '';

$showDone = ((isset($_GET['sd'])) && (is_numeric($_GET['sd'])) && ($_GET['sd'] > 0)) ? $_GET['sd'] : '';

include "/srv/ath/pub/mng/tmpl/header.php";

include "helptab.php";

if (! isset($siteMods['jobs'])) {
    ?>
<h2>This Athena Module has not been activated</h2>
<?php
    include "/srv/ath/pub/mng/tmpl/footer.php";
    exit();
}
?>
<h2 style="margin-top: 0px;">
	Jobs <a class="btn btn-primary btn-xs" href="/jobs/add.php"
		title="Add a new Job">Add a new Job</a>
</h2>
<?php

$from = ((isset($_GET['from'])) && (is_numeric($_GET['from']))) ? $_GET['from'] : 0;
$perpage = ((isset($_GET['perpage'])) && (is_numeric($_GET['perpage']))) ? $_GET['perpage'] : $ppage;
$newfrom = $from + $perpage;

$sqltext = "SELECT SQL_CALC_FOUND_ROWS jobs.incept,jobs.itemsid,
jobs.jobno,jobs.jobsid,jobs.done,jobs.invoicesid,
cust.co_name,cust.colour
FROM jobs,items,cust
WHERE items.itemsid=jobs.itemsid
AND jobs.custid=cust.custid
";

if ($showDone == '') {
    $sqltext .= "AND jobs.done=0 ";
}

$searchHelp = '';
if ($query != '') {
    $sqltext .= "AND jobs.jobno LIKE 'J" . $query . "%' ";
}

if ($custid != '') {
    $sqltext .= "AND jobs.custid=" . $custid . ' ';
}
$sqltext .= "ORDER BY jobs.jobsid DESC LIMIT $from,$perpage";
// print $sqltext;
$res = $dbsite->query($sqltext); // or die("Cant get jobs");

$total_rows = getTotalRows();
$endofsearch = ($total_rows <= $newfrom) ? $total_rows : ($newfrom);

if (($endofsearch <= $total_rows) || ($query != '') || ($_GET['custid'] != '')) {

    $sd = '<label for="sd" class="c-input c-checkbox">Show Finished
<input name="sd" value="1" id="sd" type="checkbox"';
    if (isset($_GET['sd'])) {
        $sd .= ' checked=checked ';
    }
    $sd .= ' onchange="document.getElementById(\'from\').value=0;document.getElementById(\'searchform\').submit()"></label>';

    $select = customer_select_search("Customer", "custid", $custid, 1, '', '');
    $searchForm = '<input name="q" id="q" value="' . $query . '"
	class=" form-control" placeholder="Search Job No - J" type="text">' . $select . $sd  ;

    printSearchBar($searchForm, $newfrom, $perpage, $endofsearch, $total_rows);
}

$helpcnt = 1;
$retHTML = '';
if (! empty($res)) {

    foreach ($res as $r) {
        // $r = $res[0];
        if ($helpcnt) {
            if ($query != '') {
                $searchHelp .= 'Job No:' . $query . ' ';
            }
            if ($custid != '') {
                $searchHelp .= ' Customer:' . $r->co_name;
                if ($contactsid != '') {
                    $searchHelp .= ' Contact:' . getCustExtName($contactsid);
                }
            }
            $helpcnt --;
        }
        $retHTML .= getJobRowHTML($r);
    }
} else {
    $retHTML .= <<<EOF
		<div class="alert alert-warning" role="alert">
        <strong>
			No jobs found ...</strong>
      </div>

EOF;
}

if ($searchHelp != '') {
    ?>
<h4>
	Searching on:
	<?php echo $searchHelp ; ?>
</h4>
<?php
}

echo $retHTML;

if ($endofsearch <= $total_rows) {
    printSearchFooter($newfrom, $perpage, $query, $custid, '',  '','', $total_rows);
}

include "/srv/ath/pub/mng/tmpl/footer.php";
?>