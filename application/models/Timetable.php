<?php

/**
 * This is a "CMS" model for quotes, but with bogus hard-coded data.
 * This would be considered a "mock database" model.
 *
 * @author jim
 */
class Timetable extends MY_Model {

	protected $xml = null;
	protected $daysofweek = array();
	protected $timeslots = array();
	protected $courses = array();

	public function __construct()
	{
		parent::__construct();
		$this->xml = simplexml_load_file(DATAPATH. 'schedule.xml');
	}
}