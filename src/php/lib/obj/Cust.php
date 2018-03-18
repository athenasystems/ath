<?php

 $custFormats= array(
"custid" => "i",
"fname" => "s",
"sname" => "s",
"co_name" => "s",
"contact" => "s",
"addsid" => "i",
"inv_email" => "s",
"inv_contact" => "i",
"colour" => "s",
"filestr" => "s",
"live" => "i");


class Cust
{
private $custid;
private $fname;
private $sname;
private $co_name;
private $contact;
private $addsid;
private $inv_email;
private $inv_contact;
private $colour;
private $filestr;
private $live;
		
	public function setCustid($custid)
	{
		$this->custid = $custid;
	}

	public function getCustid()
	{
		return $this->custid;
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
		
	public function setFilestr($filestr)
	{
		$this->filestr = $filestr;
	}

	public function getFilestr()
	{
		return $this->filestr;
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
		'fname'=>$this->getFname(),
		'sname'=>$this->getSname(),
		'co_name'=>$this->getCo_name(),
		'contact'=>$this->getContact(),
		'addsid'=>$this->getAddsid(),
		'inv_email'=>$this->getInv_email(),
		'inv_contact'=>$this->getInv_contact(),
		'colour'=>$this->getColour(),
		'filestr'=>$this->getFilestr(),
		'live'=>$this->getLive());
		return $ret;
	}

	public function loadCust() {
		global $db;
		if(!isset($this->custid)){
			return "No Cust ID";
		}		
		$res = $db->select('SELECT custid,fname,sname,co_name,contact,addsid,inv_email,inv_contact,colour,filestr,live FROM cust WHERE custid=?', array($this->custid), 'd');
		$r=$res[0];
		$this->setCustid($r->custid);
		$this->setFname($r->fname);
		$this->setSname($r->sname);
		$this->setCo_name($r->co_name);
		$this->setContact($r->contact);
		$this->setAddsid($r->addsid);
		$this->setInv_email($r->inv_email);
		$this->setInv_contact($r->inv_contact);
		$this->setColour($r->colour);
		$this->setFilestr($r->filestr);
		$this->setLive($r->live);

	}


	public function updateDB() {
		global $db;
		global $custFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'custid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $custFormats[$key];
			}
		}
		$res = $db->update('cust', $data, $format, array('custid'=>$this->custid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $custFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $custFormats[$key];
			}
		}
		$res = $db->insert('cust', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->custid)){
			return "No Cust ID";
		}
		$res = $db->delete('cust', $this->custid, 'custid');
		return $res;
    }
}
?>