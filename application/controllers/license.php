<?php
if(!defined('BASEPATH')) {
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

class license extends CI_Controller {
	public function index() {
		$this->zones['content'] = $this->load->view('license_index', null, true);
	}
}
