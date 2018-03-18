<?php

 $modsFormats= array(
"modsid" => "i",
"sitesid" => "i",
"modulesid" => "i");


class Mods
{
private $modsid;
private $sitesid;
private $modulesid;
		
	public function setModsid($modsid)
	{
		$this->modsid = $modsid;
	}

	public function getModsid()
	{
		return $this->modsid;
	}
		
	public function setSitesid($sitesid)
	{
		$this->sitesid = $sitesid;
	}

	public function getSitesid()
	{
		return $this->sitesid;
	}
		
	public function setModulesid($modulesid)
	{
		$this->modulesid = $modulesid;
	}

	public function getModulesid()
	{
		return $this->modulesid;
	}

	public function getAll()
	{
		$ret = array(
		'sitesid'=>$this->getSitesid(),
		'modulesid'=>$this->getModulesid());
		return $ret;
	}

	public function loadMods() {
		global $db;
		if(!isset($this->modsid)){
			return "No Mods ID";
		}		
		$res = $db->select('SELECT modsid,sitesid,modulesid FROM mods WHERE modsid=?', array($this->modsid), 'd');
		$r=$res[0];
		$this->setModsid($r->modsid);
		$this->setSitesid($r->sitesid);
		$this->setModulesid($r->modulesid);

	}


	public function updateDB() {
		global $db;
		global $modsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'modsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $modsFormats[$key];
			}
		}
		$res = $db->update('mods', $data, $format, array('modsid'=>$this->modsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $modsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $modsFormats[$key];
			}
		}
		$res = $db->insert('mods', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->modsid)){
			return "No Mods ID";
		}
		$res = $db->delete('mods', $this->modsid, 'modsid');
		return $res;
    }
}
?>