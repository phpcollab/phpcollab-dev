<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class projects_members extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('projects_model');
		$this->load->model('projects_members_model');

		$this->storage_table = 'projects_members';
		$this->storage_fields = array();
	}
	public function index($prj_id) {
		$data = array();
		$data['prj'] = $this->projects_model->get_row($prj_id);
		if($data['prj']) {
			$this->my_library->set_title($this->lang->line('projects_members'));
			$content = $this->projects_members_model->get_index_list($data['prj']);
			$this->my_library->set_zone('content', $content);
		} else {
			redirect($this->my_url);
		}
	}
	public function create($prj_id) {
		$data = array();
		$data['prj'] = $this->projects_model->get_row($prj_id);
		if($data['prj']) {
			$this->my_library->set_title($this->lang->line('projects_members'));
			$this->load->library('form_validation');
			$data['dropdown_prj_id'] = $this->projects_members_model->dropdown_prj_id();
			$data['dropdown_mbr_id'] = $this->projects_members_model->dropdown_mbr_id();
			$this->form_validation->set_rules('mbr_id', 'lang:mbr_id', 'required|numeric');
			$this->form_validation->set_rules('prj_mbr_authorized', 'lang:prj_mbr_authorized', 'numeric');
			$this->form_validation->set_rules('prj_mbr_published', 'lang:prj_mbr_published', 'numeric');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('projects_members/projects_members_create', $data, TRUE);
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
				$this->db->set('prj_id', $prj_id);
				$this->db->set('mbr_id', $this->input->post('mbr_id'));
				$this->db->set('prj_mbr_authorized', checkbox2database($this->input->post('prj_mbr_authorized')));
				$this->db->set('prj_mbr_published', checkbox2database($this->input->post('prj_mbr_published')));
				$this->db->set('prj_mbr_datecreated', date('Y-m-d H:i:s'));
				$this->db->insert('projects_members');
				$prj_mbr_id = $this->db->insert_id();
				$this->read($prj_mbr_id);
			}
		} else {
			redirect($this->my_url);
		}
	}
	public function read($prj_mbr_id) {
		$data = array();
		$data['row'] = $this->projects_members_model->get_row($prj_mbr_id);
		if($data['row']) {
			$data['prj'] = $this->projects_model->get_row($data['row']->prj_id);
			if($data['prj']) {
				$this->my_library->set_title($this->lang->line('projects_members').' / '.$data['row']->prj_mbr_id);
				$content = $this->load->view('projects_members/projects_members_read', $data, TRUE);
				$this->my_library->set_zone('content', $content);
			} else {
				redirect($this->my_url);
			}
		} else {
			redirect($this->my_url);
		}
	}
	public function update($prj_mbr_id) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->projects_members_model->get_row($prj_mbr_id);
		if($data['row']) {
			$data['prj'] = $this->projects_model->get_row($data['row']->prj_id);
			if($data['prj']) {
				$this->my_library->set_title($this->lang->line('projects_members').' / '.$data['row']->prj_mbr_id);
				$data['dropdown_prj_id'] = $this->projects_members_model->dropdown_prj_id();
				$data['dropdown_mbr_id'] = $this->projects_members_model->dropdown_mbr_id();
				$this->form_validation->set_rules('prj_id', 'lang:prj_id', 'required|numeric');
				$this->form_validation->set_rules('mbr_id', 'lang:mbr_id', 'required|numeric');
				$this->form_validation->set_rules('prj_mbr_authorized', 'lang:prj_mbr_authorized', 'numeric');
				$this->form_validation->set_rules('prj_mbr_published', 'lang:prj_mbr_published', 'numeric');
				if($this->form_validation->run() == FALSE) {
					$content = $this->load->view('projects_members/projects_members_update', $data, TRUE);
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
					$this->db->set('prj_id', $this->input->post('prj_id'));
					$this->db->set('mbr_id', $this->input->post('mbr_id'));
					$this->db->set('prj_mbr_authorized', checkbox2database($this->input->post('prj_mbr_authorized')));
					$this->db->set('prj_mbr_published', checkbox2database($this->input->post('prj_mbr_published')));
					$this->db->where('prj_mbr_id', $prj_mbr_id);
					$this->db->update('projects_members');
					$this->read($prj_mbr_id);
				}
			} else {
				redirect($this->my_url);
			}
		} else {
			redirect($this->my_url);
		}
	}
	public function delete($prj_mbr_id) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->projects_members_model->get_row($prj_mbr_id);
		if($data['row']) {
			$data['prj'] = $this->projects_model->get_row($data['row']->prj_id);
			if($data['prj']) {
				$this->my_library->set_title($this->lang->line('projects_members').' / '.$data['row']->prj_mbr_id);
				$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
				if($this->form_validation->run() == FALSE) {
					$content = $this->load->view('projects_members/projects_members_delete', $data, TRUE);
					$this->my_library->set_zone('content', $content);
				} else {
					if(count($this->storage_fields) > 0) {
						foreach($this->storage_fields as $field) {
							if($data['row']->{$field} && file_exists('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field})) {
								unlink('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field});
							}
						}
					}
					$this->db->where('prj_mbr_id', $prj_mbr_id);
					$this->db->delete('projects_members');
					redirect($this->my_url.'projects/read/'.$data['row']->prj_id);
				}
			} else {
				redirect($this->my_url);
			}
		} else {
			redirect($this->my_url);
		}
	}
}
