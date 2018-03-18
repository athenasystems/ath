<?php

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
		global $db;
		if(!isset($this->addsid)){
			return "No Adds ID";
		}		
		$res = $db->select('SELECT addsid,add1,add2,add3,city,county,country,postcode,tel,mob,fax,email,web,facebook,twitter,linkedin FROM adds WHERE addsid=?', array($this->addsid), 'd');
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
		global $db;
		global $addsFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'addsid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $addsFormats[$key];
			}
		}
		$res = $db->update('adds', $data, $format, array('addsid'=>$this->addsid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $addsFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $addsFormats[$key];
			}
		}
		$res = $db->insert('adds', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->addsid)){
			return "No Adds ID";
		}
		$res = $db->delete('adds', $this->addsid, 'addsid');
		return $res;
    }
}
?>