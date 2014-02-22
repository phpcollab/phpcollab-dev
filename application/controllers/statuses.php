<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class statuses extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('statuses_model');

		$this->storage_table = 'statuses';
		$this->storage_fields = array();
	}
	public function index() {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->my_library->set_title($this->lang->line('statuses'));
		$content = $this->statuses_model->get_index_list();
		$this->my_library->set_zone('content', $content);
	}
	public function create() {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->my_library->set_title($this->lang->line('statuses'));
		$this->load->library('form_validation');
		$data = array();
		$data['dropdown_stu_owner'] = $this->statuses_model->dropdown_stu_owner();
		$this->form_validation->set_rules('stu_owner', 'lang:stu_owner', 'required|numeric');
		$this->form_validation->set_rules('stu_name', 'lang:stu_name', 'required|max_length[255]');
		$this->form_validation->set_rules('stu_isclosed', 'lang:stu_isclosed', 'numeric');
		$this->form_validation->set_rules('stu_ordering', 'lang:stu_ordering', 'required|numeric');
		if($this->form_validation->run() == FALSE) {
			$content = $this->load->view('statuses/statuses_create', $data, TRUE);
			$this->my_library->set_zone('content', $content);
		} else {
			if(count($this->storage_fields) > 0) {
				foreach($this->storage_fields as $field) {
					$config = array();
					$config['allowed_types'] = 'gif|jpg|png';
					$config['encrypt_name'] = true;
					$config['upload_path'] = './storage/'.$this->storage_table.'/'.$field;
					$this->upload->initialize($config);
					if($this->upload->do_upload($field)) {
						$upload = $this->upload->data();
						$this->db->set($field, $upload['file_name']);
					}
				}
			}
			$this->db->set('stu_owner', $this->input->post('stu_owner'));
			$this->db->set('stu_name', $this->input->post('stu_name'));
			$this->db->set('stu_isclosed', checkbox2database($this->input->post('stu_isclosed')));
			$this->db->set('stu_ordering', $this->input->post('stu_ordering'));
			$this->db->set('stu_datecreated', date('Y-m-d H:i:s'));
			$this->db->insert('statuses');
			$stu_id = $this->db->insert_id();
			$this->read($stu_id);
		}
	}
	public function read($stu_id) {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$data = array();
		$data['row'] = $this->statuses_model->get_row($stu_id);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('statuses').' / '.$data['row']->stu_name);
			$content = $this->load->view('statuses/statuses_read', $data, TRUE);
			$this->my_library->set_zone('content', $content);
		} else {
			$this->index();
		}
	}
	public function update($stu_id) {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->statuses_model->get_row($stu_id);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('statuses').' / '.$data['row']->stu_name);
			$data['dropdown_stu_owner'] = $this->statuses_model->dropdown_stu_owner();
			$this->form_validation->set_rules('stu_owner', 'lang:stu_owner', 'required|numeric');
			$this->form_validation->set_rules('stu_name', 'lang:stu_name', 'required|max_length[255]');
			$this->form_validation->set_rules('stu_isclosed', 'lang:stu_isclosed', 'numeric');
			$this->form_validation->set_rules('stu_ordering', 'lang:stu_ordering', 'required|numeric');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('statuses/statuses_update', $data, TRUE);
				$this->my_library->set_zone('content', $content);
			} else {
				if(count($this->storage_fields) > 0) {
					foreach($this->storage_fields as $field) {
						$config = array();
						$config['allowed_types'] = 'gif|jpg|png';
						$config['encrypt_name'] = true;
						$config['upload_path'] = './storage/'.$this->storage_table.'/'.$field;
						$this->upload->initialize($config);
						if($this->upload->do_upload($field)) {
							if($data['row']->{$field} && file_exists('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field})) {
								unlink('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field});
							}
							$upload = $this->upload->data();
							$this->db->set($field, $upload['file_name']);
						}
					}
				}
				$this->db->set('stu_owner', $this->input->post('stu_owner'));
				$this->db->set('stu_name', $this->input->post('stu_name'));
				$this->db->set('stu_isclosed', checkbox2database($this->input->post('stu_isclosed')));
				$this->db->set('stu_ordering', $this->input->post('stu_ordering'));
				$this->db->where('stu_id', $stu_id);
				$this->db->update('statuses');
				$this->read($stu_id);
			}
		} else {
			$this->index();
		}
	}
	public function delete($stu_id) {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->statuses_model->get_row($stu_id);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('statuses').' / '.$data['row']->stu_name);
			$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('statuses/statuses_delete', $data, TRUE);
				$this->my_library->set_zone('content', $content);
			} else {
				if(count($this->storage_fields) > 0) {
					foreach($this->storage_fields as $field) {
						if($data['row']->{$field} && file_exists('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field})) {
							unlink('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field});
						}
					}
				}
				$this->db->where('stu_id', $stu_id);
				$this->db->delete('statuses');
				$this->index();
			}
		} else {
			$this->index();
		}
	}
}
