<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Rfq.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$rfqUpdate = new Rfq();

	$rfqUpdate->setRfqid($_POST['rfqid']);
	$rfqUpdate->setContent($_POST['content']);
	$rfqUpdate->setQuantity($_POST['quantity']);
	$rfqUpdate->setFname($_POST['fname']);
	$rfqUpdate->setSname($_POST['sname']);
	$rfqUpdate->setEmail($_POST['email']);
	$rfqUpdate->setTel($_POST['tel']);
	$rfqUpdate->setCo_name($_POST['co_name']);
	$rfqUpdate->setIncept($_POST['incept']);

	$rfqUpdate->updateDB();
}
$pageTitle = "Rfq Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";


$rfq = new Rfq();
// Load DB data into object
$rfq->setRfqid($_GET['id']);
$rfq->loadRfq();
$all = $rfq->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="rfqid" id="rfqid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="content">content</label>
	<input type="text" name="content" id="content" value="<?php echo $rfq->getContent();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="quantity">quantity</label>
	<input type="text" name="quantity" id="quantity" value="<?php echo $rfq->getQuantity();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="fname">fname</label>
	<input type="text" name="fname" id="fname" value="<?php echo $rfq->getFname();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="sname">sname</label>
	<input type="text" name="sname" id="sname" value="<?php echo $rfq->getSname();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="email">email</label>
	<input type="text" name="email" id="email" value="<?php echo $rfq->getEmail();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="tel">tel</label>
	<input type="text" name="tel" id="tel" value="<?php echo $rfq->getTel();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="co_name">co_name</label>
	<input type="text" name="co_name" id="co_name" value="<?php echo $rfq->getCo_name();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $rfq->getIncept();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
