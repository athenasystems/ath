<?php

 $quotesFormats= array(
"quotesid" => "i",
"staffid" => "i",
"custid" => "i",
"contactsid" => "i",
"quoteno" => "s",
"incept" => "i",
"origin" => "s",
"agree" => "i",
"live" => "i",
"content" => "s",
"notes" => "s",
"sent" => "i");


class Quotes
{
private $quotesid;
private $staffid;
private $custid;
private $contactsid;
private $quoteno;
private $incept;
private $origin;
private $agree;
private $live;
private $content;
private $notes;
private $sent;
		
	public function setQuotesid($quotesid)
	{
		$this->quotesid = $quotesid;
	}

	public function getQuotesid()
	{
		return $this->quotesid;
	}
		
	public function setStaffid($staffid)
	{
		$this->staffid = $staffid;
	}

	public function getStaffid()
	{
		return $this->staffid;
	}
		
	public function setCustid($custid)
	{
		$this->custid = $custid;
	}

	public function getCustid()
	{
		return $this->custid;
	}
		
	public function setContactsid($contactsid)
	{
		$this->contactsid = $contactsid;
	}

	public function getContactsid()
	{
		return $this->contactsid;
	}
		
	public function setQuoteno($quoteno)
	{
		$this->quoteno = $quoteno;
	}

	public function getQuoteno()
	{
		return $this->quoteno;
	}
		
	public function setIncept($incept)
	{
		$this->incept = $incept;
	}

	public function getIncept()
	{
		return $this->incept;
	}
		
	public function setOrigin($origin)
	{
		$this->origin = $origin;
	}

	public function getOrigin()
	{
		return $this->origin;
	}
		
	public function setAgree($agree)
	{
		$this->agree = $agree;
	}

	public function getAgree()
	{
		return $this->agree;
	}
		
	public function setLive($live)
	{
		$this->live = $live;
	}

	public function getLive()
	{
		return $this->live;
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
		'staffid'=>$this->getStaffid(),
		'custid'=>$this->getCustid(),
		'contactsid'=>$this->getContactsid(),
		'quoteno'=>$this->getQuoteno(),
		'incept'=>$this->getIncept(),
		'origin'=>$this->getOrigin(),
		'agree'=>$this->getAgree(),
		'live'=>$this->getLive(),
		'content'=>$this->getContent(),
		'notes'=>$this->getNotes(),
		'sent'=>$this->getSent());
		return $ret;
	}

	public function loadQuotes() {
		global $db;
		if(!isset($this->quotesid)){
			return "No Quotes ID";
		}		
		$res = $db->select('SELECT quotesid,staffid,custid,contactsid,quoteno,incept,origin,agree,live,content,notes,sent FROM quotes WHERE quotesid=?', array($this->quotesid), 'd');
		$r=$res[0];
		$this->setQuotesid($r->quotesid);
		$this->setStaffid($r->staffid);
		$this->setCustid($r->custid);
		$this->setContactsid($r->contactsid);
		$this->setQuoteno($r->quoteno);
		$this->setIncept($r->incept);
		$this->setOrigin($r->origin);
		$this->setAgree($r->agree);
		$this->setLive($r->live);
		$this->setContent($r->content);
		$this->setNotes($r->notes);
		$this->setSent($r->sent);

	}


	public function updateDB() {
		global $db;
		global $quotesFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'quotesid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $quotesFormats[$key];
			}
		}
		$res = $db->update('quotes', $data, $format, array('quotesid'=>$this->quotesid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $quotesFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $quotesFormats[$key];
			}
		}
		$res = $db->insert('quotes', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->quotesid)){
			return "No Quotes ID";
		}
		$res = $db->delete('quotes', $this->quotesid, 'quotesid');
		return $res;
    }
}
?>