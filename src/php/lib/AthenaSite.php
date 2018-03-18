<?php
class Adds
{
private $addsid;
private $add1;
private $add2;
private $add3;
private $city;
private $county;
private $country;
private $postcode;
private $tel;
private $mob;
private $fax;
private $email;
private $web;
private $facebook;
private $twitter;
private $linkedin;
		
	public function setAddsid($addsid)
	{
		$this->addsid = $addsid;
	}

	public function getAddsid()
	{
		return $this->addsid;
	}
		
	public function setAdd1($add1)
	{
		$this->add1 = $add1;
	}

	public function getAdd1()
	{
		return $this->add1;
	}
		
	public function setAdd2($add2)
	{
		$this->add2 = $add2;
	}

	public function getAdd2()
	{
		return $this->add2;
	}
		
	public function setAdd3($add3)
	{
		$this->add3 = $add3;
	}

	public function getAdd3()
	{
		return $this->add3;
	}
		
	public function setCity($city)
	{
		$this->city = $city;
	}

	public function getCity()
	{
		return $this->city;
	}
		
	public function setCounty($county)
	{
		$this->county = $county;
	}

	public function getCounty()
	{
		return $this->county;
	}
		
	public function setCountry($country)
	{
		$this->country = $country;
	}

	public function getCountry()
	{
		return $this->country;
	}
		
	public function setPostcode($postcode)
	{
		$this->postcode = $postcode;
	}

	public function getPostcode()
	{
		return $this->postcode;
	}
		
	public function setTel($tel)
	{
		$this->tel = $tel;
	}

	public function getTel()
	{
		return $this->tel;
	}
		
	public function setMob($mob)
	{
		$this->mob = $mob;
	}

	public function getMob()
	{
		return $this->mob;
	}
		
	public function setFax($fax)
	{
		$this->fax = $fax;
	}

	public function getFax()
	{
		return $this->fax;
	}
		
	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getEmail()
	{
		return $this->email;
	}
		
	public function setWeb($web)
	{
		$this->web = $web;
	}

	public function getWeb()
	{
		return $this->web;
	}
		
	public function setFacebook($facebook)
	{
		$this->facebook = $facebook;
	}

	public function getFacebook()
	{
		return $this->facebook;
	}
		
	public function setTwitter($twitter)
	{
		$this->twitter = $twitter;
	}

	public function getTwitter()
	{
		return $this->twitter;
	}
		
	public function setLinkedin($linkedin)
	{
		$this->linkedin = $linkedin;
	}

	public function getLinkedin()
	{
		return $this->linkedin;
	}

	public function getAll()
	{
		$ret = array(
		'add1'=>$this->getAdd1(),
		'add2'=>$this->getAdd2(),
		'add3'=>$this->getAdd3(),
		'city'=>$this->getCity(),
		'county'=>$this->getCounty(),
		'country'=>$this->getCountry(),
		'postcode'=>$this->getPostcode(),
		'tel'=>$this->getTel(),
		'mob'=>$this->getMob(),
		'fax'=>$this->getFax(),
		'email'=>$this->getEmail(),
		'web'=>$this->getWeb(),
		'facebook'=>$this->getFacebook(),
		'twitter'=>$this->getTwitter(),
		'linkedin'=>$this->getLinkedin());
		return $ret;
	}

	public function loadAdds() {
		global $dbsite;
		if(!isset($this->addsid)){
			return "No Adds ID";
		}		
		$res = $dbsite->select('SELECT addsid,add1,add2,add3,city,county,country,postcode,tel,mob,fax,email,web,facebook,twitter,linkedin FROM adds WHERE addsid=?', array($this->addsid), 'd');
		$r=$res[0];
		$this->setAddsid($r->addsid);
		$this->setAdd1($r->add1);
		$this->setAdd2($r->add2);
		$this->setAdd3($r->add3);
		$this->setCity($r->city);
		$this->setCounty($r->county);
		$this->setCountry($r->country);
		$this->setPostcode($r->postcode);
		$this->setTel($r->tel);
		$this->setMob($r->mob);
		$this->setFax($r->fax);
		$this->setEmail($r->email);
		$this->setWeb($r->web);
		$this->setFacebook($r->facebook);
		$this->setTwitter($r->twitter);
		$this->setLinkedin($r->linkedin);

	}


	public function updateDB() {
		global $dbsite;
		global $addsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'addsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $addsFormats[$key];
			}
		}
		$res = $dbsite->update('adds', $data, $format, array('addsid'=>$this->addsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsite;
		global $addsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $addsFormats[$key];
			}
		}
		$res = $dbsite->insert('adds', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsite;
		        
		if(!isset($this->addsid)){
			return "No Adds ID";
		}
		$res = $dbsite->delete('adds', $this->addsid, 'addsid');
		return $res;
    }
}
class Contacts
{
private $contactsid;
private $title;
private $fname;
private $sname;
private $co_name;
private $role;
private $custid;
private $suppid;
private $addsid;
private $notes;
		
	public function setContactsid($contactsid)
	{
		$this->contactsid = $contactsid;
	}

	public function getContactsid()
	{
		return $this->contactsid;
	}
		
	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function getTitle()
	{
		return $this->title;
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
		
	public function setRole($role)
	{
		$this->role = $role;
	}

	public function getRole()
	{
		return $this->role;
	}
		
	public function setCustid($custid)
	{
		$this->custid = $custid;
	}

	public function getCustid()
	{
		return $this->custid;
	}
		
	public function setSuppid($suppid)
	{
		$this->suppid = $suppid;
	}

	public function getSuppid()
	{
		return $this->suppid;
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

	public function getAll()
	{
		$ret = array(
		'title'=>$this->getTitle(),
		'fname'=>$this->getFname(),
		'sname'=>$this->getSname(),
		'co_name'=>$this->getCo_name(),
		'role'=>$this->getRole(),
		'custid'=>$this->getCustid(),
		'suppid'=>$this->getSuppid(),
		'addsid'=>$this->getAddsid(),
		'notes'=>$this->getNotes());
		return $ret;
	}

	public function loadContacts() {
		global $dbsite;
		if(!isset($this->contactsid)){
			return "No Contacts ID";
		}		
		$res = $dbsite->select('SELECT contactsid,title,fname,sname,co_name,role,custid,suppid,addsid,notes FROM contacts WHERE contactsid=?', array($this->contactsid), 'd');
		$r=$res[0];
		$this->setContactsid($r->contactsid);
		$this->setTitle($r->title);
		$this->setFname($r->fname);
		$this->setSname($r->sname);
		$this->setCo_name($r->co_name);
		$this->setRole($r->role);
		$this->setCustid($r->custid);
		$this->setSuppid($r->suppid);
		$this->setAddsid($r->addsid);
		$this->setNotes($r->notes);

	}


	public function updateDB() {
		global $dbsite;
		global $contactsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'contactsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $contactsFormats[$key];
			}
		}
		$res = $dbsite->update('contacts', $data, $format, array('contactsid'=>$this->contactsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsite;
		global $contactsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $contactsFormats[$key];
			}
		}
		$res = $dbsite->insert('contacts', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsite;
		        
		if(!isset($this->contactsid)){
			return "No Contacts ID";
		}
		$res = $dbsite->delete('contacts', $this->contactsid, 'contactsid');
		return $res;
    }
}
class Costs
{
private $costsid;
private $expsid;
private $description;
private $price;
private $incept;
private $supplier;
		
	public function setCostsid($costsid)
	{
		$this->costsid = $costsid;
	}

	public function getCostsid()
	{
		return $this->costsid;
	}
		
