<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Organizations extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('organizations_model');
		$this->load->model('projects_model');

		$this->storage_table = 'organizations';
		$this->storage_fields = array();
	}
	public function index() {
		$this->my_library->set_title($this->lang->line('organizations'));
		$content = $this->organizations_model->get_index_list();
		$this->my_library->set_zone('content', $content);
	}
	public function create() {
		$this->my_library->set_title($this->lang->line('organizations'));
		$this->load->library('form_validation');
		$data = array();
		$data['dropdown_org_owner'] = $this->organizations_model->dropdown_org_owner();
		$this->form_validation->set_rules('org_owner', 'lang:org_owner', 'required|numeric');
		$this->form_validation->set_rules('org_name', 'lang:org_name', 'required|max_length[255]');
		$this->form_validation->set_rules('org_description', 'lang:org_description', '');
		$this->form_validation->set_rules('org_comments', 'lang:org_comments', '');
		$this->form_validation->set_rules('org_authorized', 'lang:org_authorized', 'numeric');
		if($this->form_validation->run() == FALSE) {
			$content = $this->load->view('organizations/organizations_create', $data, TRUE);
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
			$this->db->set('org_owner', $this->input->post('org_owner'));
			$this->db->set('org_name', $this->input->post('org_name'));
			$this->db->set('org_description', $this->input->post('org_description'));
			$this->db->set('org_comments', $this->input->post('org_comments'));
			$this->db->set('org_authorized', checkbox2database($this->input->post('org_authorized')));
			$this->db->set('org_datecreated', date('Y-m-d H:i:s'));
			$this->db->insert('organizations');
			$org_id = $this->db->insert_id();
			$this->read($org_id);
		}
	}
	public function read($org_id) {
		$data = array();
		$data['row'] = $this->organizations_model->get_row($org_id);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('organizations').' / '.$data['row']->org_name);
			$content = $this->load->view('organizations/organizations_read', $data, TRUE);
			$content .= $this->projects_model->get_index_list(array('prj.org_id = \''.$org_id.'\''));
			$this->my_library->set_zone('content', $content);
		} else {
			$this->index();
		}
	}
	public function update($org_id) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->organizations_model->get_row($org_id);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('organizations').' / '.$data['row']->org_name);
			$data['dropdown_org_owner'] = $this->organizations_model->dropdown_org_owner();
			$this->form_validation->set_rules('org_owner', 'lang:org_owner', 'required|numeric');
			$this->form_validation->set_rules('org_name', 'lang:org_name', 'required|max_length[255]');
			$this->form_validation->set_rules('org_description', 'lang:org_description', '');
			$this->form_validation->set_rules('org_comments', 'lang:org_comments', '');
			$this->form_validation->set_rules('org_authorized', 'lang:org_authorized', 'numeric');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('organizations/organizations_update', $data, TRUE);
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
				$this->db->set('org_owner', $this->input->post('org_owner'));
				$this->db->set('org_name', $this->input->post('org_name'));
				$this->db->set('org_description', $this->input->post('org_description'));
				$this->db->set('org_comments', $this->input->post('org_comments'));
				$this->db->set('org_authorized', checkbox2database($this->input->post('org_authorized')));
				$this->db->where('org_id', $org_id);
				$this->db->update('organizations');
				$this->read($org_id);
			}
		} else {
			$this->index();
		}
	}
	public function delete($org_id) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->organizations_model->get_row($org_id);
		if($data['row']) {
			if($data['row']->org_system == 0) {
				$this->my_library->set_title($this->lang->line('organizations').' / '.$data['row']->org_name);
				$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
				if($this->form_validation->run() == FALSE) {
					$content = $this->load->view('organizations/organizations_delete', $data, TRUE);
					$this->my_library->set_zone('content', $content);
				} else {
					if(count($this->storage_fields) > 0) {
						foreach($this->storage_fields as $field) {
							if($data['row']->{$field} && file_exists('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field})) {
								unlink('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field});
							}
						}
					}
					$this->db->where('org_id', $org_id);
					$this->db->delete('organizations');
					$this->index();
				}
			} else {
				$this->index();
			}
		} else {
			$this->index();
		}
	}
}
