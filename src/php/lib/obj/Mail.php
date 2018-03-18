<?php

 $mailFormats= array(
"mailid" => "i",
"addto" => "s",
"addname" => "s",
"subject" => "s",
"body" => "s",
"sent" => "i",
"incept" => "i",
"timesent" => "i",
"docname" => "s",
"doctitle" => "s",
"kind" => "s");


class Mail
{
private $mailid;
private $addto;
private $addname;
private $subject;
private $body;
private $sent;
private $incept;
private $timesent;
private $docname;
private $doctitle;
private $kind;
		
	public function setMailid($mailid)
	{
		$this->mailid = $mailid;
	}

	public function getMailid()
	{
		return $this->mailid;
	}
		
	public function setAddto($addto)
	{
		$this->addto = $addto;
	}

	public function getAddto()
	{
		return $this->addto;
	}
		
	public function setAddname($addname)
	{
		$this->addname = $addname;
	}

	public function getAddname()
	{
		return $this->addname;
	}
		
	public function setSubject($subject)
	{
		$this->subject = $subject;
	}

	public function getSubject()
	{
		return $this->subject;
	}
		
	public function setBody($body)
	{
		$this->body = $body;
	}

	public function getBody()
	{
		return $this->body;
	}
		
	public function setSent($sent)
	{
		$this->sent = $sent;
	}

	public function getSent()
	{
		return $this->sent;
	}
		
	public function setIncept($incept)
	{
		$this->incept = $incept;
	}

	public function getIncept()
	{
		return $this->incept;
	}
		
	public function setTimesent($timesent)
	{
		$this->timesent = $timesent;
	}

	public function getTimesent()
	{
		return $this->timesent;
	}
		
	public function setDocname($docname)
	{
		$this->docname = $docname;
	}

	public function getDocname()
	{
		return $this->docname;
	}
		
	public function setDoctitle($doctitle)
	{
		$this->doctitle = $doctitle;
	}

	public function getDoctitle()
	{
		return $this->doctitle;
	}
		
	public function setKind($kind)
	{
		$this->kind = $kind;
	}

	public function getKind()
	{
		return $this->kind;
	}

	public function getAll()
	{
		$ret = array(
		'addto'=>$this->getAddto(),
		'addname'=>$this->getAddname(),
		'subject'=>$this->getSubject(),
		'body'=>$this->getBody(),
		'sent'=>$this->getSent(),
		'incept'=>$this->getIncept(),
		'timesent'=>$this->getTimesent(),
		'docname'=>$this->getDocname(),
		'doctitle'=>$this->getDoctitle(),
		'kind'=>$this->getKind());
		return $ret;
	}

	public function loadMail() {
		global $db;
		if(!isset($this->mailid)){
			return "No Mail ID";
		}		
		$res = $db->select('SELECT mailid,addto,addname,subject,body,sent,incept,timesent,docname,doctitle,kind FROM mail WHERE mailid=?', array($this->mailid), 'd');
		$r=$res[0];
		$this->setMailid($r->mailid);
		$this->setAddto($r->addto);
		$this->setAddname($r->addname);
		$this->setSubject($r->subject);
		$this->setBody($r->body);
		$this->setSent($r->sent);
		$this->setIncept($r->incept);
		$this->setTimesent($r->timesent);
		$this->setDocname($r->docname);
		$this->setDoctitle($r->doctitle);
		$this->setKind($r->kind);

	}


	public function updateDB() {
		global $db;
		global $mailFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'mailid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $mailFormats[$key];
			}
		}
		$res = $db->update('mail', $data, $format, array('mailid'=>$this->mailid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $mailFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $mailFormats[$key];
			}
		}
		$res = $db->insert('mail', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->mailid)){
			return "No Mail ID";
		}
		$res = $db->delete('mail', $this->mailid, 'mailid');
		return $res;
    }
}
?>