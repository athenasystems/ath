<?php

 $pwdFormats= array(
"usr" => "s",
"staffid" => "i",
"custid" => "i",
"suppid" => "i",
"contactsid" => "i",
"seclev" => "i",
"pw" => "s",
"init" => "s",
"lastlogin" => "i");


class Pwd
{
private $usr;
private $staffid;
private $custid;
private $suppid;
private $contactsid;
private $seclev;
private $pw;
private $init;
private $lastlogin;
		
	public function setUsr($usr)
	{
		$this->usr = $usr;
	}

	public function getUsr()
	{
		return $this->usr;
	}
		
	public function setStaffid($staffid)
	{
		$this->staffid = $staffid;
	}

	public function getStaffid()
	{
		return $this->staffid;
	}
		
	public function setCustid($custid)
	{
		$this->custid = $custid;
	}

	public function getCustid()
	{
		return $this->custid;
	}
		
	public function setSuppid($suppid)
	{
		$this->suppid = $suppid;
	}

	public function getSuppid()
	{
		return $this->suppid;
	}
		
	public function setContactsid($contactsid)
	{
		$this->contactsid = $contactsid;
	}

	public function getContactsid()
	{
		return $this->contactsid;
	}
		
	public function setSeclev($seclev)
	{
		$this->seclev = $seclev;
	}

	public function getSeclev()
	{
		return $this->seclev;
	}
		
	public function setPw($pw)
	{
		$this->pw = $pw;
	}

	public function getPw()
	{
		return $this->pw;
	}
		
	public function setInit($init)
	{
		$this->init = $init;
	}

	public function getInit()
	{
		return $this->init;
	}
		
	public function setLastlogin($lastlogin)
	{
		$this->lastlogin = $lastlogin;
	}

	public function getLastlogin()
	{
		return $this->lastlogin;
	}

	public function getAll()
	{
		$ret = array(
		'staffid'=>$this->getStaffid(),
		'custid'=>$this->getCustid(),
		'suppid'=>$this->getSuppid(),
		'contactsid'=>$this->getContactsid(),
		'seclev'=>$this->getSeclev(),
		'pw'=>$this->getPw(),
		'init'=>$this->getInit(),
		'lastlogin'=>$this->getLastlogin());
		return $ret;
	}

	public function loadPwd() {
		global $db;
		if(!isset($this->usr)){
			return "No Pwd ID";
		}		
		$res = $db->select('SELECT usr,staffid,custid,suppid,contactsid,seclev,pw,init,lastlogin FROM pwd WHERE usr=?', array($this->usr), 'd');
		$r=$res[0];
		$this->setUsr($r->usr);
		$this->setStaffid($r->staffid);
		$this->setCustid($r->custid);
		$this->setSuppid($r->suppid);
		$this->setContactsid($r->contactsid);
		$this->setSeclev($r->seclev);
		$this->setPw($r->pw);
		$this->setInit($r->init);
		$this->setLastlogin($r->lastlogin);

	}


	public function updateDB() {
		global $db;
		global $pwdFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'usr'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $pwdFormats[$key];
			}
		}
		$res = $db->update('pwd', $data, $format, array('usr'=>$this->usr), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $pwdFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $pwdFormats[$key];
			}
		}
		$res = $db->insert('pwd', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->usr)){
			return "No Pwd ID";
		}
		$res = $db->delete('pwd', $this->usr, 'usr');
		return $res;
    }
}
?>