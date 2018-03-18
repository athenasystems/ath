<?php

 $costsFormats= array(
"costsid" => "i",
"expsid" => "i",
"description" => "s",
"price" => "d",
"incept" => "i",
"supplier" => "s");


class Costs
{
private $costsid;
private $expsid;
private $description;
private $price;
private $incept;
private $supplier;
		
	public function setCostsid($costsid)
	{
		$this->costsid = $costsid;
	}

	public function getCostsid()
	{
		return $this->costsid;
	}
		
	public function setExpsid($expsid)
	{
		$this->expsid = $expsid;
	}

	public function getExpsid()
	{
		return $this->expsid;
	}
		
	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function getDescription()
	{
		return $this->description;
	}
		
	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function getPrice()
	{
		return $this->price;
	}
		
	public function setIncept($incept)
	{
		$this->incept = $incept;
	}

	public function getIncept()
	{
		return $this->incept;
	}
		
	public function setSupplier($supplier)
	{
		$this->supplier = $supplier;
	}

	public function getSupplier()
	{
		return $this->supplier;
	}

	public function getAll()
	{
		$ret = array(
		'expsid'=>$this->getExpsid(),
		'description'=>$this->getDescription(),
		'price'=>$this->getPrice(),
		'incept'=>$this->getIncept(),
		'supplier'=>$this->getSupplier());
		return $ret;
	}

	public function loadCosts() {
		global $db;
		if(!isset($this->costsid)){
			return "No Costs ID";
		}		
		$res = $db->select('SELECT costsid,expsid,description,price,incept,supplier FROM costs WHERE costsid=?', array($this->costsid), 'd');
		$r=$res[0];
		$this->setCostsid($r->costsid);
		$this->setExpsid($r->expsid);
		$this->setDescription($r->description);
		$this->setPrice($r->price);
		$this->setIncept($r->incept);
		$this->setSupplier($r->supplier);

	}


	public function updateDB() {
		global $db;
		global $costsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'costsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $costsFormats[$key];
			}
		}
		$res = $db->update('costs', $data, $format, array('costsid'=>$this->costsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $costsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $costsFormats[$key];
			}
		}
		$res = $db->insert('costs', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->costsid)){
			return "No Costs ID";
		}
		$res = $db->delete('costs', $this->costsid, 'costsid');
		return $res;
    }
}
?>