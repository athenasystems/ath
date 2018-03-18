<?php
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
		global $dbsys;
		if(!isset($this->eventsid)){
			return "No Events ID";
		}		
		$res = $dbsys->select('SELECT eventsid,name FROM events WHERE eventsid=?', array($this->eventsid), 'd');
		$r=$res[0];
		$this->setEventsid($r->eventsid);
		$this->setName($r->name);

	}


	public function updateDB() {
		global $dbsys;
		global $eventsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'eventsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $eventsFormats[$key];
			}
		}
		$res = $dbsys->update('events', $data, $format, array('eventsid'=>$this->eventsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsys;
		global $eventsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $eventsFormats[$key];
			}
		}
		$res = $dbsys->insert('events', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsys;
		        
		if(!isset($this->eventsid)){
			return "No Events ID";
		}
		$res = $dbsys->delete('events', $this->eventsid, 'eventsid');
		return $res;
    }
}
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
		global $dbsys;
		if(!isset($this->expsid)){
			return "No Exps ID";
		}		
		$res = $dbsys->select('SELECT expsid,name,periodical FROM exps WHERE expsid=?', array($this->expsid), 'd');
		$r=$res[0];
		$this->setExpsid($r->expsid);
		$this->setName($r->name);
		$this->setPeriodical($r->periodical);

	}


	public function updateDB() {
		global $dbsys;
		global $expsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'expsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $expsFormats[$key];
			}
		}
		$res = $dbsys->update('exps', $data, $format, array('expsid'=>$this->expsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsys;
		global $expsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $expsFormats[$key];
			}
		}
		$res = $dbsys->insert('exps', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsys;
		        
		if(!isset($this->expsid)){
			return "No Exps ID";
		}
		$res = $dbsys->delete('exps', $this->expsid, 'expsid');
		return $res;
    }
}
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
		global $dbsys;
		if(!isset($this->modsid)){
			return "No Mods ID";
		}		
		$res = $dbsys->select('SELECT modsid,sitesid,modulesid FROM mods WHERE modsid=?', array($this->modsid), 'd');
		$r=$res[0];
		$this->setModsid($r->modsid);
		$this->setSitesid($r->sitesid);
		$this->setModulesid($r->modulesid);

	}


	public function updateDB() {
		global $dbsys;
		global $modsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'modsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $modsFormats[$key];
			}
		}
		$res = $dbsys->update('mods', $data, $format, array('modsid'=>$this->modsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsys;
		global $modsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $modsFormats[$key];
			}
		}
		$res = $dbsys->insert('mods', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsys;
		        
		if(!isset($this->modsid)){
			return "No Mods ID";
		}
		$res = $dbsys->delete('mods', $this->modsid, 'modsid');
		return $res;
    }
}
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
		global $dbsys;
		if(!isset($this->modulesid)){
			return "No Modules ID";
		}		
		$res = $dbsys->select('SELECT modulesid,name,section,price,display,base,url,ordernum,level,description FROM modules WHERE modulesid=?', array($this->modulesid), 'd');
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
		global $dbsys;
		global $modulesFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'modulesid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $modulesFormats[$key];
			}
		}
		$res = $dbsys->update('modules', $data, $format, array('modulesid'=>$this->modulesid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsys;
		global $modulesFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $modulesFormats[$key];
			}
		}
		$res = $dbsys->insert('modules', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsys;
		        
		if(!isset($this->modulesid)){
			return "No Modules ID";
		}
		$res = $dbsys->delete('modules', $this->modulesid, 'modulesid');
		return $res;
    }
}
class Products
{
private $productsid;
private $name;
private $price;
private $setup;
private $discount;
private $option;
		
	public function setProductsid($productsid)
	{
		$this->productsid = $productsid;
	}

	public function getProductsid()
	{
		return $this->productsid;
	}
		
	public function setName($name)
	{
		$this->name = $name;
	}

	public function getName()
	{
		return $this->name;
	}
		
	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function getPrice()
	{
		return $this->price;
	}
		
	public function setSetup($setup)
	{
		$this->setup = $setup;
	}

	public function getSetup()
	{
		return $this->setup;
	}
		
	public function setDiscount($discount)
	{
		$this->discount = $discount;
	}

	public function getDiscount()
	{
		return $this->discount;
	}
		
	public function setOption($option)
	{
		$this->option = $option;
	}

	public function getOption()
	{
		return $this->option;
	}

	public function getAll()
	{
		$ret = array(
		'name'=>$this->getName(),
		'price'=>$this->getPrice(),
		'setup'=>$this->getSetup(),
		'discount'=>$this->getDiscount(),
		'option'=>$this->getOption());
		return $ret;
	}

