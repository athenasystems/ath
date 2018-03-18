<?php
$section = "Contacts";
$page = "Customers";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

$pagetitle = "Customers";
$pagescript = array();
$pagestyle = array();

$query = ( (isset($_GET['q']))  &&
		($_GET['q']!='')
) ? $_GET['q'] : '';

$co_name = ( (isset($_GET['q'])) &&
		($_GET['q']!='')
) ? $_GET['q'] : '';

include "/srv/ath/pub/mng/tmpl/header.php";

?>
<h2 style="margin-top: 0px;">
	Customers <a class="btn btn-primary btn-xs" href="/customers/add.php"
		title="Add a new customer"> Add a new customer</a>
</h2>

<?php
$from 	 = ((isset($_GET['from']))&&(is_numeric($_GET['from'] ))) ? $_GET['from'] : 0;
$perpage = ((isset($_GET['perpage']))&&(is_numeric($_GET['perpage'] ))) ? $_GET['perpage'] : $ppage;
$newfrom = $from + $perpage;

$sqltext = "SELECT SQL_CALC_FOUND_ROWS * FROM cust WHERE co_name LIKE '" . $co_name . "%'";
$sqltext .= " AND live=1 AND custid>0 ORDER BY co_name LIMIT $from,$perpage";
#print $sqltext;
$res = $dbsite->query($sqltext); # or die("Cant get customers");

$total_rows = getTotalRows();
$endofsearch = ($total_rows<=$newfrom) ? $total_rows : ($newfrom) ;

if(($endofsearch<=$total_rows)||(isset($_GET['q']))){

	$searchForm ='<label for="q"></label>
	<input type="text" id="q" name="q" value="'.$query.'" style="width: 260px;"
	placeholder="Search By Customer Name" class=" form-control">';
	printSearchBar($searchForm,$newfrom,$perpage,$endofsearch,$total_rows);

	$custid = (isset($custid)) ? $custid:'';
	$contactsid = (isset($contactsid)) ? $contactsid:'';
}
$retHTML = '';

if (! empty($res)) {
	foreach($res as $r) {


		$custid = $r->custid;
		$co_name = $r->co_name;
		$colour = $r->colour;


		$retHTML .= <<<EOF
<div class="panel panel-default">
   <div class="panel-heading">
        <div style="width:10px;background-color:$colour;float:left;margin-right:5px;">&nbsp;</div>
        <h3 class="panel-title">$co_name</h3>
    </div>
    <div class="panel-body">
        <a href="/customers/view.php?id=$custid">View Full Details</a> |
        <a href="/customers/edit.php?id=$custid">Edit</a>
EOF;
		if(isset($siteMods['custport'])){
			$retHTML .= <<<EOF
         |
		<a href="/loginas.php?cid=$custid&sitesid=$sitesid" target="_blank" title="Log In As $co_name">
		 Customer Control Panel</a>
EOF;
		}

		$retHTML .= <<<EOF
     </div>
</div>

EOF;


	}

}else{
	$retHTML .= <<<EOF

		<div class="alert alert-warning" role="alert">
        <strong>No Customers found ...</strong>
      </div>
EOF;


}


echo $retHTML;


if($endofsearch<=$total_rows){
	printSearchFooter($newfrom,$perpage,$query,  $custid,  '', '', '',$total_rows);
}

include "/srv/ath/pub/mng/tmpl/footer.php";
?>