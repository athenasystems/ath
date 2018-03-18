<?php

 $qitemsFormats= array(
"qitemsid" => "i",
"quotesid" => "i",
"itemno" => "i",
"agreed" => "i",
"content" => "s",
"price" => "d",
"quantity" => "i",
"datereq" => "i",
"hours" => "i",
"rate" => "i");


class Qitems
{
private $qitemsid;
private $quotesid;
private $itemno;
private $agreed;
private $content;
private $price;
private $quantity;
private $datereq;
private $hours;
private $rate;
		
	public function setQitemsid($qitemsid)
	{
		$this->qitemsid = $qitemsid;
	}

	public function getQitemsid()
	{
		return $this->qitemsid;
	}
		
	public function setQuotesid($quotesid)
	{
		$this->quotesid = $quotesid;
	}

	public function getQuotesid()
	{
		return $this->quotesid;
	}
		
	public function setItemno($itemno)
	{
		$this->itemno = $itemno;
	}

	public function getItemno()
	{
		return $this->itemno;
	}
		
	public function setAgreed($agreed)
	{
		$this->agreed = $agreed;
	}

	public function getAgreed()
	{
		return $this->agreed;
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
		
	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
	}

	public function getQuantity()
	{
		return $this->quantity;
	}
		
	public function setDatereq($datereq)
	{
		$this->datereq = $datereq;
	}

	public function getDatereq()
	{
		return $this->datereq;
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
		'quotesid'=>$this->getQuotesid(),
		'itemno'=>$this->getItemno(),
		'agreed'=>$this->getAgreed(),
		'content'=>$this->getContent(),
		'price'=>$this->getPrice(),
		'quantity'=>$this->getQuantity(),
		'datereq'=>$this->getDatereq(),
		'hours'=>$this->getHours(),
		'rate'=>$this->getRate());
		return $ret;
	}

	public function loadQitems() {
		global $db;
		if(!isset($this->qitemsid)){
			return "No Qitems ID";
		}		
		$res = $db->select('SELECT qitemsid,quotesid,itemno,agreed,content,price,quantity,datereq,hours,rate FROM qitems WHERE qitemsid=?', array($this->qitemsid), 'd');
		$r=$res[0];
		$this->setQitemsid($r->qitemsid);
		$this->setQuotesid($r->quotesid);
		$this->setItemno($r->itemno);
		$this->setAgreed($r->agreed);
		$this->setContent($r->content);
		$this->setPrice($r->price);
		$this->setQuantity($r->quantity);
		$this->setDatereq($r->datereq);
		$this->setHours($r->hours);
		$this->setRate($r->rate);

	}


	public function updateDB() {
		global $db;
		global $qitemsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'qitemsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $qitemsFormats[$key];
			}
		}
		$res = $db->update('qitems', $data, $format, array('qitemsid'=>$this->qitemsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $qitemsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $qitemsFormats[$key];
			}
		}
		$res = $db->insert('qitems', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->qitemsid)){
			return "No Qitems ID";
		}
		$res = $db->delete('qitems', $this->qitemsid, 'qitemsid');
		return $res;
    }
}
?>