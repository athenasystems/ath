<?php
$section = "Stock";
$page = "Stock";

include "/srv/ath/src/php/mng/common.php";

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$stockNew = new Stock();
	$stockNew->setSku($_POST['sku']);
	$stockNew->setName($_POST['name']);
	$stockNew->setDescription($_POST['description']);
	$stockNew->setStockq($_POST['stockq']);
	$stockNew->setPrice($_POST['price']);
// 	$stockNew->setCopytitle($_POST['copytitle']);
// 	$stockNew->setCopybody($_POST['copybody']);
// 	$stockNew->setCopyfeatures($_POST['copyfeatures']);
// 	$stockNew->setCopyterms($_POST['copyterms']);
// 	$stockNew->setCopyimage($_POST['copyimage']);

	$stockNew->insertIntoDB();

	header("Location: /stock/?ItemAdded=y");
	exit;

}
$pageTitle = "Stock Page";
include "/srv/ath/pub/mng/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">
	
	<fieldset class="form-group">
	
	
	<?php 
	html_hidden('stockid',$_GET['id'] );

	html_text('Name','name',$_POST[name] );

	html_text('Description','description',$_POST[description] );
	html_text('Stock Level','stockq',$_POST[stockq] );
	html_text('SKU','sku',$_POST[sku] );
	html_text('Price','price',$_POST[price] );	
	
	?>
	
	</fieldset>
	
	<fieldset class="form-group">
	<?php
		
			html_button("Save Changes");
	
		?>
	
	</fieldset>
	
</form>
<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
