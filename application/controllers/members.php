<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class members extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('members_model');

		$this->storage_table = 'members';
		$this->storage_fields = array();
	}
	public function index() {
		if(!$this->auth_library->permission('members/index')) {
			redirect($this->my_url);
		}

		$this->my_library->set_title($this->lang->line('members'));
		$content = $this->members_model->get_index_list();
		$this->my_library->set_zone('content', $content);
	}
	public function create() {
		if(!$this->auth_library->permission('members/index')) {
			redirect($this->my_url);
		}

		$this->my_library->set_title($this->lang->line('members'));
		$this->load->library('form_validation');
		$data = array();
		$data['dropdown_org_id'] = $this->members_model->dropdown_org_id();
		$this->form_validation->set_rules('org_id', 'lang:org_id', 'required|numeric');
		$this->form_validation->set_rules('mbr_name', 'lang:mbr_name', 'required|max_length[255]');
		$this->form_validation->set_rules('mbr_description', 'lang:mbr_description', '');
		$this->form_validation->set_rules('mbr_email', 'lang:mbr_email', 'required|valid_email|max_length[255]|callback_email');
		$this->form_validation->set_rules('mbr_password', 'lang:mbr_password', 'required');
		$this->form_validation->set_rules('mbr_password_confirm', 'lang:mbr_password_confirm', 'required|matches[mbr_password]');
		$this->form_validation->set_rules('mbr_authorized', 'lang:mbr_authorized', 'numeric');
		$this->form_validation->set_rules('mbr_comments', 'lang:mbr_comments', '');
		if($this->form_validation->run() == FALSE) {
			$content = $this->load->view('members/members_create', $data, TRUE);
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
			$this->db->set('org_id', $this->input->post('org_id'));
			$this->db->set('mbr_name', $this->input->post('mbr_name'));
			$this->db->set('mbr_description', $this->input->post('mbr_description'));
			$this->db->set('mbr_email', $this->input->post('mbr_email'));
			$this->db->set('mbr_password', $this->auth_library->salt_password($this->input->post('mbr_password')));
			$this->db->set('mbr_authorized', checkbox2database($this->input->post('mbr_authorized')));
			$this->db->set('mbr_comments', $this->input->post('mbr_comments'));
			$this->db->set('mbr_datecreated', date('Y-m-d H:i:s'));
			$this->db->insert('members');
			$mbr_id = $this->db->insert_id();
			$this->read($mbr_id);
		}
	}
	public function read($mbr_id) {
		if(!$this->auth_library->permission('members/index')) {
			redirect($this->my_url);
		}

		$data = array();
		$data['row'] = $this->members_model->get_row($mbr_id);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('members').' / '.$data['row']->mbr_name);
			$content = $this->load->view('members/members_read', $data, TRUE);
			$this->my_library->set_zone('content', $content);
		} else {
			$this->index();
		}
	}
	public function update($mbr_id) {
		if(!$this->auth_library->permission('members/index')) {
			redirect($this->my_url);
		}

		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->members_model->get_row($mbr_id);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('members').' / '.$data['row']->mbr_name);
			$data['dropdown_org_id'] = $this->members_model->dropdown_org_id();
			$this->form_validation->set_rules('org_id', 'lang:org_id', 'required|numeric');
			$this->form_validation->set_rules('mbr_name', 'lang:mbr_name', 'required|max_length[255]');
			$this->form_validation->set_rules('mbr_description', 'lang:mbr_description', '');
			$this->form_validation->set_rules('mbr_email', 'lang:mbr_email', 'required|valid_email|max_length[255]|callback_email');
			$this->form_validation->set_rules('mbr_password', 'lang:mbr_password', '');
			$this->form_validation->set_rules('mbr_password_confirm', 'lang:mbr_password_confirm', 'matches[mbr_password]');
			$this->form_validation->set_rules('mbr_authorized', 'lang:mbr_authorized', 'numeric');
			$this->form_validation->set_rules('mbr_comments', 'lang:mbr_comments', '');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('members/members_update', $data, TRUE);
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
				$this->db->set('org_id', $this->input->post('org_id'));
				$this->db->set('mbr_name', $this->input->post('mbr_name'));
				$this->db->set('mbr_description', $this->input->post('mbr_description'));
				$this->db->set('mbr_email', $this->input->post('mbr_email'));
				if($this->input->post('mbr_password') != '') {
					$this->db->set('mbr_password', $this->auth_library->salt_password($this->input->post('mbr_password')));
				}
				if($data['row']->mbr_id != $this->phpcollab_member->mbr_id) {
					$this->db->set('mbr_authorized', checkbox2database($this->input->post('mbr_authorized')));
				}
				$this->db->set('mbr_comments', $this->input->post('mbr_comments'));
				$this->db->set('mbr_datemodified', date('Y-m-d H:i:s'));
				$this->db->where('mbr_id', $mbr_id);
				$this->db->update('members');
				$this->read($mbr_id);
			}
		} else {
			$this->index();
		}
	}
	public function delete($mbr_id) {
		if(!$this->auth_library->permission('members/index')) {
			redirect($this->my_url);
		}

		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->members_model->get_row($mbr_id);
		if($data['row']) {
			if($data['row']->mbr_id != $this->phpcollab_member->mbr_id) {
				$this->my_library->set_title($this->lang->line('members').' / '.$data['row']->mbr_name);
				$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
				if($this->form_validation->run() == FALSE) {
					$content = $this->load->view('members/members_delete', $data, TRUE);
					$this->my_library->set_zone('content', $content);
				} else {
					if(count($this->storage_fields) > 0) {
						foreach($this->storage_fields as $field) {
							if($data['row']->{$field} && file_exists('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field})) {
								unlink('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field});
							}
						}
					}
					$this->db->where('mbr_id', $mbr_id);
					$this->db->delete('members');
					$this->index();
				}
			} else {
				$this->index();
			}
		} else {
			$this->index();
		}
	}
	public function email() {
		if($this->input->post('mbr_email') && $this->router->method == 'create') {
			$query = $this->db->query('SELECT mbr.* FROM '.$this->db->dbprefix('members').' AS mbr WHERE mbr.mbr_email = ? GROUP BY mbr.mbr_id', array($this->input->post('mbr_email')));
			if($query->num_rows() > 0) {
				$this->form_validation->set_message('email', $this->lang->line('already_exists'));
				return FALSE;
			} else {
				return TRUE;
			}
		}
		if($this->input->post('mbr_email') && $this->input->post('mbr_email_old') && $this->router->method == 'update') {
			$query = $this->db->query('SELECT mbr.* FROM '.$this->db->dbprefix('members').' AS mbr WHERE mbr.mbr_email = ? AND mbr.mbr_email != ? GROUP BY mbr.mbr_id', array($this->input->post('mbr_email'), $this->input->post('mbr_email_old')));
			if($query->num_rows() > 0) {
				$this->form_validation->set_message('email', $this->lang->line('already_exists'));
				return FALSE;
			} else {
				return TRUE;
			}
		}
		return FALSE;
	}
}