	public function setExpsid($expsid)
	{
		$this->expsid = $expsid;
	}

	public function getExpsid()
	{
		return $this->expsid;
	}
		
	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function getDescription()
	{
		return $this->description;
	}
		
	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function getPrice()
	{
		return $this->price;
	}
		
	public function setIncept($incept)
	{
		$this->incept = $incept;
	}

	public function getIncept()
	{
		return $this->incept;
	}
		
	public function setSupplier($supplier)
	{
		$this->supplier = $supplier;
	}

	public function getSupplier()
	{
		return $this->supplier;
	}

	public function getAll()
	{
		$ret = array(
		'expsid'=>$this->getExpsid(),
		'description'=>$this->getDescription(),
		'price'=>$this->getPrice(),
		'incept'=>$this->getIncept(),
		'supplier'=>$this->getSupplier());
		return $ret;
	}

	public function loadCosts() {
		global $dbsite;
		if(!isset($this->costsid)){
			return "No Costs ID";
		}		
		$res = $dbsite->select('SELECT costsid,expsid,description,price,incept,supplier FROM costs WHERE costsid=?', array($this->costsid), 'd');
		$r=$res[0];
		$this->setCostsid($r->costsid);
		$this->setExpsid($r->expsid);
		$this->setDescription($r->description);
		$this->setPrice($r->price);
		$this->setIncept($r->incept);
		$this->setSupplier($r->supplier);

	}


	public function updateDB() {
		global $dbsite;
		global $costsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'costsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $costsFormats[$key];
			}
		}
		$res = $dbsite->update('costs', $data, $format, array('costsid'=>$this->costsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsite;
		global $costsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $costsFormats[$key];
			}
		}
		$res = $dbsite->insert('costs', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsite;
		        
		if(!isset($this->costsid)){
			return "No Costs ID";
		}
		$res = $dbsite->delete('costs', $this->costsid, 'costsid');
		return $res;
    }
}
class Cust
{
private $custid;
private $fname;
private $sname;
private $co_name;
private $contact;
private $addsid;
private $inv_email;
private $inv_contact;
private $colour;
private $filestr;
private $live;
		
	public function setCustid($custid)
	{
		$this->custid = $custid;
	}

	public function getCustid()
	{
		return $this->custid;
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
		
	public function setContact($contact)
	{
		$this->contact = $contact;
	}

	public function getContact()
	{
		return $this->contact;
	}
		
	public function setAddsid($addsid)
	{
		$this->addsid = $addsid;
	}

	public function getAddsid()
	{
		return $this->addsid;
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
		
	public function setFilestr($filestr)
	{
		$this->filestr = $filestr;
	}

	public function getFilestr()
	{
		return $this->filestr;
	}
		
	public function setLive($live)
	{
		$this->live = $live;
	}

	public function getLive()
	{
		return $this->live;
	}

	public function getAll()
	{
		$ret = array(
		'fname'=>$this->getFname(),
		'sname'=>$this->getSname(),
		'co_name'=>$this->getCo_name(),
		'contact'=>$this->getContact(),
		'addsid'=>$this->getAddsid(),
		'inv_email'=>$this->getInv_email(),
		'inv_contact'=>$this->getInv_contact(),
		'colour'=>$this->getColour(),
		'filestr'=>$this->getFilestr(),
		'live'=>$this->getLive());
		return $ret;
	}

	public function loadCust() {
		global $dbsite;
		if(!isset($this->custid)){
			return "No Cust ID";
		}		
		$res = $dbsite->select('SELECT custid,fname,sname,co_name,contact,addsid,inv_email,inv_contact,colour,filestr,live FROM cust WHERE custid=?', array($this->custid), 'd');
		$r=$res[0];
		$this->setCustid($r->custid);
		$this->setFname($r->fname);
		$this->setSname($r->sname);
		$this->setCo_name($r->co_name);
		$this->setContact($r->contact);
		$this->setAddsid($r->addsid);
		$this->setInv_email($r->inv_email);
		$this->setInv_contact($r->inv_contact);
		$this->setColour($r->colour);
		$this->setFilestr($r->filestr);
		$this->setLive($r->live);

	}


	public function updateDB() {
		global $dbsite;
		global $custFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'custid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $custFormats[$key];
			}
		}
		$res = $dbsite->update('cust', $data, $format, array('custid'=>$this->custid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsite;
		global $custFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $custFormats[$key];
			}
		}
		$res = $dbsite->insert('cust', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsite;
		        
		if(!isset($this->custid)){
			return "No Cust ID";
		}
		$res = $dbsite->delete('cust', $this->custid, 'custid');
		return $res;
    }
}
class Diary
{
private $diaryid;
private $incept;
private $duration;
private $title;
private $content;
private $location;
private $staffid;
private $done;
private $every;
private $end;
private $origin;
		
	public function setDiaryid($diaryid)
	{
		$this->diaryid = $diaryid;
	}

	public function getDiaryid()
	{
		return $this->diaryid;
	}
		
	public function setIncept($incept)
	{
		$this->incept = $incept;
	}

	public function getIncept()
	{
		return $this->incept;
	}
		
	public function setDuration($duration)
	{
		$this->duration = $duration;
	}

	public function getDuration()
	{
		return $this->duration;
	}
		
	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function getTitle()
	{
		return $this->title;
	}
		
	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}
		
	public function setLocation($location)
	{
		$this->location = $location;
	}

	public function getLocation()
	{
		return $this->location;
	}
		
	public function setStaffid($staffid)
	{
		$this->staffid = $staffid;
	}

	public function getStaffid()
	{
		return $this->staffid;
	}
		
	public function setDone($done)
	{
		$this->done = $done;
	}

	public function getDone()
	{
		return $this->done;
	}
		
	public function setEvery($every)
	{
		$this->every = $every;
	}

	public function getEvery()
	{
		return $this->every;
	}
		
	public function setEnd($end)
	{
		$this->end = $end;
	}

	public function getEnd()
	{
		return $this->end;
	}
		
	public function setOrigin($origin)
	{
		$this->origin = $origin;
	}

	public function getOrigin()
	{
		return $this->origin;
	}

	public function getAll()
	{
		$ret = array(
		'incept'=>$this->getIncept(),
		'duration'=>$this->getDuration(),
		'title'=>$this->getTitle(),
		'content'=>$this->getContent(),
		'location'=>$this->getLocation(),
		'staffid'=>$this->getStaffid(),
		'done'=>$this->getDone(),
		'every'=>$this->getEvery(),
		'end'=>$this->getEnd(),
		'origin'=>$this->getOrigin());
		return $ret;
	}

	public function loadDiary() {
		global $dbsite;
		if(!isset($this->diaryid)){
			return "No Diary ID";
		}		
		$res = $dbsite->select('SELECT diaryid,incept,duration,title,content,location,staffid,done,every,end,origin FROM diary WHERE diaryid=?', array($this->diaryid), 'd');
		$r=$res[0];
		$this->setDiaryid($r->diaryid);
		$this->setIncept($r->incept);
		$this->setDuration($r->duration);
		$this->setTitle($r->title);
		$this->setContent($r->content);
		$this->setLocation($r->location);
		$this->setStaffid($r->staffid);
		$this->setDone($r->done);
		$this->setEvery($r->every);
		$this->setEnd($r->end);
		$this->setOrigin($r->origin);

	}


