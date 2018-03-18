<?php

 $suppFormats= array(
"suppid" => "i",
"co_name" => "s",
"fname" => "s",
"sname" => "s",
"contact" => "s",
"addsid" => "i",
"inv_email" => "s",
"inv_contact" => "i",
"colour" => "s",
"live" => "i");


class Supp
{
private $suppid;
private $co_name;
private $fname;
private $sname;
private $contact;
private $addsid;
private $inv_email;
private $inv_contact;
private $colour;
private $live;
		
	public function setSuppid($suppid)
	{
		$this->suppid = $suppid;
	}

	public function getSuppid()
	{
		return $this->suppid;
	}
		
	public function setCo_name($co_name)
	{
		$this->co_name = $co_name;
	}

	public function getCo_name()
	{
		return $this->co_name;
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
		
	public function setContact($contact)
	{
		$this->contact = $contact;
	}

	public function getContact()
	{
		return $this->contact;
	}
		
	public function setAddsid($addsid)
	{
		$this->addsid = $addsid;
	}

	public function getAddsid()
	{
		return $this->addsid;
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
		
	public function setLive($live)
	{
		$this->live = $live;
	}

	public function getLive()
	{
		return $this->live;
	}

	public function getAll()
	{
		$ret = array(
		'co_name'=>$this->getCo_name(),
		'fname'=>$this->getFname(),
		'sname'=>$this->getSname(),
		'contact'=>$this->getContact(),
		'addsid'=>$this->getAddsid(),
		'inv_email'=>$this->getInv_email(),
		'inv_contact'=>$this->getInv_contact(),
		'colour'=>$this->getColour(),
		'live'=>$this->getLive());
		return $ret;
	}

	public function loadSupp() {
		global $db;
		if(!isset($this->suppid)){
			return "No Supp ID";
		}		
		$res = $db->select('SELECT suppid,co_name,fname,sname,contact,addsid,inv_email,inv_contact,colour,live FROM supp WHERE suppid=?', array($this->suppid), 'd');
		$r=$res[0];
		$this->setSuppid($r->suppid);
		$this->setCo_name($r->co_name);
		$this->setFname($r->fname);
		$this->setSname($r->sname);
		$this->setContact($r->contact);
		$this->setAddsid($r->addsid);
		$this->setInv_email($r->inv_email);
		$this->setInv_contact($r->inv_contact);
		$this->setColour($r->colour);
		$this->setLive($r->live);

	}


	public function updateDB() {
		global $db;
		global $suppFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'suppid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $suppFormats[$key];
			}
		}
		$res = $db->update('supp', $data, $format, array('suppid'=>$this->suppid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $suppFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $suppFormats[$key];
			}
		}
		$res = $db->insert('supp', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->suppid)){
			return "No Supp ID";
		}
		$res = $db->delete('supp', $this->suppid, 'suppid');
		return $res;
    }
}
?>