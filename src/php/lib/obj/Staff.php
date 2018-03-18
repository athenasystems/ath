<?php

 $staffFormats= array(
"staffid" => "i",
"fname" => "s",
"sname" => "s",
"addsid" => "i",
"notes" => "s",
"jobtitle" => "s",
"content" => "s",
"status" => "s",
"level" => "i",
"teamsid" => "i",
"timesheet" => "i",
"holiday" => "i",
"theme" => "i");


class Staff
{
private $staffid;
private $fname;
private $sname;
private $addsid;
private $notes;
private $jobtitle;
private $content;
private $status;
private $level;
private $teamsid;
private $timesheet;
private $holiday;
private $theme;
		
	public function setStaffid($staffid)
	{
		$this->staffid = $staffid;
	}

	public function getStaffid()
	{
		return $this->staffid;
	}
		
	public function setFname($fname)
	{
		$this->fname = $fname;
	}

	public function getFname()
	{
		return $this->fname;
	}
		
	public function setSname($sname)
	{
		$this->sname = $sname;
	}

	public function getSname()
	{
		return $this->sname;
	}
		
	public function setAddsid($addsid)
	{
		$this->addsid = $addsid;
	}

	public function getAddsid()
	{
		return $this->addsid;
	}
		
	public function setNotes($notes)
	{
		$this->notes = $notes;
	}

	public function getNotes()
	{
		return $this->notes;
	}
		
	public function setJobtitle($jobtitle)
	{
		$this->jobtitle = $jobtitle;
	}

	public function getJobtitle()
	{
		return $this->jobtitle;
	}
		
	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}
		
	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function getStatus()
	{
		return $this->status;
	}
		
	public function setLevel($level)
	{
		$this->level = $level;
	}

	public function getLevel()
	{
		return $this->level;
	}
		
	public function setTeamsid($teamsid)
	{
		$this->teamsid = $teamsid;
	}

	public function getTeamsid()
	{
		return $this->teamsid;
	}
		
	public function setTimesheet($timesheet)
	{
		$this->timesheet = $timesheet;
	}

	public function getTimesheet()
	{
		return $this->timesheet;
	}
		
	public function setHoliday($holiday)
	{
		$this->holiday = $holiday;
	}

	public function getHoliday()
	{
		return $this->holiday;
	}
		
	public function setTheme($theme)
	{
		$this->theme = $theme;
	}

	public function getTheme()
	{
		return $this->theme;
	}

	public function getAll()
	{
		$ret = array(
		'fname'=>$this->getFname(),
		'sname'=>$this->getSname(),
		'addsid'=>$this->getAddsid(),
		'notes'=>$this->getNotes(),
		'jobtitle'=>$this->getJobtitle(),
		'content'=>$this->getContent(),
		'status'=>$this->getStatus(),
		'level'=>$this->getLevel(),
		'teamsid'=>$this->getTeamsid(),
		'timesheet'=>$this->getTimesheet(),
		'holiday'=>$this->getHoliday(),
		'theme'=>$this->getTheme());
		return $ret;
	}

	public function loadStaff() {
		global $db;
		if(!isset($this->staffid)){
			return "No Staff ID";
		}		
		$res = $db->select('SELECT staffid,fname,sname,addsid,notes,jobtitle,content,status,level,teamsid,timesheet,holiday,theme FROM staff WHERE staffid=?', array($this->staffid), 'd');
		$r=$res[0];
		$this->setStaffid($r->staffid);
		$this->setFname($r->fname);
		$this->setSname($r->sname);
		$this->setAddsid($r->addsid);
		$this->setNotes($r->notes);
		$this->setJobtitle($r->jobtitle);
		$this->setContent($r->content);
		$this->setStatus($r->status);
		$this->setLevel($r->level);
		$this->setTeamsid($r->teamsid);
		$this->setTimesheet($r->timesheet);
		$this->setHoliday($r->holiday);
		$this->setTheme($r->theme);

	}


	public function updateDB() {
		global $db;
		global $staffFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'staffid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $staffFormats[$key];
			}
		}
		$res = $db->update('staff', $data, $format, array('staffid'=>$this->staffid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $staffFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $staffFormats[$key];
			}
		}
		$res = $db->insert('staff', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->staffid)){
			return "No Staff ID";
		}
		$res = $db->delete('staff', $this->staffid, 'staffid');
		return $res;
    }
}
?>