	public function updateDB() {
		global $dbsite;
		global $diaryFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'diaryid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $diaryFormats[$key];
			}
		}
		$res = $dbsite->update('diary', $data, $format, array('diaryid'=>$this->diaryid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsite;
		global $diaryFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $diaryFormats[$key];
			}
		}
		$res = $dbsite->insert('diary', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsite;
		        
		if(!isset($this->diaryid)){
			return "No Diary ID";
		}
		$res = $dbsite->delete('diary', $this->diaryid, 'diaryid');
		return $res;
    }
}
class Iitems
{
private $iitemsid;
private $invoicesid;
private $quantity;
private $jobsid;
private $content;
private $price;
private $hours;
private $rate;
		
	public function setIitemsid($iitemsid)
	{
		$this->iitemsid = $iitemsid;
	}

	public function getIitemsid()
	{
		return $this->iitemsid;
	}
		
	public function setInvoicesid($invoicesid)
	{
		$this->invoicesid = $invoicesid;
	}

	public function getInvoicesid()
	{
		return $this->invoicesid;
	}
		
	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
	}

	public function getQuantity()
	{
		return $this->quantity;
	}
		
	public function setJobsid($jobsid)
	{
		$this->jobsid = $jobsid;
	}

	public function getJobsid()
	{
		return $this->jobsid;
	}
		
	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}
		
	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function getPrice()
	{
		return $this->price;
	}
		
	public function setHours($hours)
	{
		$this->hours = $hours;
	}

	public function getHours()
	{
		return $this->hours;
	}
		
	public function setRate($rate)
	{
		$this->rate = $rate;
	}

	public function getRate()
	{
		return $this->rate;
	}

	public function getAll()
	{
		$ret = array(
		'invoicesid'=>$this->getInvoicesid(),
		'quantity'=>$this->getQuantity(),
		'jobsid'=>$this->getJobsid(),
		'content'=>$this->getContent(),
		'price'=>$this->getPrice(),
		'hours'=>$this->getHours(),
		'rate'=>$this->getRate());
		return $ret;
	}

	public function loadIitems() {
		global $dbsite;
		if(!isset($this->iitemsid)){
			return "No Iitems ID";
		}		
		$res = $dbsite->select('SELECT iitemsid,invoicesid,quantity,jobsid,content,price,hours,rate FROM iitems WHERE iitemsid=?', array($this->iitemsid), 'd');
		$r=$res[0];
		$this->setIitemsid($r->iitemsid);
		$this->setInvoicesid($r->invoicesid);
		$this->setQuantity($r->quantity);
		$this->setJobsid($r->jobsid);
		$this->setContent($r->content);
		$this->setPrice($r->price);
		$this->setHours($r->hours);
		$this->setRate($r->rate);

	}


	public function updateDB() {
		global $dbsite;
		global $iitemsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'iitemsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $iitemsFormats[$key];
			}
		}
		$res = $dbsite->update('iitems', $data, $format, array('iitemsid'=>$this->iitemsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsite;
		global $iitemsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $iitemsFormats[$key];
			}
		}
		$res = $dbsite->insert('iitems', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsite;
		        
		if(!isset($this->iitemsid)){
			return "No Iitems ID";
		}
		$res = $dbsite->delete('iitems', $this->iitemsid, 'iitemsid');
		return $res;
    }
}
class Invoices
{
private $invoicesid;
private $custid;
private $invoiceno;
private $incept;
private $paid;
private $content;
private $notes;
private $sent;
		
	public function setInvoicesid($invoicesid)
	{
		$this->invoicesid = $invoicesid;
	}

	public function getInvoicesid()
	{
		return $this->invoicesid;
	}
		
	public function setCustid($custid)
	{
		$this->custid = $custid;
	}

	public function getCustid()
	{
		return $this->custid;
	}
		
	public function setInvoiceno($invoiceno)
	{
		$this->invoiceno = $invoiceno;
	}

	public function getInvoiceno()
	{
		return $this->invoiceno;
	}
		
	public function setIncept($incept)
	{
		$this->incept = $incept;
	}

	public function getIncept()
	{
		return $this->incept;
	}
		
	public function setPaid($paid)
	{
		$this->paid = $paid;
	}

	public function getPaid()
	{
		return $this->paid;
	}
		
	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}
		
	public function setNotes($notes)
	{
		$this->notes = $notes;
	}

	public function getNotes()
	{
		return $this->notes;
	}
		
	public function setSent($sent)
	{
		$this->sent = $sent;
	}

	public function getSent()
	{
		return $this->sent;
	}

	public function getAll()
	{
		$ret = array(
		'custid'=>$this->getCustid(),
		'invoiceno'=>$this->getInvoiceno(),
		'incept'=>$this->getIncept(),
		'paid'=>$this->getPaid(),
		'content'=>$this->getContent(),
		'notes'=>$this->getNotes(),
		'sent'=>$this->getSent());
		return $ret;
	}

	public function loadInvoices() {
		global $dbsite;
		if(!isset($this->invoicesid)){
			return "No Invoices ID";
		}		
		$res = $dbsite->select('SELECT invoicesid,custid,invoiceno,incept,paid,content,notes,sent FROM invoices WHERE invoicesid=?', array($this->invoicesid), 'd');
		$r=$res[0];
		$this->setInvoicesid($r->invoicesid);
		$this->setCustid($r->custid);
		$this->setInvoiceno($r->invoiceno);
		$this->setIncept($r->incept);
		$this->setPaid($r->paid);
		$this->setContent($r->content);
		$this->setNotes($r->notes);
		$this->setSent($r->sent);

	}


	public function updateDB() {
		global $dbsite;
		global $invoicesFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'invoicesid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $invoicesFormats[$key];
			}
		}
		$res = $dbsite->update('invoices', $data, $format, array('invoicesid'=>$this->invoicesid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsite;
		global $invoicesFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $invoicesFormats[$key];
			}
		}
		$res = $dbsite->insert('invoices', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsite;
		        
		if(!isset($this->invoicesid)){
			return "No Invoices ID";
		}
		$res = $dbsite->delete('invoices', $this->invoicesid, 'invoicesid');
		return $res;
    }
}
class Items
{
private $itemsid;
private $price;
private $incept;
private $currency;
private $content;
private $qitemsid;
		
	public function setItemsid($itemsid)
	{
		$this->itemsid = $itemsid;
	}

	public function getItemsid()
	{
		return $this->itemsid;
	}
		
	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function getPrice()
	{
		return $this->price;
	}
		
	public function setIncept($incept)
	{
		$this->incept = $incept;
	}

	public function getIncept()
	{
		return $this->incept;
	}
		
	public function setCurrency($currency)
	{
		$this->currency = $currency;
	}

	public function getCurrency()
	{
		return $this->currency;
	}
		
	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}
		
	public function setQitemsid($qitemsid)
	{
		$this->qitemsid = $qitemsid;
	}

	public function getQitemsid()
	{
		return $this->qitemsid;
	}

	public function getAll()
	{
		$ret = array(
		'price'=>$this->getPrice(),
		'incept'=>$this->getIncept(),
		'currency'=>$this->getCurrency(),
		'content'=>$this->getContent(),
		'qitemsid'=>$this->getQitemsid());
		return $ret;
	}

	public function loadItems() {
		global $dbsite;
		if(!isset($this->itemsid)){
			return "No Items ID";
		}		
		$res = $dbsite->select('SELECT itemsid,price,incept,currency,content,qitemsid FROM items WHERE itemsid=?', array($this->itemsid), 'd');
		$r=$res[0];
		$this->setItemsid($r->itemsid);
		$this->setPrice($r->price);
		$this->setIncept($r->incept);
		$this->setCurrency($r->currency);
		$this->setContent($r->content);
		$this->setQitemsid($r->qitemsid);

	}


	public function updateDB() {
		global $dbsite;
		global $itemsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'itemsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $itemsFormats[$key];
			}
		}
		$res = $dbsite->update('items', $data, $format, array('itemsid'=>$this->itemsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsite;
		global $itemsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $itemsFormats[$key];
			}
		}
		$res = $dbsite->insert('items', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsite;
		        
		if(!isset($this->itemsid)){
			return "No Items ID";
		}
		$res = $dbsite->delete('items', $this->itemsid, 'itemsid');
		return $res;
    }
}
class Jobs
{
private $jobsid;
private $custid;
private $itemsid;
private $quantity;
private $invoicesid;
private $jobno;
private $incept;
private $done;
private $notes;
private $custref;
private $datedel;
private $datereq;
		
