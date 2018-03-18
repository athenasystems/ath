<?php


$section = "Contacts";
$page = "edit";

include "/srv/ath/src/php/mng/common.php";


$sqltext = "SELECT * FROM contacts,adds WHERE contacts.addsid=adds.addsid AND contactsid='". addslashes($_GET['id']) ."'";
#print "<br/>$sqltext";
$res = $dbsite->query($sqltext); # or die("Cant get contact");
$r = $res[0];

$addsid = $r->addsid;

$errors = array();

if(isset($_GET['remove']) && $_GET['remove'] == "y" && isset($_GET['id']) && is_numeric($_GET['id'])){

	$addsDelete = new Adds();
	$addsDelete->setAddsid($addsid);
	$addsDelete->deleteFromDB();

	$contactsDelete = new Contacts();
	$contactsDelete->setContactsid($_GET['id']);
	$contactsDelete->deleteFromDB();

	header("Location: /contacts/");
	exit();

}


if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){

	$required = array("fname");
	$errors = check_required($required, $_POST);

	if(empty($errors)){

		# Add to Address table
		$addsid = updateDBAddress($_POST,$addsid);

		$contactsUpdate = new Contacts();
		$contactsUpdate->setContactsid($_GET['id']);
		$contactsUpdate->setFname($_POST['fname']);
		$contactsUpdate->setSname($_POST['sname']);
		$contactsUpdate->setCo_name($_POST['co_name']);
		$contactsUpdate->setRole($_POST['role']);
		$contactsUpdate->setCustid($_POST['custid']);
		$contactsUpdate->setSuppid($_POST['suppid']);
		$contactsUpdate->updateDB();

		header("Location: /contacts/?highlight=". $result['id']);
		exit();

	}

}

$pagetitle = "Edit contact";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";

if  ( (isset($_GET['SentAccessEmail'])) && ($_GET['SentAccessEmail']==1) ){


	?>
<div id=help>
	An email has been sent to
	<?php echo $r->fname . ' ' . $r->sname . ' at ' . $r->email;?>
	with access details for the Athena Control Panel
</div>

<?php

}

?>

<script>
<!--
function confirmSubmit()
{
var agree=confirm("Are you sure you wish to delete this Contact?");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>
<br>
<span id=pageactions> <span style="font-size: 90%; color: #999;">For
		this Contact:- </span> <?php
		if (
				(isset($r->email)) && ($r->email!='') &&
				(
						(
								(isset($r->custid)) && ($r->custid!='')) ||
						((isset($r->suppid)) && ($r->suppid!='')
						)
				)
		)

		{
			?> <a href="/mail/contact.access?cid=<?php echo $_GET['id'];?>"
	title="Send Athena Access Details">Send Athena Access Details</a> <?php
		}
		if ($r->fname!='System'){
			?> | <a href="?id=<?php echo $_GET['id']?>&amp;remove=y"
	title="Remove this Contact" class="cancel"
	onclick="return confirmSubmit()">Delete This Contact</a> <?php
		}
		?>
</span>

<h2>Edit Contact</h2>

<form
	action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $_GET['id']?>&amp;go=y"
	enctype="multipart/form-data" method="post">

	<?php echo form_fail(); ?>

	<fieldset class="form-group">

		<ol>

			<?php

			html_text("First Name", "fname", $r->fname);

			html_text("Surname", "sname", $r->sname);

			html_text("Company Name", "co_name", $r->co_name);

			customer_select("Or", "custid", $r->custid);

			#supplier_select("Or/And", "suppid", $r->suppid);

			html_text("Role", "role", $r->role);

			include '/srv/ath/src/php/tmpl/adds.edit.form.php';

			html_textarea("Notes", "notes", $r->notes, "body", "y");
			?>


		</ol>

	</fieldset>

	<fieldset class="form-group">

		<?php
		html_button("Save changes");
		?>



	</fieldset>

</form>



<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>
