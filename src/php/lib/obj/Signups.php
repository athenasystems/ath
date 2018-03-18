<?php

 $signupsFormats= array(
"signupsid" => "i",
"incept" => "i",
"fname" => "s",
"sname" => "s",
"co_name" => "s",
"email" => "s",
"tel" => "s",
"status" => "s",
"brand" => "i");


class Signups
{
private $signupsid;
private $incept;
private $fname;
private $sname;
private $co_name;
private $email;
private $tel;
private $status;
private $brand;
		
	public function setSignupsid($signupsid)
	{
		$this->signupsid = $signupsid;
	}

	public function getSignupsid()
	{
		return $this->signupsid;
	}
		
	public function setIncept($incept)
	{
		$this->incept = $incept;
	}

	public function getIncept()
	{
		return $this->incept;
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
		
	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getEmail()
	{
		return $this->email;
	}
		
	public function setTel($tel)
	{
		$this->tel = $tel;
	}

	public function getTel()
	{
		return $this->tel;
	}
		
	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function getStatus()
	{
		return $this->status;
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
		'incept'=>$this->getIncept(),
		'fname'=>$this->getFname(),
		'sname'=>$this->getSname(),
		'co_name'=>$this->getCo_name(),
		'email'=>$this->getEmail(),
		'tel'=>$this->getTel(),
		'status'=>$this->getStatus(),
		'brand'=>$this->getBrand());
		return $ret;
	}

	public function loadSignups() {
		global $db;
		if(!isset($this->signupsid)){
			return "No Signups ID";
		}		
		$res = $db->select('SELECT signupsid,incept,fname,sname,co_name,email,tel,status,brand FROM signups WHERE signupsid=?', array($this->signupsid), 'd');
		$r=$res[0];
		$this->setSignupsid($r->signupsid);
		$this->setIncept($r->incept);
		$this->setFname($r->fname);
		$this->setSname($r->sname);
		$this->setCo_name($r->co_name);
		$this->setEmail($r->email);
		$this->setTel($r->tel);
		$this->setStatus($r->status);
		$this->setBrand($r->brand);

	}


	public function updateDB() {
		global $db;
		global $signupsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'signupsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $signupsFormats[$key];
			}
		}
		$res = $db->update('signups', $data, $format, array('signupsid'=>$this->signupsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $signupsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $signupsFormats[$key];
			}
		}
		$res = $db->insert('signups', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->signupsid)){
			return "No Signups ID";
		}
		$res = $db->delete('signups', $this->signupsid, 'signupsid');
		return $res;
    }
}
?>