	public function setJobsid($jobsid)
	{
		$this->jobsid = $jobsid;
	}

	public function getJobsid()
	{
		return $this->jobsid;
	}
		
	public function setCustid($custid)
	{
		$this->custid = $custid;
	}

	public function getCustid()
	{
		return $this->custid;
	}
		
	public function setItemsid($itemsid)
	{
		$this->itemsid = $itemsid;
	}

	public function getItemsid()
	{
		return $this->itemsid;
	}
		
	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
	}

	public function getQuantity()
	{
		return $this->quantity;
	}
		
	public function setInvoicesid($invoicesid)
	{
		$this->invoicesid = $invoicesid;
	}

	public function getInvoicesid()
	{
		return $this->invoicesid;
	}
		
	public function setJobno($jobno)
	{
		$this->jobno = $jobno;
	}

	public function getJobno()
	{
		return $this->jobno;
	}
		
	public function setIncept($incept)
	{
		$this->incept = $incept;
	}

	public function getIncept()
	{
		return $this->incept;
	}
		
	public function setDone($done)
	{
		$this->done = $done;
	}

	public function getDone()
	{
		return $this->done;
	}
		
	public function setNotes($notes)
	{
		$this->notes = $notes;
	}

	public function getNotes()
	{
		return $this->notes;
	}
		
	public function setCustref($custref)
	{
		$this->custref = $custref;
	}

	public function getCustref()
	{
		return $this->custref;
	}
		
	public function setDatedel($datedel)
	{
		$this->datedel = $datedel;
	}

	public function getDatedel()
	{
		return $this->datedel;
	}
		
	public function setDatereq($datereq)
	{
		$this->datereq = $datereq;
	}

	public function getDatereq()
	{
		return $this->datereq;
	}

	public function getAll()
	{
		$ret = array(
		'custid'=>$this->getCustid(),
		'itemsid'=>$this->getItemsid(),
		'quantity'=>$this->getQuantity(),
		'invoicesid'=>$this->getInvoicesid(),
		'jobno'=>$this->getJobno(),
		'incept'=>$this->getIncept(),
		'done'=>$this->getDone(),
		'notes'=>$this->getNotes(),
		'custref'=>$this->getCustref(),
		'datedel'=>$this->getDatedel(),
		'datereq'=>$this->getDatereq());
		return $ret;
	}

	public function loadJobs() {
		global $dbsite;
		if(!isset($this->jobsid)){
			return "No Jobs ID";
		}		
		$res = $dbsite->select('SELECT jobsid,custid,itemsid,quantity,invoicesid,jobno,incept,done,notes,custref,datedel,datereq FROM jobs WHERE jobsid=?', array($this->jobsid), 'd');
		$r=$res[0];
		$this->setJobsid($r->jobsid);
		$this->setCustid($r->custid);
		$this->setItemsid($r->itemsid);
		$this->setQuantity($r->quantity);
		$this->setInvoicesid($r->invoicesid);
		$this->setJobno($r->jobno);
		$this->setIncept($r->incept);
		$this->setDone($r->done);
		$this->setNotes($r->notes);
		$this->setCustref($r->custref);
		$this->setDatedel($r->datedel);
		$this->setDatereq($r->datereq);

	}


	public function updateDB() {
		global $dbsite;
		global $jobsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'jobsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $jobsFormats[$key];
			}
		}
		$res = $dbsite->update('jobs', $data, $format, array('jobsid'=>$this->jobsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsite;
		global $jobsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $jobsFormats[$key];
			}
		}
		$res = $dbsite->insert('jobs', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsite;
		        
		if(!isset($this->jobsid)){
			return "No Jobs ID";
		}
		$res = $dbsite->delete('jobs', $this->jobsid, 'jobsid');
		return $res;
    }
}
class Mail
{
private $mailid;
private $addto;
private $addname;
private $subject;
private $body;
private $sent;
private $incept;
private $timesent;
private $docname;
private $doctitle;
private $kind;
		
	public function setMailid($mailid)
	{
		$this->mailid = $mailid;
	}

	public function getMailid()
	{
		return $this->mailid;
	}
		
	public function setAddto($addto)
	{
		$this->addto = $addto;
	}

	public function getAddto()
	{
		return $this->addto;
	}
		
	public function setAddname($addname)
	{
		$this->addname = $addname;
	}

	public function getAddname()
	{
		return $this->addname;
	}
		
	public function setSubject($subject)
	{
		$this->subject = $subject;
	}

	public function getSubject()
	{
		return $this->subject;
	}
		
	public function setBody($body)
	{
		$this->body = $body;
	}

	public function getBody()
	{
		return $this->body;
	}
		
	public function setSent($sent)
	{
		$this->sent = $sent;
	}

	public function getSent()
	{
		return $this->sent;
	}
		
	public function setIncept($incept)
	{
		$this->incept = $incept;
	}

	public function getIncept()
	{
		return $this->incept;
	}
		
	public function setTimesent($timesent)
	{
		$this->timesent = $timesent;
	}

	public function getTimesent()
	{
		return $this->timesent;
	}
		
	public function setDocname($docname)
	{
		$this->docname = $docname;
	}

	public function getDocname()
	{
		return $this->docname;
	}
		
	public function setDoctitle($doctitle)
	{
		$this->doctitle = $doctitle;
	}

	public function getDoctitle()
	{
		return $this->doctitle;
	}
		
	public function setKind($kind)
	{
		$this->kind = $kind;
	}

	public function getKind()
	{
		return $this->kind;
	}

	public function getAll()
	{
		$ret = array(
		'addto'=>$this->getAddto(),
		'addname'=>$this->getAddname(),
		'subject'=>$this->getSubject(),
		'body'=>$this->getBody(),
		'sent'=>$this->getSent(),
		'incept'=>$this->getIncept(),
		'timesent'=>$this->getTimesent(),
		'docname'=>$this->getDocname(),
		'doctitle'=>$this->getDoctitle(),
		'kind'=>$this->getKind());
		return $ret;
	}

	public function loadMail() {
		global $dbsite;
		if(!isset($this->mailid)){
			return "No Mail ID";
		}		
		$res = $dbsite->select('SELECT mailid,addto,addname,subject,body,sent,incept,timesent,docname,doctitle,kind FROM mail WHERE mailid=?', array($this->mailid), 'd');
		$r=$res[0];
		$this->setMailid($r->mailid);
		$this->setAddto($r->addto);
		$this->setAddname($r->addname);
		$this->setSubject($r->subject);
		$this->setBody($r->body);
		$this->setSent($r->sent);
		$this->setIncept($r->incept);
		$this->setTimesent($r->timesent);
		$this->setDocname($r->docname);
		$this->setDoctitle($r->doctitle);
		$this->setKind($r->kind);

	}


