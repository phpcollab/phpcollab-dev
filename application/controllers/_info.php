<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class _info extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function index() {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->my_library->set_title($this->lang->line('info'));

		$data = array();
		$content = $this->load->view('_info/_info_index', $data, TRUE);
		$this->my_library->set_zone('content', $content);
	}
	public function php() {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		phpinfo();
		exit(0);
	}
}
