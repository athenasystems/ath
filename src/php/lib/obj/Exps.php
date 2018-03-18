<?php

 $expsFormats= array(
"expsid" => "i",
"name" => "s",
"periodical" => "i");


class Exps
{
private $expsid;
private $name;
private $periodical;
		
	public function setExpsid($expsid)
	{
		$this->expsid = $expsid;
	}

	public function getExpsid()
	{
		return $this->expsid;
	}
		
	public function setName($name)
	{
		$this->name = $name;
	}

	public function getName()
	{
		return $this->name;
	}
		
	public function setPeriodical($periodical)
	{
		$this->periodical = $periodical;
	}

	public function getPeriodical()
	{
		return $this->periodical;
	}

	public function getAll()
	{
		$ret = array(
		'name'=>$this->getName(),
		'periodical'=>$this->getPeriodical());
		return $ret;
	}

	public function loadExps() {
		global $db;
		if(!isset($this->expsid)){
			return "No Exps ID";
		}		
		$res = $db->select('SELECT expsid,name,periodical FROM exps WHERE expsid=?', array($this->expsid), 'd');
		$r=$res[0];
		$this->setExpsid($r->expsid);
		$this->setName($r->name);
		$this->setPeriodical($r->periodical);

	}


	public function updateDB() {
		global $db;
		global $expsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'expsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $expsFormats[$key];
			}
		}
		$res = $db->update('exps', $data, $format, array('expsid'=>$this->expsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $expsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $expsFormats[$key];
			}
		}
		$res = $db->insert('exps', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->expsid)){
			return "No Exps ID";
		}
		$res = $db->delete('exps', $this->expsid, 'expsid');
		return $res;
    }
}
?>