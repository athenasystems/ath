<?php

 $eventsFormats= array(
"eventsid" => "i",
"name" => "s");


class Events
{
private $eventsid;
private $name;
		
	public function setEventsid($eventsid)
	{
		$this->eventsid = $eventsid;
	}

	public function getEventsid()
	{
		return $this->eventsid;
	}
		
	public function setName($name)
	{
		$this->name = $name;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getAll()
	{
		$ret = array(
		'name'=>$this->getName());
		return $ret;
	}

	public function loadEvents() {
		global $db;
		if(!isset($this->eventsid)){
			return "No Events ID";
		}		
		$res = $db->select('SELECT eventsid,name FROM events WHERE eventsid=?', array($this->eventsid), 'd');
		$r=$res[0];
		$this->setEventsid($r->eventsid);
		$this->setName($r->name);

	}


	public function updateDB() {
		global $db;
		global $eventsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'eventsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $eventsFormats[$key];
			}
		}
		$res = $db->update('events', $data, $format, array('eventsid'=>$this->eventsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $eventsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $eventsFormats[$key];
			}
		}
		$res = $db->insert('events', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->eventsid)){
			return "No Events ID";
		}
		$res = $db->delete('events', $this->eventsid, 'eventsid');
		return $res;
    }
}
?>