	public function loadProducts() {
		global $dbsys;
		if(!isset($this->productsid)){
			return "No Products ID";
		}		
		$res = $dbsys->select('SELECT productsid,name,price,setup,discount,option FROM products WHERE productsid=?', array($this->productsid), 'd');
		$r=$res[0];
		$this->setProductsid($r->productsid);
		$this->setName($r->name);
		$this->setPrice($r->price);
		$this->setSetup($r->setup);
		$this->setDiscount($r->discount);
		$this->setOption($r->option);

	}


	public function updateDB() {
		global $dbsys;
		global $productsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'productsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $productsFormats[$key];
			}
		}
		$res = $dbsys->update('products', $data, $format, array('productsid'=>$this->productsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsys;
		global $productsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $productsFormats[$key];
			}
		}
		$res = $dbsys->insert('products', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsys;
		        
		if(!isset($this->productsid)){
			return "No Products ID";
		}
		$res = $dbsys->delete('products', $this->productsid, 'productsid');
		return $res;
    }
}
class Sales
{
private $salesid;
private $sitesid;
private $productsid;
private $incept;
		
	public function setSalesid($salesid)
	{
		$this->salesid = $salesid;
	}

	public function getSalesid()
	{
		return $this->salesid;
	}
		
	public function setSitesid($sitesid)
	{
		$this->sitesid = $sitesid;
	}

	public function getSitesid()
	{
		return $this->sitesid;
	}
		
	public function setProductsid($productsid)
	{
		$this->productsid = $productsid;
	}

	public function getProductsid()
	{
		return $this->productsid;
	}
		
	public function setIncept($incept)
	{
		$this->incept = $incept;
	}

	public function getIncept()
	{
		return $this->incept;
	}

	public function getAll()
	{
		$ret = array(
		'sitesid'=>$this->getSitesid(),
		'productsid'=>$this->getProductsid(),
		'incept'=>$this->getIncept());
		return $ret;
	}

	public function loadSales() {
		global $dbsys;
		if(!isset($this->salesid)){
			return "No Sales ID";
		}		
		$res = $dbsys->select('SELECT salesid,sitesid,productsid,incept FROM sales WHERE salesid=?', array($this->salesid), 'd');
		$r=$res[0];
		$this->setSalesid($r->salesid);
		$this->setSitesid($r->sitesid);
		$this->setProductsid($r->productsid);
		$this->setIncept($r->incept);

	}


	public function updateDB() {
		global $dbsys;
		global $salesFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'salesid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $salesFormats[$key];
			}
		}
		$res = $dbsys->update('sales', $data, $format, array('salesid'=>$this->salesid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsys;
		global $salesFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $salesFormats[$key];
			}
		}
		$res = $dbsys->insert('sales', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsys;
		        
		if(!isset($this->salesid)){
			return "No Sales ID";
		}
		$res = $dbsys->delete('sales', $this->salesid, 'salesid');
		return $res;
    }
}
class Signups
{
private $signupsid;
private $incept;
private $fname;
private $sname;
private $co_name;
private $email;
private $tel;
private $status;
private $brand;
		
	public function setSignupsid($signupsid)
	{
		$this->signupsid = $signupsid;
	}

	public function getSignupsid()
	{
		return $this->signupsid;
	}
		
	public function setIncept($incept)
	{
		$this->incept = $incept;
	}

	public function getIncept()
	{
		return $this->incept;
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
		
	public function setCo_name($co_name)
	{
		$this->co_name = $co_name;
	}

	public function getCo_name()
	{
		return $this->co_name;
	}
		
	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getEmail()
	{
		return $this->email;
	}
		
	public function setTel($tel)
	{
		$this->tel = $tel;
	}

	public function getTel()
	{
		return $this->tel;
	}
		
	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function getStatus()
	{
		return $this->status;
	}
		
	public function setBrand($brand)
	{
		$this->brand = $brand;
	}

	public function getBrand()
	{
		return $this->brand;
	}

	public function getAll()
	{
		$ret = array(
		'incept'=>$this->getIncept(),
		'fname'=>$this->getFname(),
		'sname'=>$this->getSname(),
		'co_name'=>$this->getCo_name(),
		'email'=>$this->getEmail(),
		'tel'=>$this->getTel(),
		'status'=>$this->getStatus(),
		'brand'=>$this->getBrand());
		return $ret;
	}

	public function loadSignups() {
		global $dbsys;
		if(!isset($this->signupsid)){
			return "No Signups ID";
		}		
		$res = $dbsys->select('SELECT signupsid,incept,fname,sname,co_name,email,tel,status,brand FROM signups WHERE signupsid=?', array($this->signupsid), 'd');
		$r=$res[0];
		$this->setSignupsid($r->signupsid);
		$this->setIncept($r->incept);
		$this->setFname($r->fname);
		$this->setSname($r->sname);
		$this->setCo_name($r->co_name);
		$this->setEmail($r->email);
		$this->setTel($r->tel);
		$this->setStatus($r->status);
		$this->setBrand($r->brand);

	}


	public function updateDB() {
		global $dbsys;
		global $signupsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'signupsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $signupsFormats[$key];
			}
		}
		$res = $dbsys->update('signups', $data, $format, array('signupsid'=>$this->signupsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsys;
		global $signupsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $signupsFormats[$key];
			}
		}
		$res = $dbsys->insert('signups', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsys;
		        
		if(!isset($this->signupsid)){
			return "No Signups ID";
		}
		$res = $dbsys->delete('signups', $this->signupsid, 'signupsid');
		return $res;
    }
}
class Sites
{
private $sitesid;
private $co_name;
private $co_nick;
private $addsid;
private $email;
private $inv_email;
private $inv_contact;
private $colour;
private $status;
private $pid;
private $vat_no;
private $co_no;
private $gmailpw;
private $gmail;
private $incept;
private $subdom;
private $domain;
private $filestr;
private $eoymonth;
private $eoyday;
private $brand;
		
