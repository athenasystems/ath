<?php
$section = "Stock";
$page = "Stock";

include "/srv/ath/src/php/mng/common.php";


$pageTitle = "Stock Page";
include "/srv/ath/pub/mng/tmpl/header.php";

if (! isset($siteMods['stock'])) {
	?>
<h2>This Athena Module has not been activated</h2>
<?php
    include "/srv/ath/pub/mng/tmpl/footer.php";
    exit();
}


$from = ((isset($_GET['from'])) && (is_numeric($_GET['from']))) ? $_GET['from'] : 0;
$perpage = ((isset($_GET['perpage'])) && (is_numeric($_GET['perpage']))) ? $_GET['perpage'] : $ppage;
$newfrom = $from + $perpage;

?>
<h2 style="margin-top: 0px;">Stock <a class="btn btn-primary btn-xs" href="/stock/add"
		title="Add new stock">Add new Stock</a> </h2>
		
		
		
		
<?php
$res = $dbsite->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT * FROM stock ORDER BY stockid DESC LIMIT $from,$perpage");

$total_rows = getTotalRows();
$endofsearch = ($total_rows <= $newfrom) ? $total_rows : ($newfrom);

if (($endofsearch<=$total_rows) || (isset($_GET['q'])) || ($custid != '')) {

	#$select = customer_select_search("Customer", "custid", $custid, 1, '', '');
	$searchForm = '<input name="q" id="q" value="' . $query . '" class=" form-control"
	placeholder="Name" type="text">' ;

	printSearchBar($searchForm, $newfrom, $perpage, $endofsearch, $total_rows);

	// perpage_select('Per Page','perpage',$perpage,$query,$custid,'',$contactsid);
}


if (! empty($res)) {
	foreach($res as $r) {
		   ?>
<div class="panel panel-default">
	<div class="panel-heading">
		<strong><?php echo $r->name;?></strong>
	</div>
	<div class="panel-body">
	<?php echo $r->description;?><br>
		<a href="view.php?id=<?php echo $r->stockid;?>">View</a> |
		<a href="edit.php?id=<?php echo $r->stockid;?>">Edit</a>|
		<a href="delete.php?id=<?php echo $r->stockid;?>">Delete</a>
	</div>
</div>
<?php
	}
}else{
	?>
	<div class="alert alert-warning" role="alert">
        <strong>No Stock found ...</strong>
      </div>

	<?php
}


if ($endofsearch<=$total_rows) {
	printSearchFooter($newfrom, $perpage, $query, $custid, '', '', '', $total_rows);
}


include "/srv/ath/pub/mng/tmpl/footer.php";
?>
