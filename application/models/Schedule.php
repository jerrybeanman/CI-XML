<?php

class Schedule extends CI_Model {
	
	protected $xml = null;
	protected $days = array();
	protected $courses = null;
	protected $timeslots = null;
	
	public function __construct() {
		parent::__construct();

		$this->xml = simplexml_load_file(DATAPATH . 'schedule.xml');
		
		// create arrays for each propert
		$this->days = array();
		$this->courses = array();
		$this->timeslots = array();
		$daysoftheweek = array();
		//Days perspective
		foreach($this->xml->daysofweek->day as $day) {
			$dayBooking = array();
            foreach($day->dbooking as $b) {
                $booking = new Booking();
				$booking->course = $b->course->attributes()['num'];
				$booking->day = $day['name'];
				$booking->time = $b->time->attributes()['start'];
				$booking->time .= " - ";
				$booking->time .= $b->time->attributes()['end'];
				$booking->room = $b->room;
				$booking->type = $b->type;
				$booking->instructor = $b->instructor;
				array_push($dayBooking, $booking);
             }
			 array_push($this->days, $dayBooking);
            }	
		
		foreach($this->xml->courses->course as $course)
		{
			$courseBookings = array();
			foreach($course->cbooking as $c)
			{
				$booking = new Booking();
				$booking->course = $course->attributes()['num'];
				$booking->day = $c->day['name'];
				$booking->time = $c->time->attributes()['start'];
				$booking->time .= " - ";
				$booking->time .= $c->time->attributes()['end'];
				$booking->room = $c->room;
				$booking->type = $c->type;
				$booking->instructor = $c->instructor;
				array_push($courseBookings, $booking);
			}
			array_push($this->courses, $courseBookings);
		}
		
		foreach($this->xml->timeslots->slots as $slot)
		{
			$timeBookings = array();
			foreach($slot->tbooking as $t)
			{
				$booking = new Booking();
				$booking->course = $t->course->attributes()['num'];
				$booking->day = $t->day->attributes()['name'];
				$booking->time = $slot->time->attributes()['start'];
				$booking->time .= " - ";
				$booking->time .= $slot->time->attributes()['end'];
				$booking->room = $t->room;
				$booking->type = $t->type;
				$booking->instructor = $t->instructor;
				array_push($timeBookings, $booking);
			}
			array_push($this->timeslots, $timeBookings);
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
