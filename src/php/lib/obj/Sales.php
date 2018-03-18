<?php

 $salesFormats= array(
"salesid" => "i",
"sitesid" => "i",
"productsid" => "i",
"incept" => "i");


class Sales
{
private $salesid;
private $sitesid;
private $productsid;
private $incept;
		
	public function setSalesid($salesid)
	{
		$this->salesid = $salesid;
	}

	public function getSalesid()
	{
		return $this->salesid;
	}
		
	public function setSitesid($sitesid)
	{
		$this->sitesid = $sitesid;
	}

	public function getSitesid()
	{
		return $this->sitesid;
	}
		
	public function setProductsid($productsid)
	{
		$this->productsid = $productsid;
	}

	public function getProductsid()
	{
		return $this->productsid;
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
		'sitesid'=>$this->getSitesid(),
		'productsid'=>$this->getProductsid(),
		'incept'=>$this->getIncept());
		return $ret;
	}

	public function loadSales() {
		global $db;
		if(!isset($this->salesid)){
			return "No Sales ID";
		}		
		$res = $db->select('SELECT salesid,sitesid,productsid,incept FROM sales WHERE salesid=?', array($this->salesid), 'd');
		$r=$res[0];
		$this->setSalesid($r->salesid);
		$this->setSitesid($r->sitesid);
		$this->setProductsid($r->productsid);
		$this->setIncept($r->incept);

	}


	public function updateDB() {
		global $db;
		global $salesFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'salesid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $salesFormats[$key];
			}
		}
		$res = $db->update('sales', $data, $format, array('salesid'=>$this->salesid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $salesFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $salesFormats[$key];
			}
		}
		$res = $db->insert('sales', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->salesid)){
			return "No Sales ID";
		}
		$res = $db->delete('sales', $this->salesid, 'salesid');
		return $res;
    }
}
?>