	public function updateDB() {
		global $dbsite;
		global $mailFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'mailid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $mailFormats[$key];
			}
		}
		$res = $dbsite->update('mail', $data, $format, array('mailid'=>$this->mailid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsite;
		global $mailFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $mailFormats[$key];
			}
		}
		$res = $dbsite->insert('mail', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsite;
		        
		if(!isset($this->mailid)){
			return "No Mail ID";
		}
		$res = $dbsite->delete('mail', $this->mailid, 'mailid');
		return $res;
    }
}
class Pwd
{
private $usr;
private $staffid;
private $custid;
private $suppid;
private $contactsid;
private $seclev;
private $pw;
private $init;
private $lastlogin;
		
	public function setUsr($usr)
	{
		$this->usr = $usr;
	}

	public function getUsr()
	{
		return $this->usr;
	}
		
	public function setStaffid($staffid)
	{
		$this->staffid = $staffid;
	}

	public function getStaffid()
	{
		return $this->staffid;
	}
		
	public function setCustid($custid)
	{
		$this->custid = $custid;
	}

	public function getCustid()
	{
		return $this->custid;
	}
		
	public function setSuppid($suppid)
	{
		$this->suppid = $suppid;
	}

	public function getSuppid()
	{
		return $this->suppid;
	}
		
	public function setContactsid($contactsid)
	{
		$this->contactsid = $contactsid;
	}

	public function getContactsid()
	{
		return $this->contactsid;
	}
		
	public function setSeclev($seclev)
	{
		$this->seclev = $seclev;
	}

	public function getSeclev()
	{
		return $this->seclev;
	}
		
	public function setPw($pw)
	{
		$this->pw = $pw;
	}

	public function getPw()
	{
		return $this->pw;
	}
		
	public function setInit($init)
	{
		$this->init = $init;
	}

	public function getInit()
	{
		return $this->init;
	}
		
	public function setLastlogin($lastlogin)
	{
		$this->lastlogin = $lastlogin;
	}

	public function getLastlogin()
	{
		return $this->lastlogin;
	}

	public function getAll()
	{
		$ret = array(
		'staffid'=>$this->getStaffid(),
		'custid'=>$this->getCustid(),
		'suppid'=>$this->getSuppid(),
		'contactsid'=>$this->getContactsid(),
		'seclev'=>$this->getSeclev(),
		'pw'=>$this->getPw(),
		'init'=>$this->getInit(),
		'lastlogin'=>$this->getLastlogin());
		return $ret;
	}

	public function loadPwd() {
		global $dbsite;
		if(!isset($this->usr)){
			return "No Pwd ID";
		}		
		$res = $dbsite->select('SELECT usr,staffid,custid,suppid,contactsid,seclev,pw,init,lastlogin FROM pwd WHERE usr=?', array($this->usr), 's');
		$r=$res[0];
		$this->setUsr($r->usr);
		$this->setStaffid($r->staffid);
		$this->setCustid($r->custid);
		$this->setSuppid($r->suppid);
		$this->setContactsid($r->contactsid);
		$this->setSeclev($r->seclev);
		$this->setPw($r->pw);
		$this->setInit($r->init);
		$this->setLastlogin($r->lastlogin);

	}


	public function updateDB() {
		global $dbsite;
		global $pwdFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'usr'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $pwdFormats[$key];
			}
		}
		$res = $dbsite->update('pwd', $data, $format, array('usr'=>$this->usr), 's');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsite;
		global $pwdFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $pwdFormats[$key];
			}
		}
		$res = $dbsite->insert('pwd', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsite;
		        
		if(!isset($this->usr)){
			return "No Pwd ID";
		}
		$res = $dbsite->delete('pwd', $this->usr, 'usr');
		return $res;
    }
}
class Qitems
{
private $qitemsid;
private $quotesid;
private $itemno;
private $agreed;
private $content;
private $price;
private $quantity;
private $datereq;
private $hours;
private $rate;
		
	public function setQitemsid($qitemsid)
	{
		$this->qitemsid = $qitemsid;
	}

	public function getQitemsid()
	{
		return $this->qitemsid;
	}
		
	public function setQuotesid($quotesid)
	{
		$this->quotesid = $quotesid;
	}

	public function getQuotesid()
	{
		return $this->quotesid;
	}
		
	public function setItemno($itemno)
	{
		$this->itemno = $itemno;
	}

	public function getItemno()
	{
		return $this->itemno;
	}
		
	public function setAgreed($agreed)
	{
		$this->agreed = $agreed;
	}

	public function getAgreed()
	{
		return $this->agreed;
	}
		
	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}
		
	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function getPrice()
	{
		return $this->price;
	}
		
	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
	}

	public function getQuantity()
	{
		return $this->quantity;
	}
		
	public function setDatereq($datereq)
	{
		$this->datereq = $datereq;
	}

	public function getDatereq()
	{
		return $this->datereq;
	}
		
	public function setHours($hours)
	{
		$this->hours = $hours;
	}

	public function getHours()
	{
		return $this->hours;
	}
		
	public function setRate($rate)
	{
		$this->rate = $rate;
	}

	public function getRate()
	{
		return $this->rate;
	}

	public function getAll()
	{
		$ret = array(
		'quotesid'=>$this->getQuotesid(),
		'itemno'=>$this->getItemno(),
		'agreed'=>$this->getAgreed(),
		'content'=>$this->getContent(),
		'price'=>$this->getPrice(),
		'quantity'=>$this->getQuantity(),
		'datereq'=>$this->getDatereq(),
		'hours'=>$this->getHours(),
		'rate'=>$this->getRate());
		return $ret;
	}

	public function loadQitems() {
		global $dbsite;
		if(!isset($this->qitemsid)){
			return "No Qitems ID";
		}		
		$res = $dbsite->select('SELECT qitemsid,quotesid,itemno,agreed,content,price,quantity,datereq,hours,rate FROM qitems WHERE qitemsid=?', array($this->qitemsid), 'd');
		$r=$res[0];
		$this->setQitemsid($r->qitemsid);
		$this->setQuotesid($r->quotesid);
		$this->setItemno($r->itemno);
		$this->setAgreed($r->agreed);
		$this->setContent($r->content);
		$this->setPrice($r->price);
		$this->setQuantity($r->quantity);
		$this->setDatereq($r->datereq);
		$this->setHours($r->hours);
		$this->setRate($r->rate);

	}


	public function updateDB() {
		global $dbsite;
		global $qitemsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'qitemsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $qitemsFormats[$key];
			}
		}
		$res = $dbsite->update('qitems', $data, $format, array('qitemsid'=>$this->qitemsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsite;
		global $qitemsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $qitemsFormats[$key];
			}
		}
		$res = $dbsite->insert('qitems', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsite;
		        
		if(!isset($this->qitemsid)){
			return "No Qitems ID";
		}
		$res = $dbsite->delete('qitems', $this->qitemsid, 'qitemsid');
		return $res;
    }
}
class Quotes
{
private $quotesid;
private $staffid;
private $custid;
private $contactsid;
private $quoteno;
private $incept;
private $origin;
private $agree;
private $live;
private $content;
private $notes;
private $sent;
		
	public function setQuotesid($quotesid)
	{
		$this->quotesid = $quotesid;
	}

	public function getQuotesid()
	{
		return $this->quotesid;
	}
		
	public function setStaffid($staffid)
	{
		$this->staffid = $staffid;
	}

	public function getStaffid()
	{
		return $this->staffid;
	}
		
	public function setCustid($custid)
	{
		$this->custid = $custid;
	}

	public function getCustid()
	{
		return $this->custid;
	}
		
	public function setContactsid($contactsid)
	{
		$this->contactsid = $contactsid;
	}

	public function getContactsid()
	{
		return $this->contactsid;
	}
		
