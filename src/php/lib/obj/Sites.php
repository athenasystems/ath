<?php

 $sitesFormats= array(
"sitesid" => "i",
"co_name" => "s",
"co_nick" => "s",
"addsid" => "i",
"email" => "s",
"inv_email" => "s",
"inv_contact" => "i",
"colour" => "s",
"status" => "s",
"pid" => "i",
"vat_no" => "s",
"co_no" => "s",
"gmailpw" => "s",
"gmail" => "s",
"incept" => "i",
"subdom" => "s",
"domain" => "s",
"filestr" => "s",
"eoymonth" => "i",
"eoyday" => "i",
"brand" => "i");


class Sites
{
private $sitesid;
private $co_name;
private $co_nick;
private $addsid;
private $email;
private $inv_email;
private $inv_contact;
private $colour;
private $status;
private $pid;
private $vat_no;
private $co_no;
private $gmailpw;
private $gmail;
private $incept;
private $subdom;
private $domain;
private $filestr;
private $eoymonth;
private $eoyday;
private $brand;
		
	public function setSitesid($sitesid)
	{
		$this->sitesid = $sitesid;
	}

	public function getSitesid()
	{
		return $this->sitesid;
	}
		
	public function setCo_name($co_name)
	{
		$this->co_name = $co_name;
	}

	public function getCo_name()
	{
		return $this->co_name;
	}
		
	public function setCo_nick($co_nick)
	{
		$this->co_nick = $co_nick;
	}

	public function getCo_nick()
	{
		return $this->co_nick;
	}
		
	public function setAddsid($addsid)
	{
		$this->addsid = $addsid;
	}

	public function getAddsid()
	{
		return $this->addsid;
	}
		
	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getEmail()
	{
		return $this->email;
	}
		
	public function setInv_email($inv_email)
	{
		$this->inv_email = $inv_email;
	}

	public function getInv_email()
	{
		return $this->inv_email;
	}
		
	public function setInv_contact($inv_contact)
	{
		$this->inv_contact = $inv_contact;
	}

	public function getInv_contact()
	{
		return $this->inv_contact;
	}
		
	public function setColour($colour)
	{
		$this->colour = $colour;
	}

	public function getColour()
	{
		return $this->colour;
	}
		
	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function getStatus()
	{
		return $this->status;
	}
		
	public function setPid($pid)
	{
		$this->pid = $pid;
	}

	public function getPid()
	{
		return $this->pid;
	}
		
	public function setVat_no($vat_no)
	{
		$this->vat_no = $vat_no;
	}

	public function getVat_no()
	{
		return $this->vat_no;
	}
		
	public function setCo_no($co_no)
	{
		$this->co_no = $co_no;
	}

	public function getCo_no()
	{
		return $this->co_no;
	}
		
	public function setGmailpw($gmailpw)
	{
		$this->gmailpw = $gmailpw;
	}

	public function getGmailpw()
	{
		return $this->gmailpw;
	}
		
	public function setGmail($gmail)
	{
		$this->gmail = $gmail;
	}

	public function getGmail()
	{
		return $this->gmail;
	}
		
	public function setIncept($incept)
	{
		$this->incept = $incept;
	}

	public function getIncept()
	{
		return $this->incept;
	}
		
	public function setSubdom($subdom)
	{
		$this->subdom = $subdom;
	}

	public function getSubdom()
	{
		return $this->subdom;
	}
		
	public function setDomain($domain)
	{
		$this->domain = $domain;
	}

	public function getDomain()
	{
		return $this->domain;
	}
		
	public function setFilestr($filestr)
	{
		$this->filestr = $filestr;
	}

	public function getFilestr()
	{
		return $this->filestr;
	}
		
	public function setEoymonth($eoymonth)
	{
		$this->eoymonth = $eoymonth;
	}

	public function getEoymonth()
	{
		return $this->eoymonth;
	}
		
	public function setEoyday($eoyday)
	{
		$this->eoyday = $eoyday;
	}

	public function getEoyday()
	{
		return $this->eoyday;
	}
		
	public function setBrand($brand)
	{
		$this->brand = $brand;
	}

	public function getBrand()
	{
		return $this->brand;
	}

	public function getAll()
	{
		$ret = array(
		'co_name'=>$this->getCo_name(),
		'co_nick'=>$this->getCo_nick(),
		'addsid'=>$this->getAddsid(),
		'email'=>$this->getEmail(),
		'inv_email'=>$this->getInv_email(),
		'inv_contact'=>$this->getInv_contact(),
		'colour'=>$this->getColour(),
		'status'=>$this->getStatus(),
		'pid'=>$this->getPid(),
		'vat_no'=>$this->getVat_no(),
		'co_no'=>$this->getCo_no(),
		'gmailpw'=>$this->getGmailpw(),
		'gmail'=>$this->getGmail(),
		'incept'=>$this->getIncept(),
		'subdom'=>$this->getSubdom(),
		'domain'=>$this->getDomain(),
		'filestr'=>$this->getFilestr(),
		'eoymonth'=>$this->getEoymonth(),
		'eoyday'=>$this->getEoyday(),
		'brand'=>$this->getBrand());
		return $ret;
	}

	public function loadSites() {
		global $db;
		if(!isset($this->sitesid)){
			return "No Sites ID";
		}		
		$res = $db->select('SELECT sitesid,co_name,co_nick,addsid,email,inv_email,inv_contact,colour,status,pid,vat_no,co_no,gmailpw,gmail,incept,subdom,domain,filestr,eoymonth,eoyday,brand FROM sites WHERE sitesid=?', array($this->sitesid), 'd');
		$r=$res[0];
		$this->setSitesid($r->sitesid);
		$this->setCo_name($r->co_name);
		$this->setCo_nick($r->co_nick);
		$this->setAddsid($r->addsid);
		$this->setEmail($r->email);
		$this->setInv_email($r->inv_email);
		$this->setInv_contact($r->inv_contact);
		$this->setColour($r->colour);
		$this->setStatus($r->status);
		$this->setPid($r->pid);
		$this->setVat_no($r->vat_no);
		$this->setCo_no($r->co_no);
		$this->setGmailpw($r->gmailpw);
		$this->setGmail($r->gmail);
		$this->setIncept($r->incept);
		$this->setSubdom($r->subdom);
		$this->setDomain($r->domain);
		$this->setFilestr($r->filestr);
		$this->setEoymonth($r->eoymonth);
		$this->setEoyday($r->eoyday);
		$this->setBrand($r->brand);

	}


	public function updateDB() {
		global $db;
		global $sitesFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'sitesid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $sitesFormats[$key];
			}
		}
		$res = $db->update('sites', $data, $format, array('sitesid'=>$this->sitesid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $sitesFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $sitesFormats[$key];
			}
		}
		$res = $db->insert('sites', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->sitesid)){
			return "No Sites ID";
		}
		$res = $db->delete('sites', $this->sitesid, 'sitesid');
		return $res;
    }
}
?>