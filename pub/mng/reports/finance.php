<?php
$section = "Reports";
$page = "Financials";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

$pagetitle = "Financials";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";
include "helptab.php";

$yearEnd = mktime(0, 0, 0, $owner->eoymonth, $owner->eoyday, date('Y'));
$yearStart = mktime(0, 0, 0, $owner->eoymonth, $owner->eoyday + 1, date('Y') - 1);

?>

<ul>
<li><a href="/costs" title="Costs">
						Costs				</a>
				</li>
</ul>
<h4>
	Financial Year:
	<?php echo date('d/m/Y',$yearStart);?>
	to
	<?php echo date('d/m/Y',$yearEnd);?>
</h4>
<?php
$income = getTotalInvoiceTotals($yearStart, $yearEnd);
$costs = getTotalCosts($yearStart, $yearEnd);
$sections = array();
$expsids = getExpensesIDs();
foreach ($expsids as $expsid) {
    $sectionTotal = getTotalCosts($yearStart, $yearEnd, $expsid);
    $name = getExpensesName($expsid);
    $sections[$name] = $sectionTotal;
}
$noOfInvoices = getNoOfInvoice($yearStart, $yearEnd);
?>


<div class="panel panel-default">
	<div class="panel-heading">

		<h3 class="panel-title">Income</h3>
	</div>
	<div class="panel-body">
		<h4>
    Year Total: 
&pound;
		<?php echo $income;?> 
		</h4>
		<?php echo $noOfInvoices; ?> Invoices |
<a href="/bin/mk.csv.pl?sid=<?php echo $sitesid;?>&t=inv"
			title="Download CSV">Download CSV</a>
	</div>
</div>


<div class="panel panel-default">
	<div class="panel-heading">

		<h3 class="panel-title">Costs</h3>
	</div>
	<div class="panel-body">
		<h4>Year Total: 
&pound;
		<?php echo $costs;?> </h4>
		<a href="/bin/mk.csv.pl?sid=<?php echo $sitesid;?>&t=cost"
			title="Download CSV">Download CSV</a>
<br><br>
		<table>
			<tr>
				<th>Cost Group</th>
				<th>Total</th>
			</tr>
			<?php
foreach ($sections as $key => $value) {
    echo "<tr><td>$key</td><td>$value</td></tr>";
}
?></table>
	</div>
</div>


<div class="panel panel-default">
	<div class="panel-heading">

		<h3 class="panel-title">Profit</h3>
	</div>
	<div class="panel-body">
		<h4>
	Year Total: 
&pound;
	<?php echo ($income - $costs);?>
    </h4>
</div>
</div>

<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
