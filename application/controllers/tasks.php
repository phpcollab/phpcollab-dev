<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tasks extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('members_model');
		$this->load->model('projects_model');
		$this->load->model('tasks_model');
		$this->load->model('trackers_model');
		$this->load->model('milestones_model');
		$this->load->model('attachments_model');
	}
	public function index($prj_id) {
		$data = array();
		$data['prj'] = $this->projects_model->get_row($prj_id);
		if($data['prj']) {
			$this->my_library->set_title($data['prj']->prj_name.' | '.$this->lang->line('tasks'));
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
			$this->my_library->set_title($data['prj']->prj_name.' | '.$this->lang->line('tasks').' | '.$this->lang->line('create'));
			$this->load->library('form_validation');
			$data['dropdown_trk_id'] = $this->tasks_model->dropdown_trk_id();
			$data['dropdown_mln_id'] = $this->tasks_model->dropdown_mln_id($prj_id);
			$data['dropdown_tsk_owner'] = $this->tasks_model->dropdown_tsk_owner();
			$data['dropdown_tsk_assigned'] = $this->tasks_model->dropdown_tsk_assigned($prj_id);
			$data['dropdown_tsk_parent'] = $this->tasks_model->dropdown_tsk_parent($prj_id);
			$this->form_validation->set_rules('trk_id', 'lang:tracker', 'required|numeric');
			$this->form_validation->set_rules('mln_id', 'lang:milestone', 'numeric');
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
			$this->form_validation->set_rules('tsk_published', 'lang:tsk_published', 'numeric');
			$this->form_validation->set_rules('log_comments', 'lang:log_comments', '');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('tasks/tasks_create', $data, TRUE);
				$this->my_library->set_zone('content', $content);
			} else {
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
				$this->db->set('tsk_published', checkbox2database($this->input->post('tsk_published')));
				$this->db->set('tsk_datecreated', date('Y-m-d H:i:s'));
				$this->db->insert('tasks');
				$tsk_id = $this->db->insert_id();

				if(isset($_FILES['att_name']) == 1 && $_FILES['att_name']['error'] == 0) {
					if(!is_dir('storage/projects/'.$prj_id)) {
						mkdir('storage/projects/'.$prj_id);
						copy('storage/projects/index.html', 'storage/projects/'.$prj_id.'/index.html');
					}

					$att_name = clean_string($_FILES['att_name']['name']);
					$att_name = generate_string(6).'-'.$att_name;

					move_uploaded_file($_FILES['att_name']['tmp_name'], 'storage/projects/'.$prj_id.'/'.$att_name);

					$this->db->set('tsk_id', $tsk_id);
					$this->db->set('att_owner', $this->phpcollab_member->mbr_id);
					$this->db->set('att_name', $att_name);
					$this->db->set('att_size', $_FILES['att_name']['size']);
					$this->db->set('att_datecreated', date('Y-m-d H:i:s'));
					$this->db->insert('attachments');
				}

				if($this->input->post('tsk_assigned') != '' && $this->config->item('phpcollab/enabled/notifications')) {
					$data['task'] = $this->tasks_model->get_row($tsk_id);
					$this->load->library(array('email_library'));
					$to = $this->members_model->get_row($this->input->post('tsk_assigned'))->mbr_email;
					$message = $this->load->view('emails/project_task_assigned', $data, TRUE);
					$this->email_library->send($to, $message);
				}

				redirect($this->my_url.'tasks/read/'.$tsk_id);
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
				if($this->auth_library->permission('tasks/read/onlypublished') && $data['row']->tsk_published == 0) {
					redirect($this->my_url);
				}
				if($this->auth_library->permission('tasks/read/onlyassigned') && $data['row']->tsk_assigned != $this->phpcollab_member->mbr_id) {
					redirect($this->my_url);
				}
				$this->my_library->set_title($data['prj']->prj_name.' | '.$data['row']->tsk_name);
				$content = $this->load->view('tasks/tasks_read', $data, TRUE);
				$content .= $this->attachments_model->get_index_list($data['row']);
				$content .= $this->my_model->get_logs('task', $tsk_id);
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
				$this->my_library->set_title($data['prj']->prj_name.' | '.$data['row']->tsk_name);
				$data['dropdown_trk_id'] = $this->tasks_model->dropdown_trk_id();
				$data['dropdown_mln_id'] = $this->tasks_model->dropdown_mln_id($data['row']->prj_id);
				$data['dropdown_tsk_owner'] = $this->tasks_model->dropdown_tsk_owner();
				$data['dropdown_tsk_assigned'] = $this->tasks_model->dropdown_tsk_assigned($data['row']->prj_id);
				$data['dropdown_tsk_parent'] = $this->tasks_model->dropdown_tsk_parent($data['row']->prj_id);
				$this->form_validation->set_rules('trk_id', 'lang:tracker', 'required|numeric');
				$this->form_validation->set_rules('mln_id', 'lang:milestone', 'numeric');
				if($this->auth_library->permission('tasks/update/owner')) {
					$this->form_validation->set_rules('tsk_owner', 'lang:tsk_owner', 'required|numeric');
				}
				if($this->auth_library->permission('tasks/update/assigned')) {
					$this->form_validation->set_rules('tsk_assigned', 'lang:tsk_assigned', 'numeric');
				}
				$this->form_validation->set_rules('tsk_name', 'lang:tsk_name', 'required|max_length[255]');
				$this->form_validation->set_rules('tsk_description', 'lang:tsk_description', '');
				if($this->auth_library->permission('tasks/update/date_start')) {
					$this->form_validation->set_rules('tsk_date_start', 'lang:tsk_date_start', '');
				}
				if($this->auth_library->permission('tasks/update/date_due')) {
					$this->form_validation->set_rules('tsk_date_due', 'lang:tsk_date_due', '');
				}
				if($this->auth_library->permission('tasks/update/date_complete')) {
					$this->form_validation->set_rules('tsk_date_complete', 'lang:tsk_date_complete', '');
				}
				if($this->auth_library->permission('tasks/update/status')) {
					$this->form_validation->set_rules('tsk_status', 'lang:tsk_status', 'required|numeric');
				}
				if($this->auth_library->permission('tasks/update/priority')) {
					$this->form_validation->set_rules('tsk_priority', 'lang:tsk_priority', 'required|numeric');
				}
				$this->form_validation->set_rules('tsk_parent', 'lang:tsk_parent', 'numeric');
				$this->form_validation->set_rules('tsk_completion', 'lang:tsk_completion', 'required|numeric');
				if($this->auth_library->permission('tasks/update/published')) {
					$this->form_validation->set_rules('tsk_published', 'lang:tsk_published', 'numeric');
				}
				$this->form_validation->set_rules('log_comments', 'lang:log_comments', '');
				if($this->form_validation->run() == FALSE) {
					$content = $this->load->view('tasks/tasks_update', $data, TRUE);
					$this->my_library->set_zone('content', $content);
				} else {
					$this->db->set('trk_id', $this->input->post('trk_id'));
					$this->db->set('mln_id', $this->input->post('mln_id'));
					if($this->auth_library->permission('tasks/update/owner')) {
						$this->db->set('tsk_owner', $this->input->post('tsk_owner'));
					}
					if($this->auth_library->permission('tasks/update/assigned')) {
						$this->db->set('tsk_assigned', $this->input->post('tsk_assigned'));
					}
					$this->db->set('tsk_name', $this->input->post('tsk_name'));
					$this->db->set('tsk_description', $this->input->post('tsk_description'));
					if($this->auth_library->permission('tasks/update/date_start')) {
						$this->db->set('tsk_date_start', $this->input->post('tsk_date_start'));
					}
					if($this->auth_library->permission('tasks/update/date_due')) {
						$this->db->set('tsk_date_due', $this->input->post('tsk_date_due'));
					}
					if($this->auth_library->permission('tasks/update/date_complete')) {
						$this->db->set('tsk_date_complete', $this->input->post('tsk_date_complete'));
					}
					if($this->auth_library->permission('tasks/update/status')) {
						$this->db->set('tsk_status', $this->input->post('tsk_status'));
					}
					if($this->auth_library->permission('tasks/update/priority')) {
						$this->db->set('tsk_priority', $this->input->post('tsk_priority'));
					}
					$this->db->set('tsk_parent', $this->input->post('tsk_parent'));
					$this->db->set('tsk_completion', $this->input->post('tsk_completion'));
					if($this->auth_library->permission('tasks/update/published')) {
						$this->db->set('tsk_published', checkbox2database($this->input->post('tsk_published')));
					}
					$this->db->where('tsk_id', $tsk_id);
					$this->db->update('tasks');

					if(isset($_FILES['att_name']) == 1 && $_FILES['att_name']['error'] == 0) {
						if(!is_dir('storage/projects/'.$prj_id)) {
							mkdir('storage/projects/'.$prj_id);
							copy('storage/projects/index.html', 'storage/projects/'.$prj_id.'/index.html');
						}

						$att_name = clean_string($_FILES['att_name']['name']);
						$att_name = generate_string(6).'-'.$att_name;

						move_uploaded_file($_FILES['att_name']['tmp_name'], 'storage/projects/'.$data['row']->prj_id.'/'.$att_name);

						$this->db->set('tsk_id', $tsk_id);
						$this->db->set('att_owner', $this->phpcollab_member->mbr_id);
						$this->db->set('att_name', $att_name);
						$this->db->set('att_size', $_FILES['att_name']['size']);
						$this->db->set('att_datecreated', date('Y-m-d H:i:s'));
						$this->db->insert('attachments');
					}

					$this->my_model->save_log('task', $tsk_id, $data['row']);

					if($this->input->post('tsk_assigned') != '' && $this->input->post('tsk_assigned') != $data['row']->tsk_assigned && $this->config->item('phpcollab/enabled/notifications')) {
						$data['task'] = $this->tasks_model->get_row($tsk_id);
						$this->load->library(array('email_library'));
						$to = $this->members_model->get_row($this->input->post('tsk_assigned'))->mbr_email;
						$message = $this->load->view('emails/project_task_assigned', $data, TRUE);
						$this->email_library->send($to, $message);
					}

					redirect($this->my_url.'tasks/read/'.$tsk_id);
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
				if(!$data['row']->action_delete) {
					redirect($this->my_url);
				}
				$this->my_library->set_title($data['prj']->prj_name.' | '.$data['row']->tsk_name);
				$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
				if($this->form_validation->run() == FALSE) {
					$content = $this->load->view('tasks/tasks_delete', $data, TRUE);
					$this->my_library->set_zone('content', $content);
				} else {
					$this->db->where('tsk_id', $tsk_id);
					$this->db->delete('tasks');

					$this->db->where('tsk_id', $tsk_id);
					$this->db->delete('attachments');

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
