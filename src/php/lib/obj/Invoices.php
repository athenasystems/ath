<?php

 $invoicesFormats= array(
"invoicesid" => "i",
"custid" => "i",
"invoiceno" => "s",
"incept" => "i",
"paid" => "i",
"content" => "s",
"notes" => "s",
"sent" => "i");


class Invoices
{
private $invoicesid;
private $custid;
private $invoiceno;
private $incept;
private $paid;
private $content;
private $notes;
private $sent;
		
	public function setInvoicesid($invoicesid)
	{
		$this->invoicesid = $invoicesid;
	}

	public function getInvoicesid()
	{
		return $this->invoicesid;
	}
		
	public function setCustid($custid)
	{
		$this->custid = $custid;
	}

	public function getCustid()
	{
		return $this->custid;
	}
		
	public function setInvoiceno($invoiceno)
	{
		$this->invoiceno = $invoiceno;
	}

	public function getInvoiceno()
	{
		return $this->invoiceno;
	}
		
	public function setIncept($incept)
	{
		$this->incept = $incept;
	}

	public function getIncept()
	{
		return $this->incept;
	}
		
	public function setPaid($paid)
	{
		$this->paid = $paid;
	}

	public function getPaid()
	{
		return $this->paid;
	}
		
	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}
		
	public function setNotes($notes)
	{
		$this->notes = $notes;
	}

	public function getNotes()
	{
		return $this->notes;
	}
		
	public function setSent($sent)
	{
		$this->sent = $sent;
	}

	public function getSent()
	{
		return $this->sent;
	}

	public function getAll()
	{
		$ret = array(
		'custid'=>$this->getCustid(),
		'invoiceno'=>$this->getInvoiceno(),
		'incept'=>$this->getIncept(),
		'paid'=>$this->getPaid(),
		'content'=>$this->getContent(),
		'notes'=>$this->getNotes(),
		'sent'=>$this->getSent());
		return $ret;
	}

	public function loadInvoices() {
		global $db;
		if(!isset($this->invoicesid)){
			return "No Invoices ID";
		}		
		$res = $db->select('SELECT invoicesid,custid,invoiceno,incept,paid,content,notes,sent FROM invoices WHERE invoicesid=?', array($this->invoicesid), 'd');
		$r=$res[0];
		$this->setInvoicesid($r->invoicesid);
		$this->setCustid($r->custid);
		$this->setInvoiceno($r->invoiceno);
		$this->setIncept($r->incept);
		$this->setPaid($r->paid);
		$this->setContent($r->content);
		$this->setNotes($r->notes);
		$this->setSent($r->sent);

	}


	public function updateDB() {
		global $db;
		global $invoicesFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'invoicesid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $invoicesFormats[$key];
			}
		}
		$res = $db->update('invoices', $data, $format, array('invoicesid'=>$this->invoicesid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $invoicesFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $invoicesFormats[$key];
			}
		}
		$res = $db->insert('invoices', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->invoicesid)){
			return "No Invoices ID";
		}
		$res = $db->delete('invoices', $this->invoicesid, 'invoicesid');
		return $res;
    }
}
?>