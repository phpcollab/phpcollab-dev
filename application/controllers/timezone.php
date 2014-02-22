<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Timezone extends CI_Controller {
	public function index() {
		$content = array();

		if($this->input->is_ajax_request()) {
			$this->my_library->set_template('template_json');
			$this->my_library->set_content_type('application/json');

			$this->session->set_userdata('timezone', $this->input->post('timezone'));
		} else {
			$this->output->set_status_header(403);
		}
		$this->my_library->set_zone('content', $content);
	}
}
