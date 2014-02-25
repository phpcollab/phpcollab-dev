<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class notes extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('projects_model');
		$this->load->model('notes_model');
	}
	public function index($prj_id) {
		$data = array();
		$data['prj'] = $this->projects_model->get_row($prj_id);
		if($data['prj']) {
			$this->my_library->set_title($data['prj']->prj_name.' | '.$this->lang->line('notes'));
			$content = $this->notes_model->get_index_list($data['prj']);
			$this->my_library->set_zone('content', $content);
		} else {
			redirect($this->my_url);
		}
	}
	public function create($prj_id) {
		$data = array();
		$data['prj'] = $this->projects_model->get_row($prj_id);
		if($data['prj']) {
			$this->my_library->set_title($data['prj']->prj_name.' | '.$this->lang->line('notes').' | '.$this->lang->line('create'));
			$this->load->library('form_validation');
			$data['dropdown_nte_owner'] = $this->notes_model->dropdown_nte_owner();
			$this->form_validation->set_rules('nte_owner', 'lang:nte_owner', 'required|numeric');
			$this->form_validation->set_rules('nte_name', 'lang:nte_name', 'required|max_length[255]');
			$this->form_validation->set_rules('nte_description', 'lang:nte_description', '');
			$this->form_validation->set_rules('nte_date', 'lang:nte_date', 'required');
			$this->form_validation->set_rules('nte_published', 'lang:nte_published', 'numeric');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('notes/notes_create', $data, TRUE);
				$this->my_library->set_zone('content', $content);
			} else {
				$this->db->set('prj_id', $prj_id);
				$this->db->set('nte_owner', $this->input->post('nte_owner'));
				$this->db->set('nte_name', $this->input->post('nte_name'));
				$this->db->set('nte_description', $this->input->post('nte_description'));
				$this->db->set('nte_date', $this->input->post('nte_date'));
				$this->db->set('nte_published', checkbox2database($this->input->post('nte_published')));
				$this->db->set('nte_datecreated', date('Y-m-d H:i:s'));
				$this->db->insert('notes');
				$nte_id = $this->db->insert_id();

				redirect($this->my_url.'notes/read/'.$nte_id);
			}
		} else {
			redirect($this->my_url);
		}
	}
	public function read($nte_id) {
		$data = array();
		$data['row'] = $this->notes_model->get_row($nte_id);
		if($data['row']) {
			$data['prj'] = $this->projects_model->get_row($data['row']->prj_id);
			if($data['prj']) {
				if($this->auth_library->permission('notes/read/onlypublished') && $data['row']->nte_published == 0) {
					redirect($this->my_url);
				}
				$this->my_library->set_title($data['prj']->prj_name.' | '.$data['row']->nte_name);
				$content = $this->load->view('notes/notes_read', $data, TRUE);
				$content .= $this->my_model->get_logs('note', $nte_id);
				$this->my_library->set_zone('content', $content);
			} else {
				redirect($this->my_url);
			}
		} else {
			redirect($this->my_url);
		}
	}
	public function update($nte_id) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->notes_model->get_row($nte_id);
		if($data['row']) {
			$data['prj'] = $this->projects_model->get_row($data['row']->prj_id);
			if($data['prj']) {
				$this->my_library->set_title($data['prj']->prj_name.' | '.$data['row']->nte_name);
				$data['dropdown_nte_owner'] = $this->notes_model->dropdown_nte_owner();
				$this->form_validation->set_rules('nte_owner', 'lang:nte_owner', 'required|numeric');
				$this->form_validation->set_rules('nte_name', 'lang:nte_name', 'required|max_length[255]');
				$this->form_validation->set_rules('nte_description', 'lang:nte_description', '');
				$this->form_validation->set_rules('nte_date', 'lang:nte_date', 'required');
				$this->form_validation->set_rules('nte_published', 'lang:nte_published', 'numeric');
				if($this->form_validation->run() == FALSE) {
					$content = $this->load->view('notes/notes_update', $data, TRUE);
					$this->my_library->set_zone('content', $content);
				} else {
					$this->db->set('nte_owner', $this->input->post('nte_owner'));
					$this->db->set('nte_name', $this->input->post('nte_name'));
					$this->db->set('nte_description', $this->input->post('nte_description'));
					$this->db->set('nte_date', $this->input->post('nte_date'));
					$this->db->set('nte_published', checkbox2database($this->input->post('nte_published')));
					$this->db->where('nte_id', $nte_id);
					$this->db->update('notes');

					$this->my_model->save_log('note', $nte_id, $data['row']);

					redirect($this->my_url.'notes/read/'.$nte_id);
				}
			} else {
				redirect($this->my_url);
			}
		} else {
			redirect($this->my_url);
		}
	}
	public function delete($nte_id) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->notes_model->get_row($nte_id);
		if($data['row']) {
			$data['prj'] = $this->projects_model->get_row($data['row']->prj_id);
			if($data['prj']) {
				if($this->auth_library->permission('notes/delete/any')) {
				} else if($this->auth_library->permission('notes/delete/ifowner') && $data['row']->nte_owner == $this->phpcollab_member->mbr_id) {
				} else {
					redirect($this->my_url);
				}
				$this->my_library->set_title($data['prj']->prj_name.' | '.$data['row']->nte_name);
				$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
				if($this->form_validation->run() == FALSE) {
					$content = $this->load->view('notes/notes_delete', $data, TRUE);
					$this->my_library->set_zone('content', $content);
				} else {
					$this->db->where('nte_id', $nte_id);
					$this->db->delete('notes');
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
