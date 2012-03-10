<?php
if(!defined('BASEPATH')) {
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

class phpcollab_hook {
	public function post_controller_constructor() {
		$this->CI =& get_instance();
		$this->CI->lng = new stdClass();
		$this->CI->lng->lng_code = 'en';
		$this->CI->lay = new stdClass();
		$this->CI->lay->lay_type = 'text/html';
	}
	public function post_controller() {
		$this->CI =& get_instance();
		$output = array();
		$output['zones'] = $this->CI->zones;
		$this->CI->load->view('_template', $output, 'true');
	}
}
