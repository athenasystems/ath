<?php

 $webFormats= array(
"webid" => "i",
"text" => "s",
"place" => "s");


class Web
{
private $webid;
private $text;
private $place;
		
	public function setWebid($webid)
	{
		$this->webid = $webid;
	}

	public function getWebid()
	{
		return $this->webid;
	}
		
	public function setText($text)
	{
		$this->text = $text;
	}

	public function getText()
	{
		return $this->text;
	}
		
	public function setPlace($place)
	{
		$this->place = $place;
	}

	public function getPlace()
	{
		return $this->place;
	}

	public function getAll()
	{
		$ret = array(
		'text'=>$this->getText(),
		'place'=>$this->getPlace());
		return $ret;
	}

	public function loadWeb() {
		global $db;
		if(!isset($this->webid)){
			return "No Web ID";
		}		
		$res = $db->select('SELECT webid,text,place FROM web WHERE webid=?', array($this->webid), 'd');
		$r=$res[0];
		$this->setWebid($r->webid);
		$this->setText($r->text);
		$this->setPlace($r->place);

	}


	public function updateDB() {
		global $db;
		global $webFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'webid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $webFormats[$key];
			}
		}
		$res = $db->update('web', $data, $format, array('webid'=>$this->webid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $webFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $webFormats[$key];
			}
		}
		$res = $db->insert('web', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->webid)){
			return "No Web ID";
		}
		$res = $db->delete('web', $this->webid, 'webid');
		return $res;
    }
}
?>