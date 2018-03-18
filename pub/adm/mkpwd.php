<?php #exit;
$section = "owner";$page = "edit";
include "/srv/ath/src/php/adm/common.php";

$pagetitle = "";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/blank_header.php";

# Get Site DB Handle
$dbsite = sitedbconnect(100);

$sqltext = "delete from pwd" ;
$dbsite->query($sqltext) or die("Cant ");

$sqltext = "SELECT * FROM contacts WHERE (custid IS NOT NULL AND custid>1) OR (suppid IS NOT NULL AND suppid>0)" ;
#print $sqltext;
#print $sqltext;

$res = $dbsite->query($sqltext); # or die("Cant get cust details");
if (! empty($res)) {
	foreach($res as $r) {

		$pw_init = generatePassword(8);
		$pw = crypt($pw_init);

		if((isset($r->fname)) && (isset($r->sname)) ){

			$login = generateContactlogon($r->fname, $r->sname);

			if((isset($r->custid)) && ($r->custid>0) ){
				$sqltext21 = "INSERT INTO pwd (usr,pw,custid,contactsid,seclev) VALUES ( '$login', '$pw','{$r->custid}','{$r->contactsid}',10);";
			}
			if((isset($r->suppid)) && ($r->suppid>0) ){
				$sqltext21 = "INSERT INTO pwd (usr,pw,suppid,contactsid,seclev) VALUES ( '$login', '$pw','{$r->suppid}','{$r->contactsid}',10);";
			}

			print $sqltext21. '<br>';
			$dbsite->query($sqltext21) or die("Cant add to pwd");


			$sqltext3 = "UPDATE contacts SET init_pw='$pw_init',logon='$login' WHERE contactsid=". $r->contactsid;
			$dbsite->query($sqltext3) or die("Cant ");
		}
	}
}



$sqltext5 = "SELECT staffid,fname,sname,logon,init_pw FROM staff WHERE init_pw IS NOT NULL AND init_pw<>'' and logon IS NOT NULL and logon<>''" ;
#print $sqltext;

$res = $dbsite->query($sqltext5) or die("Cant get staff details");
if (! empty($res)) {
	foreach($res as $r) {

		$pw_init = generatePassword(8);
		$pw = crypt($pw_init);

		$login = $r->logon;
		$seclev = ($r->staffid<4) ? 1 : 10;
		$sqltext51 = "INSERT INTO pwd (usr,pw,staffid,seclev) VALUES ( '$login', '$pw','{$r->staffid}',$seclev);";
		print $sqltext51. '<br>';
		$dbsite->query($sqltext51) or die("Cant add to pwd");


		$sqltext3 = "UPDATE staff SET init_pw='$pw_init' WHERE staffid=". $r->staffid;
		$dbsite->query($sqltext3) or die("Cant ");

	}
}



include "/srv/ath/pub/mng/tmpl/footer.php";
?>
