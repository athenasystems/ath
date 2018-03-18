<?php

 $rfqFormats= array(
"rfqid" => "i",
"content" => "s",
"quantity" => "i",
"fname" => "s",
"sname" => "s",
"email" => "s",
"tel" => "s",
"co_name" => "s",
"incept" => "i");


class Rfq
{
private $rfqid;
private $content;
private $quantity;
private $fname;
private $sname;
private $email;
private $tel;
private $co_name;
private $incept;
		
	public function setRfqid($rfqid)
	{
		$this->rfqid = $rfqid;
	}

	public function getRfqid()
	{
		return $this->rfqid;
	}
		
	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}
		
	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
	}

	public function getQuantity()
	{
		return $this->quantity;
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
		
	public function setCo_name($co_name)
	{
		$this->co_name = $co_name;
	}

	public function getCo_name()
	{
		return $this->co_name;
	}
		
	public function setIncept($incept)
	{
		$this->incept = $incept;
	}

	public function getIncept()
	{
		return $this->incept;
	}

	public function getAll()
	{
		$ret = array(
		'content'=>$this->getContent(),
		'quantity'=>$this->getQuantity(),
		'fname'=>$this->getFname(),
		'sname'=>$this->getSname(),
		'email'=>$this->getEmail(),
		'tel'=>$this->getTel(),
		'co_name'=>$this->getCo_name(),
		'incept'=>$this->getIncept());
		return $ret;
	}

	public function loadRfq() {
		global $db;
		if(!isset($this->rfqid)){
			return "No Rfq ID";
		}		
		$res = $db->select('SELECT rfqid,content,quantity,fname,sname,email,tel,co_name,incept FROM rfq WHERE rfqid=?', array($this->rfqid), 'd');
		$r=$res[0];
		$this->setRfqid($r->rfqid);
		$this->setContent($r->content);
		$this->setQuantity($r->quantity);
		$this->setFname($r->fname);
		$this->setSname($r->sname);
		$this->setEmail($r->email);
		$this->setTel($r->tel);
		$this->setCo_name($r->co_name);
		$this->setIncept($r->incept);

	}


	public function updateDB() {
		global $db;
		global $rfqFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'rfqid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $rfqFormats[$key];
			}
		}
		$res = $db->update('rfq', $data, $format, array('rfqid'=>$this->rfqid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $rfqFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $rfqFormats[$key];
			}
		}
		$res = $db->insert('rfq', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->rfqid)){
			return "No Rfq ID";
		}
		$res = $db->delete('rfq', $this->rfqid, 'rfqid');
		return $res;
    }
}
?>