<?php

 $sitelogFormats= array(
"sitelogid" => "i",
"incept" => "i",
"staffid" => "i",
"contactsid" => "i",
"level" => "i",
"content" => "s",
"eventsid" => "i");


class Sitelog
{
private $sitelogid;
private $incept;
private $staffid;
private $contactsid;
private $level;
private $content;
private $eventsid;
		
	public function setSitelogid($sitelogid)
	{
		$this->sitelogid = $sitelogid;
	}

	public function getSitelogid()
	{
		return $this->sitelogid;
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
		
	public function setContactsid($contactsid)
	{
		$this->contactsid = $contactsid;
	}

	public function getContactsid()
	{
		return $this->contactsid;
	}
		
	public function setLevel($level)
	{
		$this->level = $level;
	}

	public function getLevel()
	{
		return $this->level;
	}
		
	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}
		
	public function setEventsid($eventsid)
	{
		$this->eventsid = $eventsid;
	}

	public function getEventsid()
	{
		return $this->eventsid;
	}

	public function getAll()
	{
		$ret = array(
		'incept'=>$this->getIncept(),
		'staffid'=>$this->getStaffid(),
		'contactsid'=>$this->getContactsid(),
		'level'=>$this->getLevel(),
		'content'=>$this->getContent(),
		'eventsid'=>$this->getEventsid());
		return $ret;
	}

	public function loadSitelog() {
		global $db;
		if(!isset($this->sitelogid)){
			return "No Sitelog ID";
		}		
		$res = $db->select('SELECT sitelogid,incept,staffid,contactsid,level,content,eventsid FROM sitelog WHERE sitelogid=?', array($this->sitelogid), 'd');
		$r=$res[0];
		$this->setSitelogid($r->sitelogid);
		$this->setIncept($r->incept);
		$this->setStaffid($r->staffid);
		$this->setContactsid($r->contactsid);
		$this->setLevel($r->level);
		$this->setContent($r->content);
		$this->setEventsid($r->eventsid);

	}


	public function updateDB() {
		global $db;
		global $sitelogFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'sitelogid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $sitelogFormats[$key];
			}
		}
		$res = $db->update('sitelog', $data, $format, array('sitelogid'=>$this->sitelogid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $sitelogFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $sitelogFormats[$key];
			}
		}
		$res = $db->insert('sitelog', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->sitelogid)){
			return "No Sitelog ID";
		}
		$res = $db->delete('sitelog', $this->sitelogid, 'sitelogid');
		return $res;
    }
}
?>