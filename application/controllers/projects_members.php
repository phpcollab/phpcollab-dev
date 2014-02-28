<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class projects_members extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('projects_model');
		$this->load->model('projects_members_model');
	}
	public function index($prj_id) {
		$data = array();
		$data['prj'] = $this->projects_model->get_row($prj_id);
		if($data['prj']) {
			if(!$data['prj']->action_read) {
				redirect($this->my_url);
			}
			if(!$data['prj']->action_read_team) {
				redirect($this->my_url);
			}
			$this->my_library->set_title($data['prj']->prj_name.' /' .$this->lang->line('projects_members'));
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
			if(!$data['prj']->action_read) {
				redirect($this->my_url);
			}
			if(!$data['prj']->action_create_team) {
				redirect($this->my_url);
			}
			$this->my_library->set_title($data['prj']->prj_name.' /' .$this->lang->line('projects_members').' /' .$this->lang->line('create'));
			$this->load->library('form_validation');
			$data['dropdown_mbr_id'] = $this->projects_members_model->dropdown_mbr_id($prj_id);
			$this->form_validation->set_rules('mbr_id', 'lang:member', 'required|numeric');
			$this->form_validation->set_rules('prj_mbr_authorized', 'lang:prj_mbr_authorized', 'numeric');
			$this->form_validation->set_rules('prj_mbr_published', 'lang:prj_mbr_published', 'numeric');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('projects_members/projects_members_create', $data, TRUE);
				$this->my_library->set_zone('content', $content);
			} else {
				$this->db->set('prj_id', $prj_id);
				$this->db->set('mbr_id', $this->input->post('mbr_id'));
				$this->db->set('prj_mbr_authorized', checkbox2database($this->input->post('prj_mbr_authorized')));
				$this->db->set('prj_mbr_published', checkbox2database($this->input->post('prj_mbr_published')));
				$this->db->set('prj_mbr_datecreated', date('Y-m-d H:i:s'));
				$this->db->insert('projects_members');
				$prj_mbr_id = $this->db->insert_id();

				redirect($this->my_url.'projects_members/read/'.$prj_mbr_id);
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
				if(!$data['prj']->action_read) {
					redirect($this->my_url);
				}
				if(!$data['prj']->action_read_team) {
					redirect($this->my_url);
				}
				if($this->auth_library->permission('projects_members/read/onlypublished') && $data['row']->prj_mbr_published == 0) {
					redirect($this->my_url);
				}
				$this->my_library->set_title($data['prj']->prj_name.' | '.$data['row']->mbr_name);
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
				if(!$data['prj']->action_read) {
					redirect($this->my_url);
				}
				if(!$data['prj']->action_update_team) {
					redirect($this->my_url);
				}
				$this->my_library->set_title($data['prj']->prj_name.' | '.$data['row']->mbr_name);
				$this->form_validation->set_rules('prj_mbr_authorized', 'lang:prj_mbr_authorized', 'numeric');
				$this->form_validation->set_rules('prj_mbr_published', 'lang:prj_mbr_published', 'numeric');
				if($this->form_validation->run() == FALSE) {
					$content = $this->load->view('projects_members/projects_members_update', $data, TRUE);
					$this->my_library->set_zone('content', $content);
				} else {
					$this->db->set('prj_mbr_authorized', checkbox2database($this->input->post('prj_mbr_authorized')));
					$this->db->set('prj_mbr_published', checkbox2database($this->input->post('prj_mbr_published')));
					$this->db->where('prj_mbr_id', $prj_mbr_id);
					$this->db->update('projects_members');

					$this->my_model->save_log('project_member', $prj_mbr_id, $data['row']);

					redirect($this->my_url.'projects_members/read/'.$prj_mbr_id);
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
				if(!$data['prj']->action_read) {
					redirect($this->my_url);
				}
				if(!$data['prj']->action_delete_team) {
					redirect($this->my_url);
				}
				$this->my_library->set_title($data['prj']->prj_name.' | '.$data['row']->mbr_name);
				$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
				if($this->form_validation->run() == FALSE) {
					$content = $this->load->view('projects_members/projects_members_delete', $data, TRUE);
					$this->my_library->set_zone('content', $content);
				} else {
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
