<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tasks extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('projects_model');
		$this->load->model('tasks_model');

		$this->storage_table = 'tasks';
		$this->storage_fields = array();
	}
	public function index($prj_id) {
		$data = array();
		$data['prj'] = $this->projects_model->get_row($prj_id);
		if($data['prj']) {
			$this->my_library->set_title($this->lang->line('tasks'));
			$content = $this->tasks_model->get_index_list($data['prj']);
			$this->my_library->set_zone('content', $content);
		} else {
			redirect($this->my_url);
		}
	}
	public function create($prj_id) {
		$data = array();
		$data['prj'] = $this->projects_model->get_row($prj_id);
		if($data['prj']) {
			$this->my_library->set_title($this->lang->line('tasks'));
			$this->load->library('form_validation');
			$data['dropdown_trk_id'] = $this->tasks_model->dropdown_trk_id();
			$data['dropdown_mln_id'] = $this->tasks_model->dropdown_mln_id();
			$data['dropdown_tsk_owner'] = $this->tasks_model->dropdown_tsk_owner();
			$data['dropdown_tsk_assigned'] = $this->tasks_model->dropdown_tsk_assigned();
			$data['dropdown_tsk_parent'] = $this->tasks_model->dropdown_tsk_parent();
			$this->form_validation->set_rules('trk_id', 'lang:trk_id', 'required|numeric');
			$this->form_validation->set_rules('mln_id', 'lang:mln_id', 'numeric');
			$this->form_validation->set_rules('tsk_owner', 'lang:tsk_owner', 'required|numeric');
			$this->form_validation->set_rules('tsk_assigned', 'lang:tsk_assigned', 'numeric');
			$this->form_validation->set_rules('tsk_name', 'lang:tsk_name', 'required|max_length[255]');
			$this->form_validation->set_rules('tsk_description', 'lang:tsk_description', '');
			$this->form_validation->set_rules('tsk_date_start', 'lang:tsk_date_start', '');
			$this->form_validation->set_rules('tsk_date_due', 'lang:tsk_date_due', '');
			$this->form_validation->set_rules('tsk_date_complete', 'lang:tsk_date_complete', '');
			$this->form_validation->set_rules('tsk_status', 'lang:tsk_status', 'required|numeric');
			$this->form_validation->set_rules('tsk_priority', 'lang:tsk_priority', 'required|numeric');
			$this->form_validation->set_rules('tsk_parent', 'lang:tsk_parent', 'numeric');
			$this->form_validation->set_rules('tsk_completion', 'lang:tsk_completion', 'required|numeric');
			$this->form_validation->set_rules('tsk_comments', 'lang:tsk_comments', '');
			$this->form_validation->set_rules('tsk_published', 'lang:tsk_published', 'numeric');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('tasks/tasks_create', $data, TRUE);
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
				$this->db->set('trk_id', $this->input->post('trk_id'));
				$this->db->set('mln_id', $this->input->post('mln_id'));
				$this->db->set('tsk_owner', $this->input->post('tsk_owner'));
				$this->db->set('tsk_assigned', $this->input->post('tsk_assigned'));
				$this->db->set('tsk_name', $this->input->post('tsk_name'));
				$this->db->set('tsk_description', $this->input->post('tsk_description'));
				$this->db->set('tsk_date_start', $this->input->post('tsk_date_start'));
				$this->db->set('tsk_date_due', $this->input->post('tsk_date_due'));
				$this->db->set('tsk_date_complete', $this->input->post('tsk_date_complete'));
				$this->db->set('tsk_status', $this->input->post('tsk_status'));
				$this->db->set('tsk_priority', $this->input->post('tsk_priority'));
				$this->db->set('tsk_parent', $this->input->post('tsk_parent'));
				$this->db->set('tsk_completion', $this->input->post('tsk_completion'));
				$this->db->set('tsk_comments', $this->input->post('tsk_comments'));
				$this->db->set('tsk_published', checkbox2database($this->input->post('tsk_published')));
				$this->db->set('tsk_datecreated', date('Y-m-d H:i:s'));
				$this->db->insert('tasks');
				$tsk_id = $this->db->insert_id();
				$this->read($tsk_id);
			}
		} else {
			redirect($this->my_url);
		}
	}
	public function read($tsk_id) {
		$data = array();
		$data['row'] = $this->tasks_model->get_row($tsk_id);
		if($data['row']) {
			$data['prj'] = $this->projects_model->get_row($data['row']->prj_id);
			if($data['prj']) {
				$this->my_library->set_title($this->lang->line('tasks').' / '.$data['row']->tsk_name);
				$content = $this->load->view('tasks/tasks_read', $data, TRUE);
				$this->my_library->set_zone('content', $content);
			} else {
				redirect($this->my_url);
			}
		} else {
			redirect($this->my_url);
		}
	}
	public function update($tsk_id) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->tasks_model->get_row($tsk_id);
		if($data['row']) {
			$data['prj'] = $this->projects_model->get_row($data['row']->prj_id);
			if($data['prj']) {
				$this->my_library->set_title($this->lang->line('tasks').' / '.$data['row']->tsk_name);
				$data['dropdown_trk_id'] = $this->tasks_model->dropdown_trk_id();
				$data['dropdown_mln_id'] = $this->tasks_model->dropdown_mln_id();
				$data['dropdown_tsk_owner'] = $this->tasks_model->dropdown_tsk_owner();
				$data['dropdown_tsk_assigned'] = $this->tasks_model->dropdown_tsk_assigned();
				$data['dropdown_tsk_parent'] = $this->tasks_model->dropdown_tsk_parent();
				$this->form_validation->set_rules('trk_id', 'lang:trk_id', 'required|numeric');
				$this->form_validation->set_rules('mln_id', 'lang:mln_id', 'numeric');
				$this->form_validation->set_rules('tsk_owner', 'lang:tsk_owner', 'required|numeric');
				$this->form_validation->set_rules('tsk_assigned', 'lang:tsk_assigned', 'numeric');
				$this->form_validation->set_rules('tsk_name', 'lang:tsk_name', 'required|max_length[255]');
				$this->form_validation->set_rules('tsk_description', 'lang:tsk_description', '');
				$this->form_validation->set_rules('tsk_date_start', 'lang:tsk_date_start', '');
				$this->form_validation->set_rules('tsk_date_due', 'lang:tsk_date_due', '');
				$this->form_validation->set_rules('tsk_date_complete', 'lang:tsk_date_complete', '');
				$this->form_validation->set_rules('tsk_status', 'lang:tsk_status', 'required|numeric');
				$this->form_validation->set_rules('tsk_priority', 'lang:tsk_priority', 'required|numeric');
				$this->form_validation->set_rules('tsk_parent', 'lang:tsk_parent', 'numeric');
				$this->form_validation->set_rules('tsk_completion', 'lang:tsk_completion', 'required|numeric');
				$this->form_validation->set_rules('tsk_comments', 'lang:tsk_comments', '');
				$this->form_validation->set_rules('tsk_published', 'lang:tsk_published', 'numeric');
				if($this->form_validation->run() == FALSE) {
					$content = $this->load->view('tasks/tasks_update', $data, TRUE);
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
					$this->db->set('trk_id', $this->input->post('trk_id'));
					$this->db->set('mln_id', $this->input->post('mln_id'));
					$this->db->set('tsk_owner', $this->input->post('tsk_owner'));
					$this->db->set('tsk_assigned', $this->input->post('tsk_assigned'));
					$this->db->set('tsk_name', $this->input->post('tsk_name'));
					$this->db->set('tsk_description', $this->input->post('tsk_description'));
					$this->db->set('tsk_date_start', $this->input->post('tsk_date_start'));
					$this->db->set('tsk_date_due', $this->input->post('tsk_date_due'));
					$this->db->set('tsk_date_complete', $this->input->post('tsk_date_complete'));
					$this->db->set('tsk_status', $this->input->post('tsk_status'));
					$this->db->set('tsk_priority', $this->input->post('tsk_priority'));
					$this->db->set('tsk_parent', $this->input->post('tsk_parent'));
					$this->db->set('tsk_completion', $this->input->post('tsk_completion'));
					$this->db->set('tsk_comments', $this->input->post('tsk_comments'));
					$this->db->set('tsk_published', checkbox2database($this->input->post('tsk_published')));
					$this->db->set('tsk_datemodified', date('Y-m-d H:i:s'));
					$this->db->where('tsk_id', $tsk_id);
					$this->db->update('tasks');
					$this->read($tsk_id);
				}
			} else {
				redirect($this->my_url);
			}
		} else {
			redirect($this->my_url);
		}
	}
	public function delete($tsk_id) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->tasks_model->get_row($tsk_id);
		if($data['row']) {
			$data['prj'] = $this->projects_model->get_row($data['row']->prj_id);
			if($data['prj']) {
				$this->my_library->set_title($this->lang->line('tasks').' / '.$data['row']->tsk_name);
				$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
				if($this->form_validation->run() == FALSE) {
					$content = $this->load->view('tasks/tasks_delete', $data, TRUE);
					$this->my_library->set_zone('content', $content);
				} else {
					if(count($this->storage_fields) > 0) {
						foreach($this->storage_fields as $field) {
							if($data['row']->{$field} && file_exists('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field})) {
								unlink('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field});
							}
						}
					}
					$this->db->where('tsk_id', $tsk_id);
					$this->db->delete('tasks');
					$this->index();
				}
			} else {
				redirect($this->my_url);
			}
		} else {
			redirect($this->my_url);
		}
	}
}
