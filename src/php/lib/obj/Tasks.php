<?php

 $tasksFormats= array(
"tasksid" => "i",
"custid" => "i",
"jobsid" => "i",
"notes" => "s",
"incept" => "i",
"staffid" => "i",
"hours" => "d",
"rate" => "i",
"invoicesid" => "i",
"contactsid" => "i");


class Tasks
{
private $tasksid;
private $custid;
private $jobsid;
private $notes;
private $incept;
private $staffid;
private $hours;
private $rate;
private $invoicesid;
private $contactsid;
		
	public function setTasksid($tasksid)
	{
		$this->tasksid = $tasksid;
	}

	public function getTasksid()
	{
		return $this->tasksid;
	}
		
	public function setCustid($custid)
	{
		$this->custid = $custid;
	}

	public function getCustid()
	{
		return $this->custid;
	}
		
	public function setJobsid($jobsid)
	{
		$this->jobsid = $jobsid;
	}

	public function getJobsid()
	{
		return $this->jobsid;
	}
		
	public function setNotes($notes)
	{
		$this->notes = $notes;
	}

	public function getNotes()
	{
		return $this->notes;
	}
		
	public function setIncept($incept)
	{
		$this->incept = $incept;
	}

	public function getIncept()
	{
		return $this->incept;
	}
		
	public function setStaffid($staffid)
	{
		$this->staffid = $staffid;
	}

	public function getStaffid()
	{
		return $this->staffid;
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
		
	public function setInvoicesid($invoicesid)
	{
		$this->invoicesid = $invoicesid;
	}

	public function getInvoicesid()
	{
		return $this->invoicesid;
	}
		
	public function setContactsid($contactsid)
	{
		$this->contactsid = $contactsid;
	}

	public function getContactsid()
	{
		return $this->contactsid;
	}

	public function getAll()
	{
		$ret = array(
		'custid'=>$this->getCustid(),
		'jobsid'=>$this->getJobsid(),
		'notes'=>$this->getNotes(),
		'incept'=>$this->getIncept(),
		'staffid'=>$this->getStaffid(),
		'hours'=>$this->getHours(),
		'rate'=>$this->getRate(),
		'invoicesid'=>$this->getInvoicesid(),
		'contactsid'=>$this->getContactsid());
		return $ret;
	}

	public function loadTasks() {
		global $db;
		if(!isset($this->tasksid)){
			return "No Tasks ID";
		}		
		$res = $db->select('SELECT tasksid,custid,jobsid,notes,incept,staffid,hours,rate,invoicesid,contactsid FROM tasks WHERE tasksid=?', array($this->tasksid), 'd');
		$r=$res[0];
		$this->setTasksid($r->tasksid);
		$this->setCustid($r->custid);
		$this->setJobsid($r->jobsid);
		$this->setNotes($r->notes);
		$this->setIncept($r->incept);
		$this->setStaffid($r->staffid);
		$this->setHours($r->hours);
		$this->setRate($r->rate);
		$this->setInvoicesid($r->invoicesid);
		$this->setContactsid($r->contactsid);

	}


	public function updateDB() {
		global $db;
		global $tasksFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'tasksid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $tasksFormats[$key];
			}
		}
		$res = $db->update('tasks', $data, $format, array('tasksid'=>$this->tasksid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $tasksFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $tasksFormats[$key];
			}
		}
		$res = $db->insert('tasks', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->tasksid)){
			return "No Tasks ID";
		}
		$res = $db->delete('tasks', $this->tasksid, 'tasksid');
		return $res;
    }
}
?>