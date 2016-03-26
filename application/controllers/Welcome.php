<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Schedule');
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		/*
		Note, searching not implemented so displaying all tables
		as proof of concept.
		*/
		$result = '';
		// display all bookings by days of week
		foreach($this->Schedule->getDaysOfWeek() as $row)
		{ 
			foreach ($row as $booking)
			{
				$result .= $this->parser->parse('booking_row', $booking, true);
			}
		}
		// display all  bookings by course number
		foreach($this->Schedule->getCourses() as $row)
		{ 
			foreach ($row as $booking)
			{
				$result .= $this->parser->parse('booking_row', $booking, true);
			}
		}
		// display all bookings by timeslot
		foreach($this->Schedule->getTimeslots() as $row)
		{ 
			foreach ($row as $booking)
			{
				$result .= $this->parser->parse('booking_row', $booking, true);
			}
		}
		$result = $this->parser->parse('booking_table', array('rows'=> $result), true);
		$this->parser->parse('template', array('content' => $result, 'page_title' => 'Schedule'));
	}
}
