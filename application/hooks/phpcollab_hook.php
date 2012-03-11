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

		if($this->CI->session->userdata('id')) {
			$this->CI->member = $this->CI->phpcollab_model->get_member($this->CI->session->userdata('id'));
			$this->CI->permissions = $this->CI->phpcollab_model->get_permissions($this->CI->member->profil);
			$this->CI->db->set('connected', date('U'));
			$this->CI->db->where('login', $this->CI->member->login);
			$this->CI->db->update('logs');
		} else {
			if($this->CI->uri->segment(1) != 'login' && $this->CI->uri->segment(1) != 'license') {
				redirect('login');
			}
		}
	}
	public function post_controller() {
		$this->CI =& get_instance();
		$output = array();
		$output['zones'] = $this->CI->zones;
		$this->CI->load->view('_template', $output, 'true');
	}
}
