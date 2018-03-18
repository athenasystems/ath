<?php // CustIFace.php
class CustIFace implements Cust
{
	public function getCustDets(){
		global $dbsite;

		$sqltext = "SELECT cust.custid, cust.co_name, cust.contact, cust.inv_contact, cust.colour ,cust.filestr ,
		adds.add1, adds.add2, adds.add3, adds.city, adds.county, adds.country,
		adds.postcode, adds.tel, adds.fax, adds.email, adds.web, cust.inv_email
		FROM cust,adds
		WHERE cust.addsid=adds.addsid
		AND cust.custid=" .  $this->custid;
		#print $sqltext;
		$res = $dbsite->query($sqltext); # or die("Cant get cust id");

		$r = $res[0];

		return $r;
	}

}