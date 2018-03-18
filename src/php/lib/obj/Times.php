<?php

 $timesFormats= array(
"timesid" => "i",
"staffid" => "i",
"incept" => "i",
"start" => "i",
"finish" => "i",
"notes" => "s",
"day" => "i",
"times_typesid" => "i",
"lstart" => "i",
"lfinish" => "i");


class Times
{
private $timesid;
private $staffid;
private $incept;
private $start;
private $finish;
private $notes;
private $day;
private $times_typesid;
private $lstart;
private $lfinish;
		
	public function setTimesid($timesid)
	{
		$this->timesid = $timesid;
	}

	public function getTimesid()
	{
		return $this->timesid;
	}
		
	public function setStaffid($staffid)
	{
		$this->staffid = $staffid;
	}

	public function getStaffid()
	{
		return $this->staffid;
	}
		
	public function setIncept($incept)
	{
		$this->incept = $incept;
	}

	public function getIncept()
	{
		return $this->incept;
	}
		
	public function setStart($start)
	{
		$this->start = $start;
	}

	public function getStart()
	{
		return $this->start;
	}
		
	public function setFinish($finish)
	{
		$this->finish = $finish;
	}

	public function getFinish()
	{
		return $this->finish;
	}
		
	public function setNotes($notes)
	{
		$this->notes = $notes;
	}

	public function getNotes()
	{
		return $this->notes;
	}
		
	public function setDay($day)
	{
		$this->day = $day;
	}

	public function getDay()
	{
		return $this->day;
	}
		
	public function setTimes_typesid($times_typesid)
	{
		$this->times_typesid = $times_typesid;
	}

	public function getTimes_typesid()
	{
		return $this->times_typesid;
	}
		
	public function setLstart($lstart)
	{
		$this->lstart = $lstart;
	}

	public function getLstart()
	{
		return $this->lstart;
	}
		
	public function setLfinish($lfinish)
	{
		$this->lfinish = $lfinish;
	}

	public function getLfinish()
	{
		return $this->lfinish;
	}

	public function getAll()
	{
		$ret = array(
		'staffid'=>$this->getStaffid(),
		'incept'=>$this->getIncept(),
		'start'=>$this->getStart(),
		'finish'=>$this->getFinish(),
		'notes'=>$this->getNotes(),
		'day'=>$this->getDay(),
		'times_typesid'=>$this->getTimes_typesid(),
		'lstart'=>$this->getLstart(),
		'lfinish'=>$this->getLfinish());
		return $ret;
	}

	public function loadTimes() {
		global $db;
		if(!isset($this->timesid)){
			return "No Times ID";
		}		
		$res = $db->select('SELECT timesid,staffid,incept,start,finish,notes,day,times_typesid,lstart,lfinish FROM times WHERE timesid=?', array($this->timesid), 'd');
		$r=$res[0];
		$this->setTimesid($r->timesid);
		$this->setStaffid($r->staffid);
		$this->setIncept($r->incept);
		$this->setStart($r->start);
		$this->setFinish($r->finish);
		$this->setNotes($r->notes);
		$this->setDay($r->day);
		$this->setTimes_typesid($r->times_typesid);
		$this->setLstart($r->lstart);
		$this->setLfinish($r->lfinish);

	}


	public function updateDB() {
		global $db;
		global $timesFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'timesid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $timesFormats[$key];
			}
		}
		$res = $db->update('times', $data, $format, array('timesid'=>$this->timesid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $timesFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $timesFormats[$key];
			}
		}
		$res = $db->insert('times', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->timesid)){
			return "No Times ID";
		}
		$res = $db->delete('times', $this->timesid, 'timesid');
		return $res;
    }
}
?>