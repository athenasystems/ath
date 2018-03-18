<?php
$section = "Contacts";
$page = "Suppliers";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

$pagetitle = "Suppliers";
$pagescript = array();
$pagestyle = array();

$query = ( (isset($_GET['q']))  &&
		($_GET['q']!='')
) ? $_GET['q'] : '';

$co_name = ( (isset($_GET['q'])) &&
		($_GET['q']!='')
) ? $_GET['q'] : '';

include "/srv/ath/pub/mng/tmpl/header.php";

#include "/srv/ath/pub/mng/contacts/linkstab.php";
?>

<h2 style="margin-top: 0px;">
	Suppliers <a  class="btn btn-primary btn-xs" href="/suppliers/add.php"
		title="Add a new supplier">Add a new supplier</a>
</h2>


<?php
$from 	 = ((isset($_GET['from']))&&(is_numeric($_GET['from'] ))) ? $_GET['from'] : 0;
$perpage = ((isset($_GET['perpage']))&&(is_numeric($_GET['perpage'] ))) ? $_GET['perpage'] : $ppage;
$newfrom = $from + $perpage;

$sqltext = "SELECT SQL_CALC_FOUND_ROWS *
FROM supp
WHERE co_name LIKE '" . $co_name . "%'
ORDER BY co_name
LIMIT $from,$perpage";
$res = $dbsite->query($sqltext); # or die("Cant get Suppliers");

$total_rows = getTotalRows();
$endofsearch = ($total_rows<=$newfrom) ? $total_rows : ($newfrom) ;

if(($endofsearch<=$total_rows)||(isset($_GET['q']))){

	$searchForm ='<label for="q"></label>
	<input type="text" id="q" name="q" value="'.$query.'" style="width: 260px;"
	placeholder="Search By Supplier Name" class=" form-control">';
	printSearchBar($searchForm,$newfrom,$perpage,$endofsearch,$total_rows);

	$suppid = (isset($suppid)) ? $suppid:'';
	$contactsid = (isset($contactsid)) ? $contactsid:'';
}

$retHTML = '';


if (! empty($res)) {
	foreach($res as $r) {


		$suppid = $r->suppid;
		$co_name = $r->co_name;
		$colour = $r->colour;

		$retHTML .= <<<EOF
<div class="panel panel-default">
	<div class="panel-heading">
	<div style="width:10px;background-color:$colour;float:left;margin-right:5px;">&nbsp;</div>
		<h3 class="panel-title">$co_name</h3>
	</div>
	<div class="panel-body">
		<a href="/suppliers/view.php?id=$suppid">View Full Details</a> |
		<a href="/suppliers/edit.php?id=$suppid">Edit</a>
EOF;
		if(isset($siteMods['suppport'])){
		$retHTML .= <<<EOF
 | <a href="/loginas.php?sid=$suppid&sitesid=$sitesid" target="_blank" title="Log In As $co_name">Supplier CP</a>

EOF;
		}
		$retHTML .= <<<EOF
	</div>
</div>
EOF;
	}

}else{
	$retHTML .= <<<EOF
			No Suppliers found ...
EOF;

}

echo $retHTML;

if($endofsearch<=$total_rows){
	printSearchFooter($newfrom,$perpage,$query,  '',  '',  '', '',$total_rows);
}

include "/srv/ath/pub/mng/tmpl/footer.php";
?>