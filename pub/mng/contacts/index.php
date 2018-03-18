<?php
include "/srv/ath/src/php/mng/common.php";

$errors = array ();

$pagetitle = "Contacts";
$pagescript = array ();
$pagestyle = array ();

$query = ( (isset($_GET['q']))  &&
		($_GET['q']!='')
) ? $_GET['q'] : '';

$section = "Contacts";
$page = "Contacts";

include "/srv/ath/pub/mng/tmpl/header.php";
// include "/srv/ath/pub/mng/contacts/linkstab.php";
?>

<h2 style="margin-top: 0px;">
	Contacts <a class="btn btn-primary btn-xs" href="/contacts/add.php"
		title="Add a new contact">Add a new contact</a>
</h2>

<?php
$from = ((isset ( $_GET ['from'] )) && (is_numeric ( $_GET ['from'] ))) ? $_GET ['from'] : 0;
$perpage = ((isset ( $_GET ['perpage'] )) && (is_numeric ( $_GET ['perpage'] ))) ? $_GET ['perpage'] : $ppage;
$newfrom = $from + $perpage;

$sqltext = "SELECT SQL_CALC_FOUND_ROWS * FROM contacts,adds
WHERE (fname<>'Company' AND sname<>'Admin')
AND contacts.addsid=adds.addsid
AND fname LIKE '" . $query . "%'
ORDER BY fname LIMIT $from,$perpage";
#print $sqltext;
$res = $dbsite->query ( $sqltext );# or die ( "Cant get contacts" );

$total_rows = getTotalRows();
$endofsearch = ($total_rows<=$newfrom) ? $total_rows : ($newfrom) ;

if(($endofsearch<=$total_rows)||($query!='')){

	$searchForm = '<label for="q"></label>
	<input type="text" id="q" name="q" value="' . $query . '" style="width: 160px;"
	placeholder="Search By Name" class=" form-control">';

	printSearchBar ( $searchForm, $newfrom, $perpage, $endofsearch, $total_rows );
}
$retHTML ='';
if (! empty ( $res )) {
	foreach ( $res as $r ) {
		$retHTML .= getContactRowHTML ( $r );
	}
} else {
	$retHTML = <<<EOF
			<div class="alert alert-warning" role="alert">
        <strong>No Contacts found ...</strong>
      </div>
EOF;
}

echo $retHTML;


if($endofsearch<=$total_rows){
	printSearchFooter($newfrom,$perpage,$query,  '',  '',  '', '',$total_rows);
}


include "/srv/ath/pub/mng/tmpl/footer.php";
?>