	public function setQuoteno($quoteno)
	{
		$this->quoteno = $quoteno;
	}

	public function getQuoteno()
	{
		return $this->quoteno;
	}
		
	public function setIncept($incept)
	{
		$this->incept = $incept;
	}

	public function getIncept()
	{
		return $this->incept;
	}
		
	public function setOrigin($origin)
	{
		$this->origin = $origin;
	}

	public function getOrigin()
	{
		return $this->origin;
	}
		
	public function setAgree($agree)
	{
		$this->agree = $agree;
	}

	public function getAgree()
	{
		return $this->agree;
	}
		
	public function setLive($live)
	{
		$this->live = $live;
	}

	public function getLive()
	{
		return $this->live;
	}
		
	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}
		
	public function setNotes($notes)
	{
		$this->notes = $notes;
	}

	public function getNotes()
	{
		return $this->notes;
	}
		
	public function setSent($sent)
	{
		$this->sent = $sent;
	}

	public function getSent()
	{
		return $this->sent;
	}

	public function getAll()
	{
		$ret = array(
		'staffid'=>$this->getStaffid(),
		'custid'=>$this->getCustid(),
		'contactsid'=>$this->getContactsid(),
		'quoteno'=>$this->getQuoteno(),
		'incept'=>$this->getIncept(),
		'origin'=>$this->getOrigin(),
		'agree'=>$this->getAgree(),
		'live'=>$this->getLive(),
		'content'=>$this->getContent(),
		'notes'=>$this->getNotes(),
		'sent'=>$this->getSent());
		return $ret;
	}

	public function loadQuotes() {
		global $dbsite;
		if(!isset($this->quotesid)){
			return "No Quotes ID";
		}		
		$res = $dbsite->select('SELECT quotesid,staffid,custid,contactsid,quoteno,incept,origin,agree,live,content,notes,sent FROM quotes WHERE quotesid=?', array($this->quotesid), 'd');
		$r=$res[0];
		$this->setQuotesid($r->quotesid);
		$this->setStaffid($r->staffid);
		$this->setCustid($r->custid);
		$this->setContactsid($r->contactsid);
		$this->setQuoteno($r->quoteno);
		$this->setIncept($r->incept);
		$this->setOrigin($r->origin);
		$this->setAgree($r->agree);
		$this->setLive($r->live);
		$this->setContent($r->content);
		$this->setNotes($r->notes);
		$this->setSent($r->sent);

	}


	public function updateDB() {
		global $dbsite;
		global $quotesFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'quotesid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $quotesFormats[$key];
			}
		}
		$res = $dbsite->update('quotes', $data, $format, array('quotesid'=>$this->quotesid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsite;
		global $quotesFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $quotesFormats[$key];
			}
		}
		$res = $dbsite->insert('quotes', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsite;
		        
		if(!isset($this->quotesid)){
			return "No Quotes ID";
		}
		$res = $dbsite->delete('quotes', $this->quotesid, 'quotesid');
		return $res;
    }
}
class Rfq
{
private $rfqid;
private $content;
private $quantity;
private $fname;
private $sname;
private $email;
private $tel;
private $co_name;
private $incept;
		
	public function setRfqid($rfqid)
	{
		$this->rfqid = $rfqid;
	}

	public function getRfqid()
	{
		return $this->rfqid;
	}
		
	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}
		
	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
	}

	public function getQuantity()
	{
		return $this->quantity;
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
		
	public function setCo_name($co_name)
	{
		$this->co_name = $co_name;
	}

	public function getCo_name()
	{
		return $this->co_name;
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
		'content'=>$this->getContent(),
		'quantity'=>$this->getQuantity(),
		'fname'=>$this->getFname(),
		'sname'=>$this->getSname(),
		'email'=>$this->getEmail(),
		'tel'=>$this->getTel(),
		'co_name'=>$this->getCo_name(),
		'incept'=>$this->getIncept());
		return $ret;
	}

	public function loadRfq() {
		global $dbsite;
		if(!isset($this->rfqid)){
			return "No Rfq ID";
		}		
		$res = $dbsite->select('SELECT rfqid,content,quantity,fname,sname,email,tel,co_name,incept FROM rfq WHERE rfqid=?', array($this->rfqid), 'd');
		$r=$res[0];
		$this->setRfqid($r->rfqid);
		$this->setContent($r->content);
		$this->setQuantity($r->quantity);
		$this->setFname($r->fname);
		$this->setSname($r->sname);
		$this->setEmail($r->email);
		$this->setTel($r->tel);
		$this->setCo_name($r->co_name);
		$this->setIncept($r->incept);

	}


	public function updateDB() {
		global $dbsite;
		global $rfqFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'rfqid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $rfqFormats[$key];
			}
		}
		$res = $dbsite->update('rfq', $data, $format, array('rfqid'=>$this->rfqid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsite;
		global $rfqFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $rfqFormats[$key];
			}
		}
		$res = $dbsite->insert('rfq', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsite;
		        
		if(!isset($this->rfqid)){
			return "No Rfq ID";
		}
		$res = $dbsite->delete('rfq', $this->rfqid, 'rfqid');
		return $res;
    }
}
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
		global $dbsite;
		if(!isset($this->sitelogid)){
			return "No Sitelog ID";
		}		
		$res = $dbsite->select('SELECT sitelogid,incept,staffid,contactsid,level,content,eventsid FROM sitelog WHERE sitelogid=?', array($this->sitelogid), 'd');
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
		global $dbsite;
		global $sitelogFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'sitelogid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $sitelogFormats[$key];
			}
		}
		$res = $dbsite->update('sitelog', $data, $format, array('sitelogid'=>$this->sitelogid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsite;
		global $sitelogFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $sitelogFormats[$key];
			}
		}
		$res = $dbsite->insert('sitelog', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsite;
		        
		if(!isset($this->sitelogid)){
			return "No Sitelog ID";
		}
		$res = $dbsite->delete('sitelog', $this->sitelogid, 'sitelogid');
		return $res;
    }
}
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
		global $dbsite;
		if(!isset($this->staffid)){
			return "No Staff ID";
		}		
		$res = $dbsite->select('SELECT staffid,fname,sname,addsid,notes,jobtitle,content,status,level,teamsid,timesheet,holiday,theme FROM staff WHERE staffid=?', array($this->staffid), 'd');
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
		global $dbsite;
		global $staffFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'staffid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $staffFormats[$key];
			}
		}
		$res = $dbsite->update('staff', $data, $format, array('staffid'=>$this->staffid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsite;
		global $staffFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $staffFormats[$key];
			}
		}
		$res = $dbsite->insert('staff', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsite;
		        
		if(!isset($this->staffid)){
			return "No Staff ID";
		}
		$res = $dbsite->delete('staff', $this->staffid, 'staffid');
		return $res;
    }
}
class Stock
{
private $stockid;
private $sku;
private $name;
private $description;
private $stockq;
private $price;
private $copytitle;
private $copybody;
private $copyfeatures;
private $copyterms;
private $copyimage;
		
	public function setStockid($stockid)
	{
		$this->stockid = $stockid;
	}

	public function getStockid()
	{
		return $this->stockid;
	}
		
	public function setSku($sku)
	{
		$this->sku = $sku;
	}

	public function getSku()
	{
		return $this->sku;
	}
		
	public function setName($name)
	{
		$this->name = $name;
	}

	public function getName()
	{
		return $this->name;
	}
		
	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function getDescription()
	{
		return $this->description;
	}
		
	public function setStockq($stockq)
	{
		$this->stockq = $stockq;
	}

