<?php

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
		global $db;
		if(!isset($this->diaryid)){
			return "No Diary ID";
		}		
		$res = $db->select('SELECT diaryid,incept,duration,title,content,location,staffid,done,every,end,origin FROM diary WHERE diaryid=?', array($this->diaryid), 'd');
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
		global $db;
		global $diaryFormats;
		
		$format = '';
		foreach($this as $key => $value) {
			if($key == 'diaryid'){continue;}
			if (isset($this->$key)) {
				$data[$key] = $value;
				$format .= $diaryFormats[$key];
			}
		}
		$res = $db->update('diary', $data, $format, array('diaryid'=>$this->diaryid), 'i');	    
		return $res;
	}


	public function insertIntoDB() {
		global $db;
		global $diaryFormats;
		$format = '';
		foreach($this as $key => $value) {
	        if (isset($this->$key)) {
	            $data[$key] = $value;
	            $format .= $diaryFormats[$key];
			}
		}
		$res = $db->insert('diary', $data, $format);
		return $res;
	}


	 public function deleteFromDB() {
		global $db;
		        
		if(!isset($this->diaryid)){
			return "No Diary ID";
		}
		$res = $db->delete('diary', $this->diaryid, 'diaryid');
		return $res;
    }
}
?>