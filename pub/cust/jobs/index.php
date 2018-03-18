<?php

$page = "Jobs";

include "/srv/ath/src/php/cust/common.php";



$errors = array();

$pagetitle = $owner->co_nick." Jobs";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/cust/tmpl/header.php";

if(!isset($siteMods['jobs'])){
	?>
<h2>This Athena Module has not been activated</h2>
<?php
include "/srv/ath/pub/cust/tmpl/footer.php";
exit;
}
if(isset($_GET['q'])){
	$_GET['q'] = preg_replace("/^J/i",'',$_GET['q']);
}else{
	$_GET['q']='';
}
$from 	 = ((isset($_GET['from']))&&(is_numeric($_GET['from'] ))) ? $_GET['from'] : 0;
$perpage = ((isset($_GET['perpage']))&&(is_numeric($_GET['perpage'] ))) ? $_GET['perpage'] : $ppage;
$newfrom = $from + $perpage;
$query = (isset($_GET['q'])) ? stripcslashes( preg_replace("/^Q/i",'',$_GET['q'])):'';
?>

<h2>Jobs</h2>

<?php

$sqltext = "SELECT SQL_CALC_FOUND_ROWS jobs.incept,jobs.itemsid,
jobs.jobno,jobs.jobsid,jobs.done,jobs.invoicesid,
cust.co_name,cust.colour
FROM jobs,items,cust
WHERE items.itemsid=jobs.itemsid
AND jobs.custid=cust.custid
";

if(isset($_GET['q'])){
	$sqltext .= ' AND jobs.jobno LIKE "J' . $_GET['q'] . '%"';
}

$sqltext .= " AND cust.custid=" . $custID;
if(isset($_GET['done'])){
	if($_GET['done']=='y'){
		$sqltext .= " AND jobs.done>0";
	}elseif($_GET['done']=='n'){
		$sqltext .= " AND jobs.done<1";
	}
}
$sqltext .= " ORDER BY jobs.jobsid DESC LIMIT $from,$perpage";
#print $sqltext;
$res = $dbsite->query($sqltext); # or die("Cant get jobs");
$total_rows = getTotalRows();
$endofsearch = ($total_rows<=$newfrom) ? $total_rows : ($newfrom) ;

if(($endofsearch<=$total_rows)||(isset($_GET['q']))||($_GET['custid']!='')){

	$searchForm ='<input name="q" id="q" value="'.$query.'" class=" form-control"
	placeholder="Job Number" type="text">'
	;

	printSearchBar($searchForm,$newfrom,$perpage,$endofsearch,$total_rows);

}

?>

Show :
<a href="/jobs/">All Jobs</a>
|
<a href="/jobs/?done=y">Completed Jobs</a>
|
<a href="/jobs/?done=n">Jobs in Progress</a>
<br>
Showing:
<?php
if(isset($_GET['done'])){
	if($_GET['done']=='y'){
		print "Completed Jobs";
	}elseif($_GET['done']=='n'){
		print "Jobs in Progress";
	}
}else{
	print "All Jobs";
}
?>
<br>
<br>
<?php

if (! empty($res)) {
	foreach($res as $r) {

		print getJobRowHTML($r);
	}
}

if($endofsearch==$newfrom){
	printSearchFooter($newfrom,$perpage,$query,  '',  '',  '', '',$total_rows);
}

include "/srv/ath/pub/cust/tmpl/footer.php" ;
?>