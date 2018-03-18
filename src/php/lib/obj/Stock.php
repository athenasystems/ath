<?php

 $stockFormats= array(
"stockid" => "i",
"sku" => "s",
"name" => "s",
"description" => "s",
"stockq" => "i",
"price" => "d",
"copytitle" => "s",
"copybody" => "s",
"copyfeatures" => "s",
"copyterms" => "s",
"copyimage" => "s");


class Stock
{
private $stockid;
private $sku;
private $name;
private $description;
private $stockq;
private $price;
private $copytitle;
private $copybody;
private $copyfeatures;
private $copyterms;
private $copyimage;
		
	public function setStockid($stockid)
	{
		$this->stockid = $stockid;
	}

	public function getStockid()
	{
		return $this->stockid;
	}
		
	public function setSku($sku)
	{
		$this->sku = $sku;
	}

	public function getSku()
	{
		return $this->sku;
	}
		
	public function setName($name)
	{
		$this->name = $name;
	}

	public function getName()
	{
		return $this->name;
	}
		
	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function getDescription()
	{
		return $this->description;
	}
		
	public function setStockq($stockq)
	{
		$this->stockq = $stockq;
	}

	public function getStockq()
	{
		return $this->stockq;
	}
		
	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function getPrice()
	{
		return $this->price;
	}
		
	public function setCopytitle($copytitle)
	{
		$this->copytitle = $copytitle;
	}

	public function getCopytitle()
	{
		return $this->copytitle;
	}
		
	public function setCopybody($copybody)
	{
		$this->copybody = $copybody;
	}

	public function getCopybody()
	{
		return $this->copybody;
	}
		
	public function setCopyfeatures($copyfeatures)
	{
		$this->copyfeatures = $copyfeatures;
	}

	public function getCopyfeatures()
	{
		return $this->copyfeatures;
	}
		
	public function setCopyterms($copyterms)
	{
		$this->copyterms = $copyterms;
	}

	public function getCopyterms()
	{
		return $this->copyterms;
	}
		
	public function setCopyimage($copyimage)
	{
		$this->copyimage = $copyimage;
	}

	public function getCopyimage()
	{
		return $this->copyimage;
	}

	public function getAll()
	{
		$ret = array(
		'sku'=>$this->getSku(),
		'name'=>$this->getName(),
		'description'=>$this->getDescription(),
		'stockq'=>$this->getStockq(),
		'price'=>$this->getPrice(),
		'copytitle'=>$this->getCopytitle(),
		'copybody'=>$this->getCopybody(),
		'copyfeatures'=>$this->getCopyfeatures(),
		'copyterms'=>$this->getCopyterms(),
		'copyimage'=>$this->getCopyimage());
		return $ret;
	}

	public function loadStock() {
		global $db;
		if(!isset($this->stockid)){
			return "No Stock ID";
		}		
		$res = $db->select('SELECT stockid,sku,name,description,stockq,price,copytitle,copybody,copyfeatures,copyterms,copyimage FROM stock WHERE stockid=?', array($this->stockid), 'd');
		$r=$res[0];
		$this->setStockid($r->stockid);
		$this->setSku($r->sku);
		$this->setName($r->name);
		$this->setDescription($r->description);
		$this->setStockq($r->stockq);
		$this->setPrice($r->price);
		$this->setCopytitle($r->copytitle);
		$this->setCopybody($r->copybody);
		$this->setCopyfeatures($r->copyfeatures);
		$this->setCopyterms($r->copyterms);
		$this->setCopyimage($r->copyimage);

	}


	public function updateDB() {
		global $db;
		global $stockFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'stockid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $stockFormats[$key];
			}
		}
		$res = $db->update('stock', $data, $format, array('stockid'=>$this->stockid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $stockFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $stockFormats[$key];
			}
		}
		$res = $db->insert('stock', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->stockid)){
			return "No Stock ID";
		}
		$res = $db->delete('stock', $this->stockid, 'stockid');
		return $res;
    }
}
?>