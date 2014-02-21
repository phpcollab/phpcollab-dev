<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	public function index() {
		$data = array();
		$content = $this->load->view('home/home_index', $data, TRUE);
		$this->my_library->set_zone('content', $content);
	}
}
