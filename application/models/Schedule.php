<?php

class Schedule extend CI_Model {
	
	protected $xml = null;
	protected $days = null;
	protected $courses = null;
	protected $timeslots = null;
	
	public function _construct() {
		parent::_construct();
		$this->xml = simplexml_load_file(DATAPATH, 'schedule.xml');
		
		// create arrays for each propert
		$days = array();
		$courses = array();
		$timeslots = array();
		
		foreach($this->xml->daysofweek->day as $day) {
			$dayBookings = array();
			foreach($day->dbooking as $d)
			{
				$booking = new Booking();
				$booking['day'] = (string) $day['name'];
				$booking['time'] = $b['time'];
				$booking['room'] = $b['room'];
				$booking['type'] = $b['type'];
				$booking['instructor'] = $b['instructor'];
				$booking['course'] = $b['course'];
				array_push($dayBookings, $booking);
			}
			$this->days[(string) $day['name']] = $day;
		}
		
		foreach($this->xml->courses->course as $course)
		{
			$courseBookings = array();
			foreach($course->cbooking as $c)
			{
				$booking = new Booking();
				$booking['course'] = (string) $course['num'];
				$booking['day'] = $c['day'];
				$booking['time'] = $c['time'];
				$booking['room'] = $c['room'];
				$booking['type'] = $c['type'];
				$booking['instructor'] = $c['instructor'];
				array_push($courseBookings, $booking);
			}
			$this->courses[(string) $course['num']] = $course;
		}
		
		foreach($this->xml->timeslots->slots as $slot)
		{
			$timeBookings = array();
			foreach($slot->tbooking as $t)
			{
				$booking = new Booking();
				$booking['course'] = $t['num'];
				$booking['day'] = $t['day'];
				$booking['time'] = $slot['start'];
				$booking['room'] = $t['room'];
				$booking['type'] = $t['type'];
				$booking['instructor'] = $t['instructor'];
				array_push($timeBookings, $booking);
			}
		}
		$this->timeslots[(string) $slot['start']] = $slot;
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
	
	 function query($day, $time, $course)
    {
        $result = array();
        $dayResult = array();
        $courseResult = array();
        $periodResult = array();
        if ($day !== "void")
            $dayResult = $this->queryDay($day);
        if ($time !== "void")
            $periodResult = $this->queryTime($time);
        if ($course !== "void")
            $courseResult = $this->queryCourse($course);
        array_push($result, $dayResult);
        array_push($result, $periodResult);
        array_push($result, $courseResult);
        return $result;
    }
}

class Booking
{
	public $course;
	public $day;
	public $time;
	public $room;
	public $type;
	public $instructor;
}