<?php
if(!defined('BASEPATH')) {
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

class home extends CI_Controller {
	public function index() {
		$data = array();
		$this->zones['content'] = $this->load->view('home_index', $data, true);
	}
}
