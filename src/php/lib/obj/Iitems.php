<?php

 $iitemsFormats= array(
"iitemsid" => "i",
"invoicesid" => "i",
"quantity" => "i",
"jobsid" => "i",
"content" => "s",
"price" => "d",
"hours" => "i",
"rate" => "d");


class Iitems
{
private $iitemsid;
private $invoicesid;
private $quantity;
private $jobsid;
private $content;
private $price;
private $hours;
private $rate;
		
	public function setIitemsid($iitemsid)
	{
		$this->iitemsid = $iitemsid;
	}

	public function getIitemsid()
	{
		return $this->iitemsid;
	}
		
	public function setInvoicesid($invoicesid)
	{
		$this->invoicesid = $invoicesid;
	}

	public function getInvoicesid()
	{
		return $this->invoicesid;
	}
		
	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
	}

	public function getQuantity()
	{
		return $this->quantity;
	}
		
	public function setJobsid($jobsid)
	{
		$this->jobsid = $jobsid;
	}

	public function getJobsid()
	{
		return $this->jobsid;
	}
		
	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}
		
	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function getPrice()
	{
		return $this->price;
	}
		
	public function setHours($hours)
	{
		$this->hours = $hours;
	}

	public function getHours()
	{
		return $this->hours;
	}
		
	public function setRate($rate)
	{
		$this->rate = $rate;
	}

	public function getRate()
	{
		return $this->rate;
	}

	public function getAll()
	{
		$ret = array(
		'invoicesid'=>$this->getInvoicesid(),
		'quantity'=>$this->getQuantity(),
		'jobsid'=>$this->getJobsid(),
		'content'=>$this->getContent(),
		'price'=>$this->getPrice(),
		'hours'=>$this->getHours(),
		'rate'=>$this->getRate());
		return $ret;
	}

	public function loadIitems() {
		global $db;
		if(!isset($this->iitemsid)){
			return "No Iitems ID";
		}		
		$res = $db->select('SELECT iitemsid,invoicesid,quantity,jobsid,content,price,hours,rate FROM iitems WHERE iitemsid=?', array($this->iitemsid), 'd');
		$r=$res[0];
		$this->setIitemsid($r->iitemsid);
		$this->setInvoicesid($r->invoicesid);
		$this->setQuantity($r->quantity);
		$this->setJobsid($r->jobsid);
		$this->setContent($r->content);
		$this->setPrice($r->price);
		$this->setHours($r->hours);
		$this->setRate($r->rate);

	}


	public function updateDB() {
		global $db;
		global $iitemsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'iitemsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $iitemsFormats[$key];
			}
		}
		$res = $db->update('iitems', $data, $format, array('iitemsid'=>$this->iitemsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $iitemsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $iitemsFormats[$key];
			}
		}
		$res = $db->insert('iitems', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->iitemsid)){
			return "No Iitems ID";
		}
		$res = $db->delete('iitems', $this->iitemsid, 'iitemsid');
		return $res;
    }
}
?>