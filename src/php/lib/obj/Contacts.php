<?php

 $contactsFormats= array(
"contactsid" => "i",
"title" => "s",
"fname" => "s",
"sname" => "s",
"co_name" => "s",
"role" => "s",
"custid" => "i",
"suppid" => "i",
"addsid" => "i",
"notes" => "s");


class Contacts
{
private $contactsid;
private $title;
private $fname;
private $sname;
private $co_name;
private $role;
private $custid;
private $suppid;
private $addsid;
private $notes;
		
	public function setContactsid($contactsid)
	{
		$this->contactsid = $contactsid;
	}

	public function getContactsid()
	{
		return $this->contactsid;
	}
		
	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function getTitle()
	{
		return $this->title;
	}
		
	public function setFname($fname)
	{
		$this->fname = $fname;
	}

	public function getFname()
	{
		return $this->fname;
	}
		
	public function setSname($sname)
	{
		$this->sname = $sname;
	}

	public function getSname()
	{
		return $this->sname;
	}
		
	public function setCo_name($co_name)
	{
		$this->co_name = $co_name;
	}

	public function getCo_name()
	{
		return $this->co_name;
	}
		
	public function setRole($role)
	{
		$this->role = $role;
	}

	public function getRole()
	{
		return $this->role;
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
		
	public function setAddsid($addsid)
	{
		$this->addsid = $addsid;
	}

	public function getAddsid()
	{
		return $this->addsid;
	}
		
	public function setNotes($notes)
	{
		$this->notes = $notes;
	}

	public function getNotes()
	{
		return $this->notes;
	}

	public function getAll()
	{
		$ret = array(
		'title'=>$this->getTitle(),
		'fname'=>$this->getFname(),
		'sname'=>$this->getSname(),
		'co_name'=>$this->getCo_name(),
		'role'=>$this->getRole(),
		'custid'=>$this->getCustid(),
		'suppid'=>$this->getSuppid(),
		'addsid'=>$this->getAddsid(),
		'notes'=>$this->getNotes());
		return $ret;
	}

	public function loadContacts() {
		global $db;
		if(!isset($this->contactsid)){
			return "No Contacts ID";
		}		
		$res = $db->select('SELECT contactsid,title,fname,sname,co_name,role,custid,suppid,addsid,notes FROM contacts WHERE contactsid=?', array($this->contactsid), 'd');
		$r=$res[0];
		$this->setContactsid($r->contactsid);
		$this->setTitle($r->title);
		$this->setFname($r->fname);
		$this->setSname($r->sname);
		$this->setCo_name($r->co_name);
		$this->setRole($r->role);
		$this->setCustid($r->custid);
		$this->setSuppid($r->suppid);
		$this->setAddsid($r->addsid);
		$this->setNotes($r->notes);

	}


	public function updateDB() {
		global $db;
		global $contactsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'contactsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $contactsFormats[$key];
			}
		}
		$res = $db->update('contacts', $data, $format, array('contactsid'=>$this->contactsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $contactsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $contactsFormats[$key];
			}
		}
		$res = $db->insert('contacts', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->contactsid)){
			return "No Contacts ID";
		}
		$res = $db->delete('contacts', $this->contactsid, 'contactsid');
		return $res;
    }
}
?>