<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class trackers extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('trackers_model');
	}
	public function index() {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->my_library->set_title($this->lang->line('trackers'));
		$content = $this->trackers_model->get_index_list();
		$this->my_library->set_zone('content', $content);
	}
	public function create() {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->my_library->set_title($this->lang->line('trackers'));
		$this->load->library('form_validation');
		$data = array();
		$data['dropdown_trk_owner'] = $this->trackers_model->dropdown_trk_owner();
		$this->form_validation->set_rules('trk_owner', 'lang:trk_owner', 'required|numeric');
		$this->form_validation->set_rules('trk_name', 'lang:trk_name', 'required|max_length[255]');
		$this->form_validation->set_rules('tsk_description', 'lang:tsk_description', '');
		if($this->form_validation->run() == FALSE) {
			$content = $this->load->view('trackers/trackers_create', $data, TRUE);
			$this->my_library->set_zone('content', $content);
		} else {
			$this->db->set('trk_owner', $this->input->post('trk_owner'));
			$this->db->set('trk_name', $this->input->post('trk_name'));
			$this->db->set('tsk_description', $this->input->post('tsk_description'));
			$this->db->set('trk_datecreated', date('Y-m-d H:i:s'));
			$this->db->insert('trackers');
			$trk_id = $this->db->insert_id();

			redirect($this->my_url.'trackers/read/'.$trk_id);
		}
	}
	public function read($trk_id) {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$data = array();
		$data['row'] = $this->trackers_model->get_row($trk_id);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('trackers').' | '.$data['row']->trk_name);
			$content = $this->load->view('trackers/trackers_read', $data, TRUE);
			$this->my_library->set_zone('content', $content);
		} else {
			$this->index();
		}
	}
	public function update($trk_id) {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->trackers_model->get_row($trk_id);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('trackers').' | '.$data['row']->trk_name);
			$data['dropdown_trk_owner'] = $this->trackers_model->dropdown_trk_owner();
			$this->form_validation->set_rules('trk_owner', 'lang:trk_owner', 'required|numeric');
			$this->form_validation->set_rules('trk_name', 'lang:trk_name', 'required|max_length[255]');
			$this->form_validation->set_rules('tsk_description', 'lang:tsk_description', '');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('trackers/trackers_update', $data, TRUE);
				$this->my_library->set_zone('content', $content);
			} else {
				$this->db->set('trk_owner', $this->input->post('trk_owner'));
				$this->db->set('trk_name', $this->input->post('trk_name'));
				$this->db->set('tsk_description', $this->input->post('tsk_description'));
				$this->db->where('trk_id', $trk_id);
				$this->db->update('trackers');

				redirect($this->my_url.'trackers/read/'.$trk_id);
			}
		} else {
			$this->index();
		}
	}
	public function delete($trk_id) {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->trackers_model->get_row($trk_id);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('trackers').' | '.$data['row']->trk_name);
			$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('trackers/trackers_delete', $data, TRUE);
				$this->my_library->set_zone('content', $content);
			} else {
				$this->db->where('trk_id', $trk_id);
				$this->db->delete('trackers');
				$this->index();
			}
		} else {
			$this->index();
		}
	}
}
