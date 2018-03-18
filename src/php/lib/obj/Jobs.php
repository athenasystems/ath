<?php

 $jobsFormats= array(
"jobsid" => "i",
"custid" => "i",
"itemsid" => "i",
"quantity" => "i",
"invoicesid" => "i",
"jobno" => "s",
"incept" => "i",
"done" => "i",
"notes" => "s",
"custref" => "s",
"datedel" => "i",
"datereq" => "i");


class Jobs
{
private $jobsid;
private $custid;
private $itemsid;
private $quantity;
private $invoicesid;
private $jobno;
private $incept;
private $done;
private $notes;
private $custref;
private $datedel;
private $datereq;
		
	public function setJobsid($jobsid)
	{
		$this->jobsid = $jobsid;
	}

	public function getJobsid()
	{
		return $this->jobsid;
	}
		
	public function setCustid($custid)
	{
		$this->custid = $custid;
	}

	public function getCustid()
	{
		return $this->custid;
	}
		
	public function setItemsid($itemsid)
	{
		$this->itemsid = $itemsid;
	}

	public function getItemsid()
	{
		return $this->itemsid;
	}
		
	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
	}

	public function getQuantity()
	{
		return $this->quantity;
	}
		
	public function setInvoicesid($invoicesid)
	{
		$this->invoicesid = $invoicesid;
	}

	public function getInvoicesid()
	{
		return $this->invoicesid;
	}
		
	public function setJobno($jobno)
	{
		$this->jobno = $jobno;
	}

	public function getJobno()
	{
		return $this->jobno;
	}
		
	public function setIncept($incept)
	{
		$this->incept = $incept;
	}

	public function getIncept()
	{
		return $this->incept;
	}
		
	public function setDone($done)
	{
		$this->done = $done;
	}

	public function getDone()
	{
		return $this->done;
	}
		
	public function setNotes($notes)
	{
		$this->notes = $notes;
	}

	public function getNotes()
	{
		return $this->notes;
	}
		
	public function setCustref($custref)
	{
		$this->custref = $custref;
	}

	public function getCustref()
	{
		return $this->custref;
	}
		
	public function setDatedel($datedel)
	{
		$this->datedel = $datedel;
	}

	public function getDatedel()
	{
		return $this->datedel;
	}
		
	public function setDatereq($datereq)
	{
		$this->datereq = $datereq;
	}

	public function getDatereq()
	{
		return $this->datereq;
	}

	public function getAll()
	{
		$ret = array(
		'custid'=>$this->getCustid(),
		'itemsid'=>$this->getItemsid(),
		'quantity'=>$this->getQuantity(),
		'invoicesid'=>$this->getInvoicesid(),
		'jobno'=>$this->getJobno(),
		'incept'=>$this->getIncept(),
		'done'=>$this->getDone(),
		'notes'=>$this->getNotes(),
		'custref'=>$this->getCustref(),
		'datedel'=>$this->getDatedel(),
		'datereq'=>$this->getDatereq());
		return $ret;
	}

	public function loadJobs() {
		global $db;
		if(!isset($this->jobsid)){
			return "No Jobs ID";
		}		
		$res = $db->select('SELECT jobsid,custid,itemsid,quantity,invoicesid,jobno,incept,done,notes,custref,datedel,datereq FROM jobs WHERE jobsid=?', array($this->jobsid), 'd');
		$r=$res[0];
		$this->setJobsid($r->jobsid);
		$this->setCustid($r->custid);
		$this->setItemsid($r->itemsid);
		$this->setQuantity($r->quantity);
		$this->setInvoicesid($r->invoicesid);
		$this->setJobno($r->jobno);
		$this->setIncept($r->incept);
		$this->setDone($r->done);
		$this->setNotes($r->notes);
		$this->setCustref($r->custref);
		$this->setDatedel($r->datedel);
		$this->setDatereq($r->datereq);

	}


	public function updateDB() {
		global $db;
		global $jobsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'jobsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $jobsFormats[$key];
			}
		}
		$res = $db->update('jobs', $data, $format, array('jobsid'=>$this->jobsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $jobsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $jobsFormats[$key];
			}
		}
		$res = $db->insert('jobs', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->jobsid)){
			return "No Jobs ID";
		}
		$res = $db->delete('jobs', $this->jobsid, 'jobsid');
		return $res;
    }
}
?>