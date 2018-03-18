<?php 
	

	$section = "Contacts";
	$page = "Staff Times";

	include "/srv/ath/src/php/mng/common.php";

	$errors = array();

	$pagetitle = "Staff Times";
	$pagescript = array();
	$pagestyle = array();

	include "/srv/ath/pub/mng/tmpl/header.php";
	
	$sqltext = "SELECT * from times where staffid=" . $_GET['id'];
	
	#print "<br/>$sqltext";

	$res = $dbsite->query($sqltext); # or die("Cant get the staff times!");
	
?>

<h1>
	Staff Times
	<span>
	
	</span>
</h1>

<?php 
	foreach($res as $r) {

	
		
		
	}

?>


<?php 
	include "/srv/ath/pub/mng/tmpl/footer.php";
?>