	public function getStockq()
	{
		return $this->stockq;
	}
		
	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function getPrice()
	{
		return $this->price;
	}
		
	public function setCopytitle($copytitle)
	{
		$this->copytitle = $copytitle;
	}

	public function getCopytitle()
	{
		return $this->copytitle;
	}
		
	public function setCopybody($copybody)
	{
		$this->copybody = $copybody;
	}

	public function getCopybody()
	{
		return $this->copybody;
	}
		
	public function setCopyfeatures($copyfeatures)
	{
		$this->copyfeatures = $copyfeatures;
	}

	public function getCopyfeatures()
	{
		return $this->copyfeatures;
	}
		
	public function setCopyterms($copyterms)
	{
		$this->copyterms = $copyterms;
	}

	public function getCopyterms()
	{
		return $this->copyterms;
	}
		
	public function setCopyimage($copyimage)
	{
		$this->copyimage = $copyimage;
	}

	public function getCopyimage()
	{
		return $this->copyimage;
	}

	public function getAll()
	{
		$ret = array(
		'sku'=>$this->getSku(),
		'name'=>$this->getName(),
		'description'=>$this->getDescription(),
		'stockq'=>$this->getStockq(),
		'price'=>$this->getPrice(),
		'copytitle'=>$this->getCopytitle(),
		'copybody'=>$this->getCopybody(),
		'copyfeatures'=>$this->getCopyfeatures(),
		'copyterms'=>$this->getCopyterms(),
		'copyimage'=>$this->getCopyimage());
		return $ret;
	}

	public function loadStock() {
		global $dbsite;
		if(!isset($this->stockid)){
			return "No Stock ID";
		}		
		$res = $dbsite->select('SELECT stockid,sku,name,description,stockq,price,copytitle,copybody,copyfeatures,copyterms,copyimage FROM stock WHERE stockid=?', array($this->stockid), 'd');
		$r=$res[0];
		$this->setStockid($r->stockid);
		$this->setSku($r->sku);
		$this->setName($r->name);
		$this->setDescription($r->description);
		$this->setStockq($r->stockq);
		$this->setPrice($r->price);
		$this->setCopytitle($r->copytitle);
		$this->setCopybody($r->copybody);
		$this->setCopyfeatures($r->copyfeatures);
		$this->setCopyterms($r->copyterms);
		$this->setCopyimage($r->copyimage);

	}


	public function updateDB() {
		global $dbsite;
		global $stockFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'stockid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $stockFormats[$key];
			}
		}
		$res = $dbsite->update('stock', $data, $format, array('stockid'=>$this->stockid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsite;
		global $stockFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $stockFormats[$key];
			}
		}
		$res = $dbsite->insert('stock', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsite;
		        
		if(!isset($this->stockid)){
			return "No Stock ID";
		}
		$res = $dbsite->delete('stock', $this->stockid, 'stockid');
		return $res;
    }
}
class Supp
{
private $suppid;
private $co_name;
private $fname;
private $sname;
private $contact;
private $addsid;
private $inv_email;
private $inv_contact;
private $colour;
private $live;
		
	public function setSuppid($suppid)
	{
		$this->suppid = $suppid;
	}

	public function getSuppid()
	{
		return $this->suppid;
	}
		
	public function setCo_name($co_name)
	{
		$this->co_name = $co_name;
	}

	public function getCo_name()
	{
		return $this->co_name;
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
		
	public function setContact($contact)
	{
		$this->contact = $contact;
	}

	public function getContact()
	{
		return $this->contact;
	}
		
	public function setAddsid($addsid)
	{
		$this->addsid = $addsid;
	}

	public function getAddsid()
	{
		return $this->addsid;
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
		
	public function setLive($live)
	{
		$this->live = $live;
	}

	public function getLive()
	{
		return $this->live;
	}

	public function getAll()
	{
		$ret = array(
		'co_name'=>$this->getCo_name(),
		'fname'=>$this->getFname(),
		'sname'=>$this->getSname(),
		'contact'=>$this->getContact(),
		'addsid'=>$this->getAddsid(),
		'inv_email'=>$this->getInv_email(),
		'inv_contact'=>$this->getInv_contact(),
		'colour'=>$this->getColour(),
		'live'=>$this->getLive());
		return $ret;
	}

	public function loadSupp() {
		global $dbsite;
		if(!isset($this->suppid)){
			return "No Supp ID";
		}		
		$res = $dbsite->select('SELECT suppid,co_name,fname,sname,contact,addsid,inv_email,inv_contact,colour,live FROM supp WHERE suppid=?', array($this->suppid), 'd');
		$r=$res[0];
		$this->setSuppid($r->suppid);
		$this->setCo_name($r->co_name);
		$this->setFname($r->fname);
		$this->setSname($r->sname);
		$this->setContact($r->contact);
		$this->setAddsid($r->addsid);
		$this->setInv_email($r->inv_email);
		$this->setInv_contact($r->inv_contact);
		$this->setColour($r->colour);
		$this->setLive($r->live);

	}


	public function updateDB() {
		global $dbsite;
		global $suppFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'suppid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $suppFormats[$key];
			}
		}
		$res = $dbsite->update('supp', $data, $format, array('suppid'=>$this->suppid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsite;
		global $suppFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $suppFormats[$key];
			}
		}
		$res = $dbsite->insert('supp', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsite;
		        
		if(!isset($this->suppid)){
			return "No Supp ID";
		}
		$res = $dbsite->delete('supp', $this->suppid, 'suppid');
		return $res;
    }
}
class Tasks
{
private $tasksid;
private $custid;
private $jobsid;
private $notes;
private $incept;
private $staffid;
private $hours;
private $rate;
private $invoicesid;
private $contactsid;
		
	public function setTasksid($tasksid)
	{
		$this->tasksid = $tasksid;
	}

	public function getTasksid()
	{
		return $this->tasksid;
	}
		
	public function setCustid($custid)
	{
		$this->custid = $custid;
	}

	public function getCustid()
	{
		return $this->custid;
	}
		
	public function setJobsid($jobsid)
	{
		$this->jobsid = $jobsid;
	}

	public function getJobsid()
	{
		return $this->jobsid;
	}
		
	public function setNotes($notes)
	{
		$this->notes = $notes;
	}