	public function setSitesid($sitesid)
	{
		$this->sitesid = $sitesid;
	}

	public function getSitesid()
	{
		return $this->sitesid;
	}
		
	public function setCo_name($co_name)
	{
		$this->co_name = $co_name;
	}

	public function getCo_name()
	{
		return $this->co_name;
	}
		
	public function setCo_nick($co_nick)
	{
		$this->co_nick = $co_nick;
	}

	public function getCo_nick()
	{
		return $this->co_nick;
	}
		
	public function setAddsid($addsid)
	{
		$this->addsid = $addsid;
	}

	public function getAddsid()
	{
		return $this->addsid;
	}
		
	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getEmail()
	{
		return $this->email;
	}
		
	public function setInv_email($inv_email)
	{
		$this->inv_email = $inv_email;
	}

	public function getInv_email()
	{
		return $this->inv_email;
	}
		
	public function setInv_contact($inv_contact)
	{
		$this->inv_contact = $inv_contact;
	}

	public function getInv_contact()
	{
		return $this->inv_contact;
	}
		
	public function setColour($colour)
	{
		$this->colour = $colour;
	}

	public function getColour()
	{
		return $this->colour;
	}
		
	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function getStatus()
	{
		return $this->status;
	}
		
	public function setPid($pid)
	{
		$this->pid = $pid;
	}

	public function getPid()
	{
		return $this->pid;
	}
		
	public function setVat_no($vat_no)
	{
		$this->vat_no = $vat_no;
	}

	public function getVat_no()
	{
		return $this->vat_no;
	}
		
	public function setCo_no($co_no)
	{
		$this->co_no = $co_no;
	}

	public function getCo_no()
	{
		return $this->co_no;
	}
		
	public function setGmailpw($gmailpw)
	{
		$this->gmailpw = $gmailpw;
	}

	public function getGmailpw()
	{
		return $this->gmailpw;
	}
		
	public function setGmail($gmail)
	{
		$this->gmail = $gmail;
	}

	public function getGmail()
	{
		return $this->gmail;
	}
		
	public function setIncept($incept)
	{
		$this->incept = $incept;
	}

	public function getIncept()
	{
		return $this->incept;
	}
		
	public function setSubdom($subdom)
	{
		$this->subdom = $subdom;
	}

	public function getSubdom()
	{
		return $this->subdom;
	}
		
	public function setDomain($domain)
	{
		$this->domain = $domain;
	}

	public function getDomain()
	{
		return $this->domain;
	}
		
	public function setFilestr($filestr)
	{
		$this->filestr = $filestr;
	}

	public function getFilestr()
	{
		return $this->filestr;
	}
		
	public function setEoymonth($eoymonth)
	{
		$this->eoymonth = $eoymonth;
	}

	public function getEoymonth()
	{
		return $this->eoymonth;
	}
		
	public function setEoyday($eoyday)
	{
		$this->eoyday = $eoyday;
	}

	public function getEoyday()
	{
		return $this->eoyday;
	}
		
	public function setBrand($brand)
	{
		$this->brand = $brand;
	}

	public function getBrand()
	{
		return $this->brand;
	}

	public function getAll()
	{
		$ret = array(
		'co_name'=>$this->getCo_name(),
		'co_nick'=>$this->getCo_nick(),
		'addsid'=>$this->getAddsid(),
		'email'=>$this->getEmail(),
		'inv_email'=>$this->getInv_email(),
		'inv_contact'=>$this->getInv_contact(),
		'colour'=>$this->getColour(),
		'status'=>$this->getStatus(),
		'pid'=>$this->getPid(),
		'vat_no'=>$this->getVat_no(),
		'co_no'=>$this->getCo_no(),
		'gmailpw'=>$this->getGmailpw(),
		'gmail'=>$this->getGmail(),
		'incept'=>$this->getIncept(),
		'subdom'=>$this->getSubdom(),
		'domain'=>$this->getDomain(),
		'filestr'=>$this->getFilestr(),
		'eoymonth'=>$this->getEoymonth(),
		'eoyday'=>$this->getEoyday(),
		'brand'=>$this->getBrand());
		return $ret;
	}

