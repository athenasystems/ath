<?php
$section = "Stock";
$page = "Stock";

include "/srv/ath/src/php/mng/common.php";

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {
    
    // Update DB
    $stockUpdate = new Stock();
    
    $stockUpdate->setStockid($_GET['id']);
    $stockUpdate->setSku($_POST['sku']);
    $stockUpdate->setName($_POST['name']);
    $stockUpdate->setDescription($_POST['description']);
    $stockUpdate->setStockq($_POST['stockq']);
    $stockUpdate->setPrice($_POST['price']);
    // $stockUpdate->setCopytitle($_POST['copytitle']);
    // $stockUpdate->setCopybody($_POST['copybody']);
    // $stockUpdate->setCopyfeatures($_POST['copyfeatures']);
    // $stockUpdate->setCopyterms($_POST['copyterms']);
    // $stockUpdate->setCopyimage($_POST['copyimage']);
    
    $stockUpdate->updateDB();
    
    header("Location: /stock/?ItemAdded=y");
    exit();
}
$pageTitle = "Stock Page";
include "/srv/ath/pub/mng/tmpl/header.php";

$stock = new Stock();
// Load DB data into object
$stock->setStockid($_GET['id']);
$stock->loadStock();
$all = $stock->getAll();

?>
<form role="form"
	action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">

	<fieldset class="form-group">
	
	<?php
	foreach ($all as $key => $value) {
	    if (isset($_POST[$key]) ) {
	        $all[$key]=$_POST[$key];
	    }
	}
		
html_hidden('stockid', $_GET['id']);

html_text('Name', 'name', $all['name']);

html_text('Description', 'description', $all['description']);
html_text('Stock Level', 'stockq', $all['stockq']);
html_text('SKU', 'sku', $all['sku']);
html_text('Price', 'price', $all['price']);

?>
	</fieldset>
<?php

html_button("Save Changes");

?>
	
	</fieldset>


</form>
<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
