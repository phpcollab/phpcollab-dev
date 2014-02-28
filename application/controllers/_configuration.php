<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class _configuration extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('_configuration_model');
	}
	public function index() {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->my_library->set_title($this->lang->line('configuration'));
		$filters = array();
		$filters[$this->router->class.'__configuration_cfg_path'] = array('cfg.cfg_path', 'like');
		$filters[$this->router->class.'__configuration_cfg_value'] = array('cfg.cfg_value', 'like');
		$flt = $this->my_library->build_filters($filters);
		$columns = array();
		$columns[] = 'cfg.cfg_id';
		$columns[] = 'cfg.cfg_path';
		$columns[] = 'cfg.cfg_value';
		$columns[] = 'cfg.cfg_datecreated';
		$col = $this->my_library->build_columns($this->router->class.'__configuration', $columns, 'cfg.cfg_path', 'ASC');
		$results = $this->_configuration_model->get_total($flt);
		$build_pagination = $this->my_library->build_pagination($results->count, 30, $this->router->class.'__configuration');
		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['rows'] = $this->_configuration_model->get_rows($flt, $build_pagination['limit'], $build_pagination['start'], $this->router->class.'__configuration');
		$content = $this->load->view('_configuration/_configuration_index', $data, TRUE);
		$this->my_library->set_zone('content', $content);
	}
	public function create() {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->my_library->set_title($this->lang->line('configuration'));
		$this->load->library('form_validation');
		$data = array();
		$this->form_validation->set_rules('cfg_path', 'lang:cfg_path', 'callback_cfg_path|required|max_length[255]');
		$this->form_validation->set_rules('cfg_value', 'lang:cfg_value', 'max_length[255]');
		if($this->form_validation->run() == FALSE) {
			$content = $this->load->view('_configuration/_configuration_create', $data, TRUE);
			$this->my_library->set_zone('content', $content);
		} else {
			$this->db->set('cfg_path', $this->input->post('cfg_path'));
			$this->db->set('cfg_value', $this->input->post('cfg_value'));
			$this->db->set('cfg_datecreated', date('Y-m-d H:i:s'));
			$this->db->insert('_configuration');
			$cfg_id = $this->db->insert_id();
			$this->read($cfg_id);
		}
	}
	public function read($cfg_id) {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$data = array();
		$data['row'] = $this->_configuration_model->get_row($cfg_id);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('configuration').' | '.$data['row']->cfg_path);
			$content = $this->load->view('_configuration/_configuration_read', $data, TRUE);
			$this->my_library->set_zone('content', $content);
		} else {
			$this->index();
		}
	}
	public function update($cfg_id) {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->_configuration_model->get_row($cfg_id);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('configuration').' | '.$data['row']->cfg_path);
			$this->form_validation->set_rules('cfg_path', 'lang:cfg_path', 'callback_cfg_path['.$data['row']->cfg_path.']|required|max_length[255]');
			$this->form_validation->set_rules('cfg_value', 'lang:cfg_value', 'max_length[255]');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('_configuration/_configuration_update', $data, TRUE);
				$this->my_library->set_zone('content', $content);
			} else {
				$this->db->set('cfg_path', $this->input->post('cfg_path'));
				$this->db->set('cfg_value', $this->input->post('cfg_value'));
				$this->db->where('cfg_id', $cfg_id);
				$this->db->update('_configuration');
				$this->read($cfg_id);
			}
		} else {
			$this->index();
		}
	}
	public function delete($cfg_id) {
		if(!$this->auth_library->role('administrator')) {
			redirect($this->my_url);
		}

		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->_configuration_model->get_row($cfg_id);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('configuration').' | '.$data['row']->cfg_path);
			$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('_configuration/_configuration_delete', $data, TRUE);
				$this->my_library->set_zone('content', $content);
			} else {
				$this->db->where('cfg_id', $cfg_id);
				$this->db->delete('_configuration');
				$this->index();
			}
		} else {
			$this->index();
		}
	}
	public function cfg_path($cfg_path, $current = false) {
		if($this->input->post('cfg_path')) {
			if($current) {
				$query = $this->db->query('SELECT cfg.* FROM '.$this->db->dbprefix('_configuration').' AS cfg WHERE cfg.cfg_path = ? AND cfg.cfg_path != ? GROUP BY cfg.cfg_id', array($this->input->post('cfg_path'), $current));
			} else {
				$query = $this->db->query('SELECT cfg.* FROM '.$this->db->dbprefix('_configuration').' AS cfg WHERE cfg.cfg_path = ? GROUP BY cfg.cfg_id', array($this->input->post('cfg_path')));
			}
			if($this->input->is_ajax_request()) {
				$this->my_library->set_template('template_json');
				$this->my_library->set_content_type('application/json');
				$content = array();
				if($query->num_rows() > 0) {
					$content['status'] = 'ko';
				} else {
					$content['status'] = 'ok';
				}
				$this->my_library->set_zone('content', $content);
			} else {
				if($query->num_rows() > 0) {
					$this->form_validation->set_message('cfg_path', $this->lang->line('already_exists'));
					return FALSE;
				} else {
					return TRUE;
				}
			}
		}
	}
}
