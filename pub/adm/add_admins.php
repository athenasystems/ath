<?php #exit;
$section = "owner";$page = "edit";
include "/srv/ath/src/php/adm/common.php";

$pagetitle = "";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/blank_header.php";

# Get Site DB Handle
$dbsite = sitedbconnect(100);

$sqltext = "SELECT * FROM cust" ;
#print $sqltext;
#print $sqltext;

$res = $dbsite->query($sqltext); # or die("Cant get cust details");
if (! empty($res)) {
	foreach($res as $r) {

		$pw_init = generatePassword(8);
		$pw = crypt($pw_init);
		$login = 'CA'.$r->custid;

		$sqltext2 = "INSERT INTO contacts (fname,sname,addsid,custid,logon,init_pw) VALUES ('System','Administrator', {$r->addsid}, {$r->custid},'$login', '$pw');";

		print $sqltext2. "\n";
		$dbsite->query($sqltext2) or die("Cant add to contacts");
		$db_add_id = $dbsite->insert_id;


		$sqltext3 = "INSERT INTO pwd (usr,pw,custid,contactsid,seclev) VALUES ( '$login', '$pw',{$r->custid},$db_add_id,1);";
		print $sqltext3. "\n";
		$dbsite->query($sqltext3) or die("Cant add to pwd");
	}
}


$sqltext = "SELECT * FROM supp" ;
#print $sqltext;
#print $sqltext;

$res = $dbsite->query($sqltext); # or die("Cant get supp details");
if (! empty($res)) {
	foreach($res as $r) {

		$pw_init = generatePassword(8);
		$pw = crypt($pw_init);
		$login = 'SA'.$r->suppid;

		$sqltext22 = "INSERT INTO contacts (fname,sname,addsid,suppid,logon,init_pw) VALUES ('System','Administrator', {$r->addsid}, {$r->suppid},'$login', '$pw');";

		print $sqltext22.  "\n";
		$dbsite->query($sqltext22) or die("Cant add to contacts");
		$db_add_id = $dbsite->insert_id;


		$sqltext32 = "INSERT INTO pwd (usr,pw,suppid,contactsid,seclev) VALUES ( '$login', '$pw',{$r->suppid},$db_add_id,1);";
		print $sqltext32. "\n";
		$dbsite->query($sqltext32) or die("Cant add to pwd");
	}
}




include "/srv/ath/pub/mng/tmpl/footer.php";
?>
