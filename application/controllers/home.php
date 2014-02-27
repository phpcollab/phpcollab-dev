<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('projects_model');
		$this->load->model('tasks_model');
		$this->load->model('notes_model');
	}
	public function index() {
		$data = array();
		$content = $this->load->view('home/home_index', $data, TRUE);
		$this->my_library->set_zone('content', $content);
	}
}
