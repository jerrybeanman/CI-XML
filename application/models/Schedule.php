<?php

class Schedule extend CI_Model {
	
	protected $xml = null;
	protected $days = null;
	protected $courses = null;
	protected $timeslots = null;
	
	public function _construct() {
		parent::_construct();
		$this->xml = simplexml_load_file(DATAPATH, 'schedule.xml');
		
		foreach($this->xml->daysofweek->day as $day) {
			$this->days[(string) $day['name']] = (string) $day;
		}
		
		foreach($this->xml->courses->course as $course)
		{
			$this->courses[(string) $course['num']] = (string) $course;
		}
		
		foreach($this->xml->timeslots->slots as $slot)
		{
			$record = new stdClass();
			$record->start = (string) $slot['start'];
			$record->end = (string) $slot['end'];
			$this->timeslots[$record->start] = $slot;
		}
	}
	
	function getDaysOfWeek()
	{
		return $this->days;
	}
	
	function getDay($name)
	{
		if (isset($this->days[$name]))
			return $this->days[$name];
		else
			return null;
	}
	
	function getTimeslots()
	{
		return $this->timeslots;
	}
	
	function getTimeslot($slot)
	{
		if (isset($this->timeslots[$slot]))
			return $this->timeslots[$slot];
		else
			return null;
	}
	
	function getCourses()
	{
		return $this->courses;
	}
	
	function getCourse($course)
	{
		if (isset($this->courses[$course]))
			return $this->courses[$course];
		else
			return null;
	}
}