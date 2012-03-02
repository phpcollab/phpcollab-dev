<?php
if(!defined('BASEPATH')) {
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

class welcome extends CI_Controller {
	public function index() {
		redirect('home');
	}
}
