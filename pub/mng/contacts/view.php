<?php


$section = "Contacts";
$page = "Contacts";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

$pagetitle = "Contacts";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";
?>


<h1>
	Contacts <span> <!-- <a href="/contacts/add.php" title="Add a new contact">Add a new contact</a> -->
	</span>
</h1>


<?php

if ( (isset ($_GET['id'])) && (is_numeric ($_GET['id'])) ){

	$sqltext = "SELECT * FROM contacts,adds WHERE contacts.addsid=adds.addsid AND contactsid=" . $_GET['id'] ;
	#print $sqltext;
	$res = $dbsite->query($sqltext); # or die("Cant get contact");

	$r = $res[0];

	tablerow("Name",$r->fname.' '.$r->sname);
	tablerow("Company Name",$r->co_name);
	tablerow("Role",$r->role);
	tablerow("Tel",$r->tel);
	tablerow("Mobile",$r->mob);
	tablerow("Fax",$r->fax);
	tablerow("Email",$r->email);

	tablerow("Address",$r->add1);
	if( (isset($r->add2)) && ($r->add2!='')){
		tablerow("&nbsp;",$r->add2);
	}
	if( (isset($r->add3)) && ($r->add3!='')){
		tablerow("&nbsp;",$r->add3);
	}
	tablerow("City",$r->county);
	tablerow("County",$r->country);
	tablerow("Postcode",$r->postcode);


	?>

<br>
Notes:
<strong><?php echo $r->notes?> </strong>
<?php


}
?>

<?php

include "/srv/ath/pub/mng/tmpl/footer.php";
?>