	public function loadSites() {
		global $dbsys;
		if(!isset($this->sitesid)){
			return "No Sites ID";
		}		
		$res = $dbsys->select('SELECT sitesid,co_name,co_nick,addsid,email,inv_email,inv_contact,colour,status,pid,vat_no,co_no,gmailpw,gmail,incept,subdom,domain,filestr,eoymonth,eoyday,brand FROM sites WHERE sitesid=?', array($this->sitesid), 'd');
		$r=$res[0];
		$this->setSitesid($r->sitesid);
		$this->setCo_name($r->co_name);
		$this->setCo_nick($r->co_nick);
		$this->setAddsid($r->addsid);
		$this->setEmail($r->email);
		$this->setInv_email($r->inv_email);
		$this->setInv_contact($r->inv_contact);
		$this->setColour($r->colour);
		$this->setStatus($r->status);
		$this->setPid($r->pid);
		$this->setVat_no($r->vat_no);
		$this->setCo_no($r->co_no);
		$this->setGmailpw($r->gmailpw);
		$this->setGmail($r->gmail);
		$this->setIncept($r->incept);
		$this->setSubdom($r->subdom);
		$this->setDomain($r->domain);
		$this->setFilestr($r->filestr);
		$this->setEoymonth($r->eoymonth);
		$this->setEoyday($r->eoyday);
		$this->setBrand($r->brand);

	}


	public function updateDB() {
		global $dbsys;
		global $sitesFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'sitesid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $sitesFormats[$key];
			}
		}
		$res = $dbsys->update('sites', $data, $format, array('sitesid'=>$this->sitesid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsys;
		global $sitesFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $sitesFormats[$key];
			}
		}
		$res = $dbsys->insert('sites', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsys;
		        
		if(!isset($this->sitesid)){
			return "No Sites ID";
		}
		$res = $dbsys->delete('sites', $this->sitesid, 'sitesid');
		return $res;
    }
}
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
		global $dbsys;
		if(!isset($this->times_typesid)){
			return "No Times_types ID";
		}		
		$res = $dbsys->select('SELECT times_typesid,sitesid,name FROM times_types WHERE times_typesid=?', array($this->times_typesid), 'd');
		$r=$res[0];
		$this->setTimes_typesid($r->times_typesid);
		$this->setSitesid($r->sitesid);
		$this->setName($r->name);

	}


	public function updateDB() {
		global $dbsys;
		global $times_typesFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'times_typesid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $times_typesFormats[$key];
			}
		}
		$res = $dbsys->update('times_types', $data, $format, array('times_typesid'=>$this->times_typesid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsys;
		global $times_typesFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $times_typesFormats[$key];
			}
		}
		$res = $dbsys->insert('times_types', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsys;
		        
		if(!isset($this->times_typesid)){
			return "No Times_types ID";
		}
		$res = $dbsys->delete('times_types', $this->times_typesid, 'times_typesid');
		return $res;
    }
}


 $eventsFormats= array(
"eventsid" => "i",
"name" => "s");


 $expsFormats= array(
"expsid" => "i",
"name" => "s",
"periodical" => "i");


 $modsFormats= array(
"modsid" => "i",
"sitesid" => "i",
"modulesid" => "i");


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


 $productsFormats= array(
"productsid" => "i",
"name" => "s",
"price" => "d",
"setup" => "d",
"discount" => "d",
"option" => "i");


 $salesFormats= array(
"salesid" => "i",
"sitesid" => "i",
"productsid" => "i",
"incept" => "i");


 $signupsFormats= array(
"signupsid" => "i",
"incept" => "i",
"fname" => "s",
"sname" => "s",
"co_name" => "s",
"email" => "s",
"tel" => "s",
"status" => "s",
"brand" => "i");


 $sitesFormats= array(
"sitesid" => "i",
"co_name" => "s",
"co_nick" => "s",
"addsid" => "i",
"email" => "s",
"inv_email" => "s",
"inv_contact" => "i",
"colour" => "s",
"status" => "s",
"pid" => "i",
"vat_no" => "s",
"co_no" => "s",
"gmailpw" => "s",
"gmail" => "s",
"incept" => "i",
"subdom" => "s",
"domain" => "s",
"filestr" => "s",
"eoymonth" => "i",
"eoyday" => "i",
"brand" => "i");


 $times_typesFormats= array(
"times_typesid" => "i",
"sitesid" => "i",
"name" => "s");



?>