<?php

 $itemsFormats= array(
"itemsid" => "i",
"price" => "d",
"incept" => "i",
"currency" => "s",
"content" => "s",
"qitemsid" => "i");


class Items
{
private $itemsid;
private $price;
private $incept;
private $currency;
private $content;
private $qitemsid;
		
	public function setItemsid($itemsid)
	{
		$this->itemsid = $itemsid;
	}

	public function getItemsid()
	{
		return $this->itemsid;
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
		
	public function setCurrency($currency)
	{
		$this->currency = $currency;
	}

	public function getCurrency()
	{
		return $this->currency;
	}
		
	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}
		
	public function setQitemsid($qitemsid)
	{
		$this->qitemsid = $qitemsid;
	}

	public function getQitemsid()
	{
		return $this->qitemsid;
	}

	public function getAll()
	{
		$ret = array(
		'price'=>$this->getPrice(),
		'incept'=>$this->getIncept(),
		'currency'=>$this->getCurrency(),
		'content'=>$this->getContent(),
		'qitemsid'=>$this->getQitemsid());
		return $ret;
	}

	public function loadItems() {
		global $db;
		if(!isset($this->itemsid)){
			return "No Items ID";
		}		
		$res = $db->select('SELECT itemsid,price,incept,currency,content,qitemsid FROM items WHERE itemsid=?', array($this->itemsid), 'd');
		$r=$res[0];
		$this->setItemsid($r->itemsid);
		$this->setPrice($r->price);
		$this->setIncept($r->incept);
		$this->setCurrency($r->currency);
		$this->setContent($r->content);
		$this->setQitemsid($r->qitemsid);

	}


	public function updateDB() {
		global $db;
		global $itemsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'itemsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $itemsFormats[$key];
			}
		}
		$res = $db->update('items', $data, $format, array('itemsid'=>$this->itemsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $itemsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $itemsFormats[$key];
			}
		}
		$res = $db->insert('items', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->itemsid)){
			return "No Items ID";
		}
		$res = $db->delete('items', $this->itemsid, 'itemsid');
		return $res;
    }
}
?>