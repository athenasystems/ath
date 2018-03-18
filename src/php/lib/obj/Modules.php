<?php

 $modulesFormats= array(
"modulesid" => "i",
"name" => "s",
"section" => "s",
"price" => "d",
"display" => "i",
"base" => "i",
"url" => "s",
"ordernum" => "i",
"level" => "i",
"description" => "s");


class Modules
{
private $modulesid;
private $name;
private $section;
private $price;
private $display;
private $base;
private $url;
private $ordernum;
private $level;
private $description;
		
	public function setModulesid($modulesid)
	{
		$this->modulesid = $modulesid;
	}

	public function getModulesid()
	{
		return $this->modulesid;
	}
		
	public function setName($name)
	{
		$this->name = $name;
	}

	public function getName()
	{
		return $this->name;
	}
		
	public function setSection($section)
	{
		$this->section = $section;
	}

	public function getSection()
	{
		return $this->section;
	}
		
	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function getPrice()
	{
		return $this->price;
	}
		
	public function setDisplay($display)
	{
		$this->display = $display;
	}

	public function getDisplay()
	{
		return $this->display;
	}
		
	public function setBase($base)
	{
		$this->base = $base;
	}

	public function getBase()
	{
		return $this->base;
	}
		
	public function setUrl($url)
	{
		$this->url = $url;
	}

	public function getUrl()
	{
		return $this->url;
	}
		
	public function setOrdernum($ordernum)
	{
		$this->ordernum = $ordernum;
	}

	public function getOrdernum()
	{
		return $this->ordernum;
	}
		
	public function setLevel($level)
	{
		$this->level = $level;
	}

	public function getLevel()
	{
		return $this->level;
	}
		
	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function getAll()
	{
		$ret = array(
		'name'=>$this->getName(),
		'section'=>$this->getSection(),
		'price'=>$this->getPrice(),
		'display'=>$this->getDisplay(),
		'base'=>$this->getBase(),
		'url'=>$this->getUrl(),
		'ordernum'=>$this->getOrdernum(),
		'level'=>$this->getLevel(),
		'description'=>$this->getDescription());
		return $ret;
	}

	public function loadModules() {
		global $db;
		if(!isset($this->modulesid)){
			return "No Modules ID";
		}		
		$res = $db->select('SELECT modulesid,name,section,price,display,base,url,ordernum,level,description FROM modules WHERE modulesid=?', array($this->modulesid), 'd');
		$r=$res[0];
		$this->setModulesid($r->modulesid);
		$this->setName($r->name);
		$this->setSection($r->section);
		$this->setPrice($r->price);
		$this->setDisplay($r->display);
		$this->setBase($r->base);
		$this->setUrl($r->url);
		$this->setOrdernum($r->ordernum);
		$this->setLevel($r->level);
		$this->setDescription($r->description);

	}


	public function updateDB() {
		global $db;
		global $modulesFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'modulesid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $modulesFormats[$key];
			}
		}
		$res = $db->update('modules', $data, $format, array('modulesid'=>$this->modulesid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $modulesFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $modulesFormats[$key];
			}
		}
		$res = $db->insert('modules', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->modulesid)){
			return "No Modules ID";
		}
		$res = $db->delete('modules', $this->modulesid, 'modulesid');
		return $res;
    }
}
?>