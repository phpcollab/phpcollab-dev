<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class roles extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('roles_model');

		$this->storage_table = 'roles';
		$this->storage_fields = array();
	}
	public function index() {
		$this->my_library->set_title($this->lang->line('roles'));
		$content = $this->roles_model->get_index_list();
		$this->my_library->set_zone('content', $content);
	}
	public function create() {
		$this->my_library->set_title($this->lang->line('roles'));
		$this->load->library('form_validation');
		$data = array();
		$this->form_validation->set_rules('rol_code', 'lang:rol_code', 'required|max_length[255]');
		if($this->form_validation->run() == FALSE) {
			$content = $this->load->view('roles/roles_create', $data, TRUE);
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
			$this->db->set('rol_code', $this->input->post('rol_code'));
			$this->db->insert('roles');
			$rol_id = $this->db->insert_id();
			$this->read($rol_id);
		}
	}
	public function read($rol_id) {
		$data = array();
		$data['row'] = $this->roles_model->get_row($rol_id);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('roles').' / '.$data['row']->rol_code);
			$content = $this->load->view('roles/roles_read', $data, TRUE);
			$this->my_library->set_zone('content', $content);
		} else {
			$this->index();
		}
	}
	public function update($rol_id) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->roles_model->get_row($rol_id);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('roles').' / '.$data['row']->rol_code);
			$this->form_validation->set_rules('rol_code', 'lang:rol_code', 'required|max_length[255]');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('roles/roles_update', $data, TRUE);
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
				$this->db->set('rol_code', $this->input->post('rol_code'));
				$this->db->where('rol_id', $rol_id);
				$this->db->update('roles');
				$this->read($rol_id);
			}
		} else {
			$this->index();
		}
	}
	public function delete($rol_id) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->roles_model->get_row($rol_id);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('roles').' / '.$data['row']->rol_code);
			$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('roles/roles_delete', $data, TRUE);
				$this->my_library->set_zone('content', $content);
			} else {
				if(count($this->storage_fields) > 0) {
					foreach($this->storage_fields as $field) {
						if($data['row']->{$field} && file_exists('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field})) {
							unlink('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field});
						}
					}
				}
				$this->db->where('rol_id', $rol_id);
				$this->db->delete('roles');
				$this->index();
			}
		} else {
			$this->index();
		}
	}
}
