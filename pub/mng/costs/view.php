<?php
$section = "customers";
$page = "view";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

$pagetitle = "View Cost";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";
include "/srv/ath/src/php/mng/functions_costs.php";

$sqltext = "SELECT * FROM cost_items, costs WHERE cost_itemsid = " . $_GET['id'] . " AND costs.costsid=cost_items.costsid";
//print "$sqltext<br>";

$res = $dbsite->query($sqltext); # or die( "Cant get cost information with id " . $_GET['id'] );
$r = $res[0];

?>
<link
	href="css/style_costs.css" rel="stylesheet" type="text/css">


<h1>View Cost <span> <a href="/costs/edit.php?id=<?php echo $_GET['id']?>"
	title="Edit This Cost">Edit Cost</a> </span></h1>

	<table cellpadding="4">

<?php

$costsid		= $_GET['id'];
$costName 		= getCostName($costsid);
$costDate 		= date("d-m-Y", $r->incept);
$price 			= $r->price;
$quantity_name 	= $r->quantity_name;
$quantity_val	= $r->quantity;
$notes			= $r->notes;
$period			= date("d-m-Y", $r->incept) . " to " . date("d-m-Y", getMostRecentSameCostIncept($r));
$field1_name 	= $r->field1_name;
$field1_val 	= $r->field1_val;
$field1_name 	= $r->field2_name;
$field1_val 	= $r->field2_val;
$field1_name 	= $r->field3_name;
$field1_val 	= $r->field3_val;

# change field1_val to a persons name if its a persony cost
if ($costsid == 4 || $costsid == 8 ){
	$field1_val = getStaffName($field1_val);
}

# Display the cost Name and Date
tablerow("Cost Item",$costName);
tablerow("Date",$costDate);

# Display the cost Period if necessary
if ($r->periodical == 1) {

	tablerow("For Period",$period);
}
	tablerow("Cost (£)",$price);

# Dispaly the cost Quantity if there is one
if ($quantity_val && $quantity_val != 0){

	tablerow($quantity_name,$quantity_val);
}

# Display any extra cost info from field1
if ($field1_val){
	tablerow($field1_name,$field1_val);

}

# Display any extra cost info from field2
if ($field2_val){
	tablerow($field2_name,$field2_val);

}

# Display any extra cost info from field3
if ($field3_val){
	tablerow($field3_name,$field3_val);

}

print $retHTML;


tablerow("Notes",stripslashes($notes));

?>

</table>

<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>