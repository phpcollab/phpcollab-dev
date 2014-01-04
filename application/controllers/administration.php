<?php
if(!defined('BASEPATH')) {
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

class administration extends CI_Controller {
	public function index() {
		$data = array();
		$this->zones['content'] = $this->load->view('administration/administration_index', $data, true);
	}
	public function permissions() {
		$this->load->helper(array('form'));

		$filters = array();
		$filters['permissions_per_code'] = array('per.per_code', 'like');
		$flt = build_filters($filters);

		$columns = array();
		$columns[] = 'per.per_id';
		$columns[] = 'per.per_code';
		$col = build_columns('permissions', $columns, 'per.per_code', 'ASC');

		$results = $this->phpcollab_model->get_permissions_count($flt);
		$build_pagination = $this->phpcollab_library->build_pagination($results->count, 20, 'permissions');

		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->phpcollab_model->get_permissions_limit($flt, $build_pagination['limit'], $build_pagination['start'], 'permissions');
		$data['permissions_roles'] = $this->phpcollab_model->get_permissions_roles($flt);
		$data['roles'] = $this->phpcollab_model->get_roles();

		if($this->input->post('submit_roles')) {
			foreach($data['results'] as $result) {
				foreach($data['roles'] as $rol_id => $rol_title) {
					if(isset($data['permissions_roles'][$result->per_id][$rol_id]) == 1 && !$this->input->post($result->per_id.$rol_id)) {
						$this->db->where('per_id', $result->per_id);
						$this->db->where('rol_id', $rol_id);
						$this->db->delete('permissions_roles');
						unset($data['permissions_roles'][$result->per_id][$rol_id]);
					} else if(isset($data['permissions_roles'][$result->per_id][$rol_id]) == 0 && $this->input->post($result->per_id.$rol_id)) {
						$this->db->set('per_id', $result->per_id);
						$this->db->set('rol_id', $rol_id);
						$this->db->insert('permissions_roles');
						$data['permissions_roles'][$result->per_id][$rol_id] = 1;
					}
				}
			}
		}

		$this->zones['content'] = $this->load->view('administration/administration_permissions', $data, true);
	}
	public function system_information() {
		$data = array();
		$this->zones['content'] = $this->load->view('administration/administration_sysinfo', $data, true);
	}
	public function company_details() {
		$this->load->library('form_validation');

		$data = array();
		$data['org'] = $this->phpcollab_model->get_organization(1);

		$this->form_validation->set_rules('name', 'lang:name', 'required|max_length[255]');
		$this->form_validation->set_rules('address1', 'lang:address', 'max_length[255]');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('administration/administration_company', $data, true);
		} else {
			$this->db->set('name', $this->input->post('name'));
			$this->db->set('address1', $this->input->post('address1'));
			$this->db->where('id', 1);
			$this->db->update('organizations');
			$this->index();
		}
	}
	public function logs() {
		$filters = array();
		$filters['logs_login'] = array('log.login', 'like');
		$flt = build_filters($filters);

		$columns = array();
		$columns[] = 'log.id';
		$columns[] = 'log.login';
		$columns[] = 'log.ip';
		$columns[] = 'log.session';
		$columns[] = 'log.compt';
		$columns[] = 'log.last_visite';
		$col = build_columns('logs', $columns, 'log.id', 'DESC');

		$results = $this->phpcollab_model->get_logs_count($flt);
		$build_pagination = $this->phpcollab_library->build_pagination($results->count, 20, 'logs');

		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->phpcollab_model->get_logs_limit($flt, $build_pagination['limit'], $build_pagination['start'], 'logs');
		$this->zones['content'] = $this->load->view('administration/administration_logs', $data, true);
	}
}
