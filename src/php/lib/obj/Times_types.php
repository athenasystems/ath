<?php

 $times_typesFormats= array(
"times_typesid" => "i",
"sitesid" => "i",
"name" => "s");


class Times_types
{
private $times_typesid;
private $sitesid;
private $name;
		
	public function setTimes_typesid($times_typesid)
	{
		$this->times_typesid = $times_typesid;
	}

	public function getTimes_typesid()
	{
		return $this->times_typesid;
	}
		
	public function setSitesid($sitesid)
	{
		$this->sitesid = $sitesid;
	}

	public function getSitesid()
	{
		return $this->sitesid;
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
		'sitesid'=>$this->getSitesid(),
		'name'=>$this->getName());
		return $ret;
	}

	public function loadTimes_types() {
		global $db;
		if(!isset($this->times_typesid)){
			return "No Times_types ID";
		}		
		$res = $db->select('SELECT times_typesid,sitesid,name FROM times_types WHERE times_typesid=?', array($this->times_typesid), 'd');
		$r=$res[0];
		$this->setTimes_typesid($r->times_typesid);
		$this->setSitesid($r->sitesid);
		$this->setName($r->name);

	}


	public function updateDB() {
		global $db;
		global $times_typesFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'times_typesid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $times_typesFormats[$key];
			}
		}
		$res = $db->update('times_types', $data, $format, array('times_typesid'=>$this->times_typesid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $times_typesFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $times_typesFormats[$key];
			}
		}
		$res = $db->insert('times_types', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->times_typesid)){
			return "No Times_types ID";
		}
		$res = $db->delete('times_types', $this->times_typesid, 'times_typesid');
		return $res;
    }
}
?>