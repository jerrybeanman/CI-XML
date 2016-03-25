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
		//$this->load->view('welcome_message');
		$result = '';
		foreach($this->Schedule->getDaysOfWeek() as $row)
		{ 
			$result .= $this->parser->parse('booking_row', (array) $row, true);
		}
		$result = $this->parser->parse('booking_table', array('rows'=> $result), true);
		$this->parser->parse('template', array('content' => $result, 'page_title' => 'Schedule'));
	}
}
