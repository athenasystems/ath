<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Rfq.php"; 
 

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Insert into DB
	$rfqNew = new Rfq();
	$rfqNew->setContent($_POST['content']);
	$rfqNew->setQuantity($_POST['quantity']);
	$rfqNew->setFname($_POST['fname']);
	$rfqNew->setSname($_POST['sname']);
	$rfqNew->setEmail($_POST['email']);
	$rfqNew->setTel($_POST['tel']);
	$rfqNew->setCo_name($_POST['co_name']);
	$rfqNew->setIncept($_POST['incept']);

	$rfqNew->insertIntoDB();
		
	header("Location: /rfq/?ItemAdded=y");

}
$pageTitle = "Rfq Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";
?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="rfqid" id="rfqid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="content">content</label>
	<input type="text" name="content" id="content" value="<?php echo $_POST[content];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="quantity">quantity</label>
	<input type="text" name="quantity" id="quantity" value="<?php echo $_POST[quantity];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="fname">fname</label>
	<input type="text" name="fname" id="fname" value="<?php echo $_POST[fname];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="sname">sname</label>
	<input type="text" name="sname" id="sname" value="<?php echo $_POST[sname];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="email">email</label>
	<input type="text" name="email" id="email" value="<?php echo $_POST[email];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="tel">tel</label>
	<input type="text" name="tel" id="tel" value="<?php echo $_POST[tel];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="co_name">co_name</label>
	<input type="text" name="co_name" id="co_name" value="<?php echo $_POST[co_name];?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $_POST[incept];?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
