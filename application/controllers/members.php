<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class members extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('members_model');
		$this->load->model('roles_model');
	}
	public function index() {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->my_library->set_title($this->lang->line('members'));
		$content = $this->members_model->get_index_list();
		$this->my_library->set_zone('content', $content);
	}
	public function create() {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->my_library->set_title($this->lang->line('members').' / '.$this->lang->line('create'));
		$this->load->library('form_validation');
		$data = array();
		$data['dropdown_org_id'] = $this->members_model->dropdown_org_id();
		$query = $this->db->query('SELECT rol.* FROM '.$this->db->dbprefix('roles').' AS rol GROUP BY rol.rol_id ORDER BY rol.rol_code ASC');
		$data['roles'] = $query->result();
		foreach($data['roles'] as $rol) {
			$this->form_validation->set_rules('rol_'.$rol->rol_id, $rol->rol_code);
		}
		$this->form_validation->set_rules('org_id', 'lang:organization', 'required|numeric');
		$this->form_validation->set_rules('mbr_name', 'lang:mbr_name', 'required|max_length[255]');
		$this->form_validation->set_rules('mbr_description', 'lang:mbr_description', '');
		$this->form_validation->set_rules('mbr_email', 'lang:mbr_email', 'required|valid_email|max_length[255]|callback_email');
		$this->form_validation->set_rules('mbr_password', 'lang:mbr_password', 'required');
		$this->form_validation->set_rules('mbr_password_confirm', 'lang:mbr_password_confirm', 'required|matches[mbr_password]');
		$this->form_validation->set_rules('mbr_authorized', 'lang:mbr_authorized', 'numeric');
		if($this->form_validation->run() == FALSE) {
			$content = $this->load->view('members/members_create', $data, TRUE);
			$this->my_library->set_zone('content', $content);
		} else {
			$this->db->set('org_id', $this->input->post('org_id'));
			$this->db->set('mbr_name', $this->input->post('mbr_name'));
			$this->db->set('mbr_description', $this->input->post('mbr_description'));
			$this->db->set('mbr_email', $this->input->post('mbr_email'));
			$this->db->set('mbr_password', $this->auth_library->salt_password($this->input->post('mbr_password')));
			$this->db->set('mbr_authorized', checkbox2database($this->input->post('mbr_authorized')));
			$this->db->set('mbr_datecreated', date('Y-m-d H:i:s'));
			$this->db->insert('members');
			$mbr_id = $this->db->insert_id();

			foreach($data['roles'] as $rol) {
				if($this->input->post('rol_'.$rol->rol_id)) {
					$this->db->set('rol_id', $rol->rol_id);
					$this->db->set('mbr_id', $mbr_id);
					$this->db->set('mbr_rol_datecreated', date('Y-m-d H:i:s'));
					$this->db->insert('members_roles');
				}
			}

			redirect($this->my_url.'members/read/'.$mbr_id);
		}
	}
	public function read($mbr_id) {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$data = array();
		$data['row'] = $this->members_model->get_row($mbr_id);
		if($data['row']) {
			$this->my_library->set_title($data['row']->mbr_name);
			$content = $this->load->view('members/members_read', $data, TRUE);
			$content .= $this->my_model->get_logs('member', $mbr_id);
			$this->my_library->set_zone('content', $content);
		} else {
			$this->index();
		}
	}
	public function update($mbr_id) {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->members_model->get_row($mbr_id);
		if($data['row']) {
			$this->my_library->set_title($data['row']->mbr_name);
			$data['dropdown_org_id'] = $this->members_model->dropdown_org_id();
			if($data['row']->mbr_id != $this->phpcollab_member->mbr_id) {
				$query = $this->db->query('SELECT rol.*, IF(mbr_rol.mbr_rol_id IS NOT NULL, 1, 0) AS rol_saved FROM '.$this->db->dbprefix('roles').' AS rol LEFT JOIN '.$this->db->dbprefix('members_roles').' AS mbr_rol ON mbr_rol.rol_id = rol.rol_id AND mbr_rol.mbr_id = ? GROUP BY rol.rol_id ORDER BY rol.rol_code ASC', array($mbr_id));
			} else {
				$query = $this->db->query('SELECT rol.*, IF(mbr_rol.mbr_rol_id IS NOT NULL, 1, 0) AS rol_saved FROM '.$this->db->dbprefix('roles').' AS rol LEFT JOIN '.$this->db->dbprefix('members_roles').' AS mbr_rol ON mbr_rol.rol_id = rol.rol_id AND mbr_rol.mbr_id = ? WHERE rol.rol_id != ? GROUP BY rol.rol_id ORDER BY rol.rol_code ASC', array($mbr_id, 1));
			}
			$data['roles'] = $query->result();
			foreach($data['roles'] as $rol) {
				$this->form_validation->set_rules('rol_'.$rol->rol_id, $rol->rol_code);
			}
			$this->form_validation->set_rules('org_id', 'lang:organization', 'required|numeric');
			$this->form_validation->set_rules('mbr_name', 'lang:mbr_name', 'required|max_length[255]');
			$this->form_validation->set_rules('mbr_description', 'lang:mbr_description', '');
			$this->form_validation->set_rules('mbr_email', 'lang:mbr_email', 'required|valid_email|max_length[255]|callback_email');
			$this->form_validation->set_rules('mbr_password', 'lang:mbr_password', '');
			$this->form_validation->set_rules('mbr_password_confirm', 'lang:mbr_password_confirm', 'matches[mbr_password]');
			$this->form_validation->set_rules('mbr_authorized', 'lang:mbr_authorized', 'numeric');
			$this->form_validation->set_rules('log_comments', 'lang:log_comments', '');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('members/members_update', $data, TRUE);
				$this->my_library->set_zone('content', $content);
			} else {
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
				$this->db->where('mbr_id', $mbr_id);
				$this->db->update('members');

				$additional = array();
				foreach($data['roles'] as $rol) {
					if($rol->rol_saved == 0 && $this->input->post('rol_'.$rol->rol_id)) {
						$additional[] = array('field' => 'rol_id', 'old' => '', 'new' => $rol->rol_id);

						$this->db->set('rol_id', $rol->rol_id);
						$this->db->set('mbr_id', $mbr_id);
						$this->db->set('mbr_rol_datecreated', date('Y-m-d H:i:s'));
						$this->db->insert('members_roles');
					}
					if($rol->rol_saved == 1 && !$this->input->post('rol_'.$rol->rol_id)) {
						$additional[] = array('field' => 'rol_id', 'old' => $rol->rol_id, 'new' => '');

						$this->db->where('rol_id', $rol->rol_id);
						$this->db->where('mbr_id', $mbr_id);
						$this->db->delete('members_roles');
					}
				}

				$this->my_model->save_log('member', $mbr_id, $data['row'], $additional);

				redirect($this->my_url.'members/read/'.$mbr_id);
			}
		} else {
			$this->index();
		}
	}
	public function delete($mbr_id) {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->members_model->get_row($mbr_id);
		if($data['row']) {
			if($data['row']->mbr_id != $this->phpcollab_member->mbr_id) {
				$this->my_library->set_title($data['row']->mbr_name);
				$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
				if($this->form_validation->run() == FALSE) {
					$content = $this->load->view('members/members_delete', $data, TRUE);
					$this->my_library->set_zone('content', $content);
				} else {
					$this->db->where('mbr_id', $mbr_id);
					$this->db->delete('members');

					$this->db->where('mbr_id', $mbr_id);
					$this->db->delete('members_roles');

					$this->db->where('mbr_id', $mbr_id);
					$this->db->delete('projects_members');

					$this->db->where('mbr_id', $mbr_id);
					$this->db->delete('members_notifications');

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
	public function statistics() {
		$data = array();
		$this->my_library->set_title($this->lang->line('members'));

		$data['tables'] = '';

		$legend = array();
		$values = array();
		$query = $this->db->query('SELECT org.org_name AS ref, org.org_id AS id, COUNT(DISTINCT(mbr.mbr_id)) AS nb FROM '.$this->db->dbprefix('members').' AS mbr LEFT JOIN '.$this->db->dbprefix('organizations').' AS org ON org.org_id = mbr.org_id GROUP BY ref ORDER BY nb DESC');
		if($query->num_rows() > 0) {
			$current_month = date('Y-m');
			foreach($query->result() as $row) {
				$legend[] = '<a href="'.$this->my_url.'organizations/statistics/'.$row->id.'">'.$row->ref.'</a>';
				$values[] = $row->nb;
			}
		}
		$data['tables'] .= build_table_repartition($this->lang->line('organization'), $values, $legend);

		$legend = array();
		$values = array();
		$query = $this->db->query('SELECT SUBSTRING(mbr.mbr_datecreated, 1, 7) AS ref, COUNT(DISTINCT(mbr.mbr_id)) AS nb FROM '.$this->db->dbprefix('members').' AS mbr GROUP BY ref ORDER BY ref DESC');
		if($query->num_rows() > 0) {
			$current_month = date('Y-m');
			foreach($query->result() as $row) {
				$legend[] = $row->ref;
				$values[] = $row->nb;
			}
		}
		$data['tables'] .= build_table_progression($this->lang->line('mbr_datecreated'), $values, $legend);

		$legend = array();
		$values = array();
		$query = $this->db->query('SELECT mbr.mbr_authorized AS ref, COUNT(DISTINCT(mbr.mbr_id)) AS nb FROM '.$this->db->dbprefix('members').' AS mbr GROUP BY ref ORDER BY nb DESC');
		if($query->num_rows() > 0) {
			$current_month = date('Y-m');
			foreach($query->result() as $row) {
				$legend[] = $this->lang->line('reply_'.$row->ref);
				$values[] = $row->nb;
			}
		}
		$data['tables'] .= build_table_repartition($this->lang->line('mbr_authorized'), $values, $legend);

		$legend = array();
		$values = array();
		$query = $this->db->query('SELECT SUBSTRING(mbr.mbr_email, LOCATE(\'@\', mbr.mbr_email) + 1) AS ref, COUNT(DISTINCT(mbr.mbr_id)) AS nb FROM '.$this->db->dbprefix('members').' AS mbr GROUP BY ref ORDER BY nb DESC');
		if($query->num_rows() > 0) {
			$current_month = date('Y-m');
			foreach($query->result() as $row) {
				$legend[] = $row->ref;
				$values[] = $row->nb;
			}
		}
		$data['tables'] .= build_table_repartition($this->lang->line('mbr_email'), $values, $legend);

		$content = $this->load->view('members/members_statistics', $data, TRUE);
		$this->my_library->set_zone('content', $content);
	}
}
