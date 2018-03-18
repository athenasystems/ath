<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/DB.php";
$db = new DB();
include "/srv/ath/src/pub/phpstartpoint/athdb100/lib/Mail.php";
if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {

	# Update DB
	$mailUpdate = new Mail();

	$mailUpdate->setMailid($_POST['mailid']);
	$mailUpdate->setAddto($_POST['addto']);
	$mailUpdate->setAddname($_POST['addname']);
	$mailUpdate->setSubject($_POST['subject']);
	$mailUpdate->setBody($_POST['body']);
	$mailUpdate->setSent($_POST['sent']);
	$mailUpdate->setIncept($_POST['incept']);
	$mailUpdate->setTimesent($_POST['timesent']);
	$mailUpdate->setDocname($_POST['docname']);
	$mailUpdate->setDoctitle($_POST['doctitle']);
	$mailUpdate->setKind($_POST['kind']);

	$mailUpdate->updateDB();
}
$pageTitle = "Mail Page";
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/header.php";


$mail = new Mail();
// Load DB data into object
$mail->setMailid($_GET['id']);
$mail->loadMail();
$all = $mail->getAll();


?>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']?>?go=y&amp;id=<?php echo $_GET['id']; ?>"
	enctype="multipart/form-data" method="post">	
	    <div class="form-group"><input type="hidden" name="mailid" id="mailid" value="<?php echo $_GET['id'];?>"></div>
	    
	
	<div class="form-group">
	<label for="addto">addto</label>
	<input type="text" name="addto" id="addto" value="<?php echo $mail->getAddto();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="addname">addname</label>
	<input type="text" name="addname" id="addname" value="<?php echo $mail->getAddname();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="subject">subject</label>
	<input type="text" name="subject" id="subject" value="<?php echo $mail->getSubject();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="body">body</label>
	<input type="text" name="body" id="body" value="<?php echo $mail->getBody();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="sent">sent</label>
	<input type="text" name="sent" id="sent" value="<?php echo $mail->getSent();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="incept">incept</label>
	<input type="text" name="incept" id="incept" value="<?php echo $mail->getIncept();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="timesent">timesent</label>
	<input type="text" name="timesent" id="timesent" value="<?php echo $mail->getTimesent();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="docname">docname</label>
	<input type="text" name="docname" id="docname" value="<?php echo $mail->getDocname();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="doctitle">doctitle</label>
	<input type="text" name="doctitle" id="doctitle" value="<?php echo $mail->getDoctitle();?>" class="form-control">
	</div>
	
	
	<div class="form-group">
	<label for="kind">kind</label>
	<input type="text" name="kind" id="kind" value="<?php echo $mail->getKind();?>" class="form-control">
	</div>
	
<input type=submit value="Save Changes" class="btn btn-default btn-success">
</form>
<?php
include "/srv/ath/src/pub/phpstartpoint/athdb100/tmpl/footer.php";
?>