	public function getNotes()
	{
		return $this->notes;
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
		
	public function setHours($hours)
	{
		$this->hours = $hours;
	}

	public function getHours()
	{
		return $this->hours;
	}
		
	public function setRate($rate)
	{
		$this->rate = $rate;
	}

	public function getRate()
	{
		return $this->rate;
	}
		
	public function setInvoicesid($invoicesid)
	{
		$this->invoicesid = $invoicesid;
	}

	public function getInvoicesid()
	{
		return $this->invoicesid;
	}
		
	public function setContactsid($contactsid)
	{
		$this->contactsid = $contactsid;
	}

	public function getContactsid()
	{
		return $this->contactsid;
	}

	public function getAll()
	{
		$ret = array(
		'custid'=>$this->getCustid(),
		'jobsid'=>$this->getJobsid(),
		'notes'=>$this->getNotes(),
		'incept'=>$this->getIncept(),
		'staffid'=>$this->getStaffid(),
		'hours'=>$this->getHours(),
		'rate'=>$this->getRate(),
		'invoicesid'=>$this->getInvoicesid(),
		'contactsid'=>$this->getContactsid());
		return $ret;
	}

	public function loadTasks() {
		global $dbsite;
		if(!isset($this->tasksid)){
			return "No Tasks ID";
		}		
		$res = $dbsite->select('SELECT tasksid,custid,jobsid,notes,incept,staffid,hours,rate,invoicesid,contactsid FROM tasks WHERE tasksid=?', array($this->tasksid), 'd');
		$r=$res[0];
		$this->setTasksid($r->tasksid);
		$this->setCustid($r->custid);
		$this->setJobsid($r->jobsid);
		$this->setNotes($r->notes);
		$this->setIncept($r->incept);
		$this->setStaffid($r->staffid);
		$this->setHours($r->hours);
		$this->setRate($r->rate);
		$this->setInvoicesid($r->invoicesid);
		$this->setContactsid($r->contactsid);

	}


	public function updateDB() {
		global $dbsite;
		global $tasksFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'tasksid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $tasksFormats[$key];
			}
		}
		$res = $dbsite->update('tasks', $data, $format, array('tasksid'=>$this->tasksid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsite;
		global $tasksFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $tasksFormats[$key];
			}
		}
		$res = $dbsite->insert('tasks', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsite;
		        
		if(!isset($this->tasksid)){
			return "No Tasks ID";
		}
		$res = $dbsite->delete('tasks', $this->tasksid, 'tasksid');
		return $res;
    }
}
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
		global $dbsite;
		if(!isset($this->timesid)){
			return "No Times ID";
		}		
		$res = $dbsite->select('SELECT timesid,staffid,incept,start,finish,notes,day,times_typesid,lstart,lfinish FROM times WHERE timesid=?', array($this->timesid), 'd');
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
		global $dbsite;
		global $timesFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'timesid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $timesFormats[$key];
			}
		}
		$res = $dbsite->update('times', $data, $format, array('timesid'=>$this->timesid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsite;
		global $timesFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $timesFormats[$key];
			}
		}
		$res = $dbsite->insert('times', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsite;
		        
		if(!isset($this->timesid)){
			return "No Times ID";
		}
		$res = $dbsite->delete('times', $this->timesid, 'timesid');
		return $res;
    }
}
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
		global $dbsite;
		if(!isset($this->webid)){
			return "No Web ID";
		}		
		$res = $dbsite->select('SELECT webid,text,place FROM web WHERE webid=?', array($this->webid), 'd');
		$r=$res[0];
		$this->setWebid($r->webid);
		$this->setText($r->text);
		$this->setPlace($r->place);

	}


	public function updateDB() {
		global $dbsite;
		global $webFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'webid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $webFormats[$key];
			}
		}
		$res = $dbsite->update('web', $data, $format, array('webid'=>$this->webid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $dbsite;
		global $webFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $webFormats[$key];
			}
		}
		$res = $dbsite->insert('web', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $dbsite;
		        
		if(!isset($this->webid)){
			return "No Web ID";
		}
		$res = $dbsite->delete('web', $this->webid, 'webid');
		return $res;
    }
}


 $addsFormats= array(
"addsid" => "i",
"add1" => "s",
"add2" => "s",
"add3" => "s",
"city" => "s",
"county" => "s",
"country" => "s",
"postcode" => "s",
"tel" => "s",
"mob" => "s",
"fax" => "s",
"email" => "s",
"web" => "s",
"facebook" => "s",
"twitter" => "s",
"linkedin" => "s");


 $contactsFormats= array(
"contactsid" => "i",
"title" => "s",
"fname" => "s",
"sname" => "s",
"co_name" => "s",
"role" => "s",
"custid" => "i",
"suppid" => "i",
"addsid" => "i",
"notes" => "s");


 $costsFormats= array(
"costsid" => "i",
"expsid" => "i",
"description" => "s",
"price" => "d",
"incept" => "i",
"supplier" => "s");


 $custFormats= array(
"custid" => "i",
"fname" => "s",
"sname" => "s",
"co_name" => "s",
"contact" => "s",
"addsid" => "i",
"inv_email" => "s",
"inv_contact" => "i",
"colour" => "s",
"filestr" => "s",
"live" => "i");


 $diaryFormats= array(
"diaryid" => "i",
"incept" => "i",
"duration" => "s",
"title" => "s",
"content" => "s",
"location" => "s",
"staffid" => "i",
"done" => "i",
"every" => "s",
"end" => "i",
"origin" => "i");


 $iitemsFormats= array(
"iitemsid" => "i",
"invoicesid" => "i",
"quantity" => "i",
"jobsid" => "i",
"content" => "s",
"price" => "d",
"hours" => "i",
"rate" => "d");


 $invoicesFormats= array(
"invoicesid" => "i",
"custid" => "i",
"invoiceno" => "s",
"incept" => "i",
"paid" => "i",
"content" => "s",
"notes" => "s",
"sent" => "i");


 $itemsFormats= array(
"itemsid" => "i",
"price" => "d",
"incept" => "i",
"currency" => "s",
"content" => "s",
"qitemsid" => "i");


 $jobsFormats= array(
"jobsid" => "i",
"custid" => "i",
"itemsid" => "i",
"quantity" => "i",
"invoicesid" => "i",
"jobno" => "s",
"incept" => "i",
"done" => "i",
"notes" => "s",
"custref" => "s",
"datedel" => "i",
"datereq" => "i");


 $mailFormats= array(
"mailid" => "i",
"addto" => "s",
"addname" => "s",
"subject" => "s",
"body" => "s",
"sent" => "i",
"incept" => "i",
"timesent" => "i",
"docname" => "s",
"doctitle" => "s",
"kind" => "s");


 $pwdFormats= array(
"usr" => "s",
"staffid" => "i",
"custid" => "i",
"suppid" => "i",
"contactsid" => "i",
"seclev" => "i",
"pw" => "s",
"init" => "s",
"lastlogin" => "i");


 $qitemsFormats= array(
"qitemsid" => "i",
"quotesid" => "i",
"itemno" => "i",
"agreed" => "i",
"content" => "s",
"price" => "d",
"quantity" => "i",
"datereq" => "i",
"hours" => "i",
"rate" => "i");


 $quotesFormats= array(
"quotesid" => "i",
"staffid" => "i",
"custid" => "i",
"contactsid" => "i",
"quoteno" => "s",
"incept" => "i",
"origin" => "s",
"agree" => "i",
"live" => "i",
"content" => "s",
"notes" => "s",
"sent" => "i");


 $rfqFormats= array(
"rfqid" => "i",
"content" => "s",
"quantity" => "i",
"fname" => "s",
"sname" => "s",
"email" => "s",
"tel" => "s",
"co_name" => "s",
"incept" => "i");


 $sitelogFormats= array(
"sitelogid" => "i",
"incept" => "i",
"staffid" => "i",
"contactsid" => "i",
"level" => "i",
"content" => "s",
"eventsid" => "i");


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


 $stockFormats= array(
"stockid" => "i",
"sku" => "s",
"name" => "s",
"description" => "s",
"stockq" => "i",
"price" => "d",
"copytitle" => "s",
"copybody" => "s",
"copyfeatures" => "s",
"copyterms" => "s",
"copyimage" => "s");


 $suppFormats= array(
"suppid" => "i",
"co_name" => "s",
"fname" => "s",
"sname" => "s",
"contact" => "s",
"addsid" => "i",
"inv_email" => "s",
"inv_contact" => "i",
"colour" => "s",
"live" => "i");


 $tasksFormats= array(
"tasksid" => "i",
"custid" => "i",
"jobsid" => "i",
"notes" => "s",
"incept" => "i",
"staffid" => "i",
"hours" => "d",
"rate" => "i",
"invoicesid" => "i",
"contactsid" => "i");


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


 $webFormats= array(
"webid" => "i",
"text" => "s",
"place" => "s");



?>