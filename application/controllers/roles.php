<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class roles extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('roles_model');

		$this->storage_table = 'roles';
		$this->storage_fields = array();
	}
	public function index() {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->my_library->set_title($this->lang->line('roles'));
		$content = $this->roles_model->get_index_list();
		$this->my_library->set_zone('content', $content);
	}
	public function create() {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->my_library->set_title($this->lang->line('roles'));
		$this->load->library('form_validation');
		$data = array();
		$this->form_validation->set_rules('rol_code', 'lang:rol_code', 'required|max_length[255]|callback_code');
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

			redirect($this->my_url.'roles/read/'.$rol_id);
		}
	}
	public function read($rol_id) {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$data = array();
		$data['row'] = $this->roles_model->get_row($rol_id);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('roles').' / '.$data['row']->rol_code);

			$query = $this->db->query('SELECT per.*, IF(rol_per.rol_per_id IS NOT NULL, 1, 0) AS per_saved FROM '.$this->db->dbprefix('permissions').' AS per LEFT JOIN '.$this->db->dbprefix('roles_permissions').' AS rol_per ON rol_per.per_id = per.per_id AND rol_per.rol_id = ? GROUP BY per.per_id ORDER BY per.per_code ASC', array($rol_id));
			$data['permissions'] = $query->result();
			$data['permissions_limit'] = ceil(count($data['permissions'])/3);

			$content = $this->load->view('roles/roles_read', $data, TRUE);
			$this->my_library->set_zone('content', $content);
		} else {
			$this->index();
		}
	}
	public function update($rol_id) {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->roles_model->get_row($rol_id);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('roles').' / '.$data['row']->rol_code);

			$query = $this->db->query('SELECT per.*, IF(rol_per.rol_per_id IS NOT NULL, 1, 0) AS per_saved FROM '.$this->db->dbprefix('permissions').' AS per LEFT JOIN '.$this->db->dbprefix('roles_permissions').' AS rol_per ON rol_per.per_id = per.per_id AND rol_per.rol_id = ? WHERE per.per_code NOT LIKE ? AND per.per_code NOT LIKE ? GROUP BY per.per_id ORDER BY per.per_code ASC', array($rol_id, 'roles/%', 'members/%'));
			$data['permissions'] = $query->result();
			foreach($data['permissions'] as $per) {
				$this->form_validation->set_rules('per_'.$per->per_id, $per->per_code);
			}
			$data['permissions_limit'] = ceil(count($data['permissions'])/3);

			if($data['row']->rol_system == 0) {
				$this->form_validation->set_rules('rol_code', 'lang:rol_code', 'required|max_length[255]|callback_code');
			}
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('roles/roles_update', $data, TRUE);
				$this->my_library->set_zone('content', $content);
			} else {
				if($data['row']->rol_system == 0) {
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
				}

				foreach($data['permissions'] as $per) {
					if($per->per_saved == 0 && $this->input->post('per_'.$per->per_id)) {
						$this->db->set('per_id', $per->per_id);
						$this->db->set('rol_id', $rol_id);
						$this->db->set('rol_per_datecreated', date('Y-m-d H:i:s'));
						$this->db->insert('roles_permissions');
					}
					if($per->per_saved == 1 && !$this->input->post('per_'.$per->per_id)) {
						$this->db->where('per_id', $per->per_id);
						$this->db->where('rol_id', $rol_id);
						$this->db->delete('roles_permissions');
					}
				}

				redirect($this->my_url.'roles/read/'.$rol_id);
			}
		} else {
			$this->index();
		}
	}
	public function delete($rol_id) {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->roles_model->get_row($rol_id);
		if($data['row']) {
			if($data['row']->rol_system == 0) {
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

					$this->db->where('rol_id', $rol_id);
					$this->db->delete('members_roles');

					$this->db->where('rol_id', $rol_id);
					$this->db->delete('roles_permissions');

					$this->index();
				}
			} else {
				$this->index();
			}
		} else {
			$this->index();
		}
	}
	public function code() {
		if($this->input->post('rol_code') && $this->router->method == 'create') {
			$query = $this->db->query('SELECT rol.* FROM '.$this->db->dbprefix('roles').' AS rol WHERE rol.rol_code = ? GROUP BY rol.rol_id', array($this->input->post('rol_code')));
			if($query->num_rows() > 0) {
				$this->form_validation->set_message('code', $this->lang->line('already_exists'));
				return FALSE;
			} else {
				return TRUE;
			}
		}
		if($this->input->post('rol_code') && $this->input->post('rol_code_old') && $this->router->method == 'update') {
			$query = $this->db->query('SELECT rol.* FROM '.$this->db->dbprefix('roles').' AS rol WHERE rol.rol_code = ? AND rol.rol_code != ? GROUP BY rol.rol_id', array($this->input->post('rol_code'), $this->input->post('rol_code_old')));
			if($query->num_rows() > 0) {
				$this->form_validation->set_message('code', $this->lang->line('already_exists'));
				return FALSE;
			} else {
				return TRUE;
			}
		}
		return FALSE;
	}
}
