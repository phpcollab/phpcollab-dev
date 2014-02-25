<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class projects extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('organizations_model');
		$this->load->model('members_model');
		$this->load->model('projects_model');
		$this->load->model('milestones_model');
		$this->load->model('tasks_model');
		$this->load->model('topics_model');
		$this->load->model('notes_model');
		$this->load->model('files_model');
		$this->load->model('projects_members_model');
	}
	public function index() {
		if($this->auth_library->permission('projects/index')) {
		} else {
			redirect($this->my_url);
		}

		$this->my_library->set_title($this->lang->line('projects'));
		$content = $this->projects_model->get_index_list();
		$this->my_library->set_zone('content', $content);
	}
	public function create() {
		if($this->auth_library->permission('projects/create')) {
		} else {
			redirect($this->my_url);
		}
		$this->my_library->set_title($this->lang->line('projects').' | '.$this->lang->line('create'));
		$this->load->library('form_validation');
		$data = array();
		$data['dropdown_org_id'] = $this->projects_model->dropdown_org_id();
		$data['dropdown_prj_owner'] = $this->projects_model->dropdown_prj_owner();
		$this->form_validation->set_rules('org_id', 'lang:organization', 'required|numeric');
		$this->form_validation->set_rules('prj_owner', 'lang:prj_owner', 'required|numeric');
		$this->form_validation->set_rules('prj_name', 'lang:prj_name', 'required|max_length[255]');
		$this->form_validation->set_rules('prj_description', 'lang:prj_description', '');
		$this->form_validation->set_rules('prj_date_start', 'lang:prj_date_start', 'required');
		$this->form_validation->set_rules('prj_date_due', 'lang:prj_date_due', '');
		$this->form_validation->set_rules('prj_date_complete', 'lang:prj_date_complete', '');
		$this->form_validation->set_rules('prj_status', 'lang:prj_status', 'required|numeric');
		$this->form_validation->set_rules('prj_priority', 'lang:prj_priority', 'required|numeric');
		$this->form_validation->set_rules('prj_published', 'lang:prj_published', 'numeric');
		if($this->form_validation->run() == FALSE) {
			$content = $this->load->view('projects/projects_create', $data, TRUE);
			$this->my_library->set_zone('content', $content);
		} else {
			$this->db->set('org_id', $this->input->post('org_id'));
			$this->db->set('prj_owner', $this->input->post('prj_owner'));
			$this->db->set('prj_name', $this->input->post('prj_name'));
			$this->db->set('prj_description', $this->input->post('prj_description'));
			$this->db->set('prj_date_start', $this->input->post('prj_date_start'));
			$this->db->set('prj_date_due', $this->input->post('prj_date_due'));
			$this->db->set('prj_date_complete', $this->input->post('prj_date_complete'));
			$this->db->set('prj_status', $this->input->post('prj_status'));
			$this->db->set('prj_priority', $this->input->post('prj_priority'));
			$this->db->set('prj_published', checkbox2database($this->input->post('prj_published')));
			$this->db->set('prj_datecreated', date('Y-m-d H:i:s'));
			$this->db->insert('projects');
			$prj_id = $this->db->insert_id();

			$this->db->set('prj_id', $prj_id);
			$this->db->set('mbr_id', $this->input->post('prj_owner'));
			$this->db->set('prj_mbr_authorized', 1);
			$this->db->set('prj_mbr_datecreated', date('Y-m-d H:i:s'));
			$this->db->insert('projects_members');

			redirect($this->my_url.'projects/read/'.$prj_id);
		}
	}
	public function read($prj_id) {
		$data = array();
		$data['row'] = $this->projects_model->get_row($prj_id);
		if($data['row']) {
			if($this->auth_library->permission('projects/read/any')) {
			} else if($this->auth_library->permission('projects/read/ifowner') && $data['row']->prj_owner == $this->phpcollab_member->mbr_id) {
			} else if($this->auth_library->permission('projects/read/ifmember') && $data['row']->ismember == 1) {
			} else {
				redirect($this->my_url);
			}
			if($this->auth_library->permission('projects/read/onlypublished') && $data['row']->prj_published == 0) {
				redirect($this->my_url);
			}
			$this->my_library->set_title($data['row']->prj_name);
			$content = $this->load->view('projects/projects_read', $data, TRUE);
			$content .= $this->milestones_model->get_index_list($data['row']);
			$content .= $this->tasks_model->get_index_list($data['row']);
			$content .= $this->topics_model->get_index_list($data['row']);
			$content .= $this->notes_model->get_index_list($data['row']);
			$content .= $this->files_model->get_index_list($data['row']);
			if($this->auth_library->permission('projects_members/index') && $this->auth_library->permission('projects_members/read/any')) {
				$content .= $this->projects_members_model->get_index_list($data['row']);

			} else if($this->auth_library->permission('projects_members/index') && $this->auth_library->permission('projects_members/read/ifowner') && $data['row']->prj_owner == $this->phpcollab_member->mbr_id) {
				$content .= $this->projects_members_model->get_index_list($data['row']);

			} else if($this->auth_library->permission('projects_members/index') && $this->auth_library->permission('projects_members/read/ifmember') && $data['row']->ismember == 1) {
				$content .= $this->projects_members_model->get_index_list($data['row']);
			}
			$content .= $this->my_model->get_logs('project', $prj_id);
			$this->my_library->set_zone('content', $content);
		} else {
			$this->index();
		}
	}
	public function update($prj_id) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->projects_model->get_row($prj_id);
		if($data['row']) {
			if($this->auth_library->permission('projects/update/any')) {
			} else if($this->auth_library->permission('projects/update/ifowner') && $data['row']->prj_owner == $this->phpcollab_member->mbr_id) {
			} else if($this->auth_library->permission('projects/update/ifmember') && $data['row']->ismember == 1) {
			} else {
				redirect($this->my_url);
			}
			$this->my_library->set_title($data['row']->prj_name);
			$data['dropdown_org_id'] = $this->projects_model->dropdown_org_id();
			$data['dropdown_prj_owner'] = $this->projects_model->dropdown_prj_owner();
			if($this->auth_library->permission('projects/update/organization')) {
				$this->form_validation->set_rules('org_id', 'lang:organization', 'required|numeric');
			}
			if($this->auth_library->permission('projects/update/owner')) {
				$this->form_validation->set_rules('prj_owner', 'lang:prj_owner', 'required|numeric');
			}
			$this->form_validation->set_rules('prj_name', 'lang:prj_name', 'required|max_length[255]');
			$this->form_validation->set_rules('prj_description', 'lang:prj_description', '');
			if($this->auth_library->permission('projects/update/date_start')) {
				$this->form_validation->set_rules('prj_date_start', 'lang:prj_date_start', 'required');
			}
			if($this->auth_library->permission('projects/update/date_due')) {
				$this->form_validation->set_rules('prj_date_due', 'lang:prj_date_due', '');
			}
			if($this->auth_library->permission('projects/update/date_complete')) {
				$this->form_validation->set_rules('prj_date_complete', 'lang:prj_date_complete', '');
			}
			if($this->auth_library->permission('projects/update/status')) {
				$this->form_validation->set_rules('prj_status', 'lang:prj_status', 'required|numeric');
			}
			if($this->auth_library->permission('projects/update/priority')) {
				$this->form_validation->set_rules('prj_priority', 'lang:prj_priority', 'required|numeric');
			}
			if($this->auth_library->permission('projects/update/published')) {
				$this->form_validation->set_rules('prj_published', 'lang:prj_published', 'numeric');
			}
			$this->form_validation->set_rules('log_comments', 'lang:log_comments', '');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('projects/projects_update', $data, TRUE);
				$this->my_library->set_zone('content', $content);
			} else {
				if($this->auth_library->permission('projects/update/organization')) {
					$this->db->set('org_id', $this->input->post('org_id'));
				}
				if($this->auth_library->permission('projects/update/owner')) {
					$this->db->set('prj_owner', $this->input->post('prj_owner'));
				}
				$this->db->set('prj_name', $this->input->post('prj_name'));
				$this->db->set('prj_description', $this->input->post('prj_description'));
				if($this->auth_library->permission('projects/update/date_start')) {
					$this->db->set('prj_date_start', $this->input->post('prj_date_start'));
				}
				if($this->auth_library->permission('projects/update/date_due')) {
					$this->db->set('prj_date_due', $this->input->post('prj_date_due'));
				}
				if($this->auth_library->permission('projects/update/date_complete')) {
					$this->db->set('prj_date_complete', $this->input->post('prj_date_complete'));
				}
				if($this->auth_library->permission('projects/update/status')) {
					$this->db->set('prj_status', $this->input->post('prj_status'));
				}
				if($this->auth_library->permission('projects/update/priority')) {
					$this->db->set('prj_priority', $this->input->post('prj_priority'));
				}
				if($this->auth_library->permission('projects/update/published')) {
					$this->db->set('prj_published', checkbox2database($this->input->post('prj_published')));
				}
				$this->db->where('prj_id', $prj_id);
				$this->db->update('projects');

				$this->my_model->save_log('project', $prj_id, $data['row']);

				redirect($this->my_url.'projects/read/'.$prj_id);
			}
		} else {
			$this->index();
		}
	}
	public function delete($prj_id) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->projects_model->get_row($prj_id);
		if($data['row']) {
			if($this->auth_library->permission('projects/delete/any')) {
			} else if($this->auth_library->permission('projects/delete/ifowner') && $data['row']->prj_owner == $this->phpcollab_member->mbr_id) {
			} else {
				redirect($this->my_url);
			}
			$this->my_library->set_title($data['row']->prj_name);
			$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('projects/projects_delete', $data, TRUE);
				$this->my_library->set_zone('content', $content);
			} else {
				$dir = './storage/projects/'.$prj_id;
				if(is_dir($dir)) {
					if($dh = opendir($dir)) {
						while(($file = readdir($dh)) !== false) {
							if($file != '.' && $file != '..') {
								unlink($dir.'/'.$file);
							}
						}
						closedir($dh);
						rmdir($dir);
					}
				}

				$this->db->where('prj_id', $prj_id);
				$this->db->delete('projects');

				$this->db->where('prj_id', $prj_id);
				$this->db->delete('projects_members');

				$this->db->where('prj_id', $prj_id);
				$this->db->delete('milestones');

				$this->db->where('prj_id', $prj_id);
				$this->db->delete('notes');

				$this->db->where('prj_id', $prj_id);
				$this->db->delete('tasks');

				$this->db->where('prj_id', $prj_id);
				$this->db->delete('files');

				$this->db->where('prj_id', $prj_id);
				$this->db->delete('topics');

				$this->index();
			}
		} else {
			$this->index();
		}
	}
	public function statistics($prj_id) {
		$data = array();
		$data['row'] = $this->projects_model->get_row($prj_id);
		if($data['row']) {
			$this->my_library->set_title($data['row']->prj_name);

			$data['milestones'] = '';

			$legend = array();
			$values = array();
			$query = $this->db->query('SELECT mbr.mbr_name AS ref, mbr.mbr_id AS id, COUNT(DISTINCT(mln.mln_id)) AS nb FROM '.$this->db->dbprefix('milestones').' AS mln LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = mln.mln_owner WHERE mln.prj_id = ? GROUP BY ref ORDER BY nb DESC', array($prj_id));
			if($query->num_rows() > 0) {
				$current_month = date('Y-m');
				foreach($query->result() as $row) {
					if($row->ref) {
						$legend[] = $row->ref;
					} else {
						$legend[] = '-';
					}
					$values[] = $row->nb;
				}
			}
			$data['milestones'] .= build_table_repartition($this->lang->line('mln_owner'), $values, $legend);

			$legend = array();
			$values = array();
			$query = $this->db->query('SELECT SUBSTRING(mln.mln_date_start, 1, 7) AS ref, COUNT(DISTINCT(mln.mln_id)) AS nb FROM '.$this->db->dbprefix('milestones').' AS mln WHERE mln.prj_id = ? GROUP BY ref ORDER BY ref DESC', array($prj_id));
			if($query->num_rows() > 0) {
				$current_month = date('Y-m');
				foreach($query->result() as $row) {
					if($row->ref) {
						$legend[] = $row->ref;
					} else {
						$legend[] = '-';
					}
					$values[] = $row->nb;
				}
			}
			$data['milestones'] .= build_table_progression($this->lang->line('mln_date_start'), $values, $legend);

			$legend = array();
			$values = array();
			$query = $this->db->query('SELECT mln.mln_status AS ref, COUNT(DISTINCT(mln.mln_id)) AS nb FROM '.$this->db->dbprefix('milestones').' AS mln WHERE mln.prj_id = ? GROUP BY ref ORDER BY nb DESC', array($prj_id));
			if($query->num_rows() > 0) {
				$current_month = date('Y-m');
				foreach($query->result() as $row) {
					$legend[] = $this->my_model->status($row->ref);
					$values[] = $row->nb;
				}
			}
			$data['milestones'] .= build_table_repartition($this->lang->line('mln_status'), $values, $legend);

			$legend = array();
			$values = array();
			$query = $this->db->query('SELECT mln.mln_priority AS ref, COUNT(DISTINCT(mln.mln_id)) AS nb FROM '.$this->db->dbprefix('milestones').' AS mln WHERE mln.prj_id = ? GROUP BY ref ORDER BY nb DESC', array($prj_id));
			if($query->num_rows() > 0) {
				$current_month = date('Y-m');
				foreach($query->result() as $row) {
					$legend[] = '<span class="color_percent priority_'.$row->ref.'" style="width:100%;">'.$this->my_model->priority($row->ref).'</span>';
					$values[] = $row->nb;
				}
			}
			$data['milestones'] .= build_table_repartition($this->lang->line('mln_priority'), $values, $legend);

			$data['tasks'] = '';

			$legend = array();
			$values = array();
			$query = $this->db->query('SELECT trk.trk_name AS ref, COUNT(DISTINCT(tsk.tsk_id)) AS nb FROM '.$this->db->dbprefix('tasks').' AS tsk LEFT JOIN '.$this->db->dbprefix('trackers').' AS trk ON trk.trk_id = tsk.trk_id WHERE tsk.prj_id = ? GROUP BY ref ORDER BY nb DESC', array($prj_id));
			if($query->num_rows() > 0) {
				$current_month = date('Y-m');
				foreach($query->result() as $row) {
					if($row->ref) {
						$legend[] = $row->ref;
					} else {
						$legend[] = '-';
					}
					$values[] = $row->nb;
				}
			}
			$data['tasks'] .= build_table_repartition($this->lang->line('tracker'), $values, $legend);

			$legend = array();
			$values = array();
			$query = $this->db->query('SELECT mln.mln_name AS ref, mln.mln_id AS id, COUNT(DISTINCT(tsk.tsk_id)) AS nb FROM '.$this->db->dbprefix('tasks').' AS tsk LEFT JOIN '.$this->db->dbprefix('milestones').' AS mln ON mln.mln_id = tsk.mln_id WHERE tsk.prj_id = ? GROUP BY ref ORDER BY nb DESC', array($prj_id));
			if($query->num_rows() > 0) {
				$current_month = date('Y-m');
				foreach($query->result() as $row) {
					if($row->ref) {
						$legend[] = '<a href="'.$this->my_url.'milestones/statistics/'.$row->id.'">'.$row->ref.'</a>';
					} else {
						$legend[] = '-';
					}
					$values[] = $row->nb;
				}
			}
			$data['tasks'] .= build_table_repartition($this->lang->line('milestone'), $values, $legend);

			$legend = array();
			$values = array();
			$query = $this->db->query('SELECT mbr.mbr_name AS ref, mbr.mbr_id AS id, COUNT(DISTINCT(tsk.tsk_id)) AS nb FROM '.$this->db->dbprefix('tasks').' AS tsk LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = tsk.tsk_owner WHERE tsk.prj_id = ? GROUP BY ref ORDER BY nb DESC', array($prj_id));
			if($query->num_rows() > 0) {
				$current_month = date('Y-m');
				foreach($query->result() as $row) {
					if($row->ref) {
						$legend[] = $row->ref;
					} else {
						$legend[] = '-';
					}
					$values[] = $row->nb;
				}
			}
			$data['tasks'] .= build_table_repartition($this->lang->line('tsk_owner'), $values, $legend);

			$legend = array();
			$values = array();
			$query = $this->db->query('SELECT mbr.mbr_name AS ref, mbr.mbr_id AS id, COUNT(DISTINCT(tsk.tsk_id)) AS nb FROM '.$this->db->dbprefix('tasks').' AS tsk LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = tsk.tsk_assigned WHERE tsk.prj_id = ? GROUP BY ref ORDER BY nb DESC', array($prj_id));
			if($query->num_rows() > 0) {
				$current_month = date('Y-m');
				foreach($query->result() as $row) {
					if($row->ref) {
						$legend[] = $row->ref;
					} else {
						$legend[] = '-';
					}
					$values[] = $row->nb;
				}
			}
			$data['tasks'] .= build_table_repartition($this->lang->line('tsk_assigned'), $values, $legend);

			$legend = array();
			$values = array();
			$query = $this->db->query('SELECT SUBSTRING(tsk.tsk_date_start, 1, 7) AS ref, COUNT(DISTINCT(tsk.tsk_id)) AS nb FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.prj_id = ? GROUP BY ref ORDER BY ref DESC', array($prj_id));
			if($query->num_rows() > 0) {
				$current_month = date('Y-m');
				foreach($query->result() as $row) {
					if($row->ref) {
						$legend[] = $row->ref;
					} else {
						$legend[] = '-';
					}
					$values[] = $row->nb;
				}
			}
			$data['tasks'] .= build_table_progression($this->lang->line('tsk_date_start'), $values, $legend);

			$legend = array();
			$values = array();
			$query = $this->db->query('SELECT tsk.tsk_status AS ref, COUNT(DISTINCT(tsk.tsk_id)) AS nb FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.prj_id = ? GROUP BY ref ORDER BY nb DESC', array($prj_id));
			if($query->num_rows() > 0) {
				$current_month = date('Y-m');
				foreach($query->result() as $row) {
					$legend[] = $this->my_model->status($row->ref);
					$values[] = $row->nb;
				}
			}
			$data['tasks'] .= build_table_repartition($this->lang->line('tsk_status'), $values, $legend);

			$legend = array();
			$values = array();
			$query = $this->db->query('SELECT tsk.tsk_priority AS ref, COUNT(DISTINCT(tsk.tsk_id)) AS nb FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.prj_id = ? GROUP BY ref ORDER BY nb DESC', array($prj_id));
			if($query->num_rows() > 0) {
				$current_month = date('Y-m');
				foreach($query->result() as $row) {
					$legend[] = '<span class="color_percent priority_'.$row->ref.'" style="width:100%;">'.$this->my_model->priority($row->ref).'</span>';
					$values[] = $row->nb;
				}
			}
			$data['tasks'] .= build_table_repartition($this->lang->line('tsk_priority'), $values, $legend);

			$legend = array();
			$values = array();
			$query = $this->db->query('SELECT tsk.tsk_completion AS ref, COUNT(DISTINCT(tsk.tsk_id)) AS nb FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.prj_id = ? GROUP BY ref ORDER BY ref ASC', array($prj_id));
			if($query->num_rows() > 0) {
				$current_month = date('Y-m');
				foreach($query->result() as $row) {
					$legend[] = $row->ref.'%';
					$values[] = $row->nb;
				}
			}
			$data['tasks'] .= build_table_repartition($this->lang->line('tsk_completion'), $values, $legend);

			$content = $this->load->view('projects/projects_statistics', $data, TRUE);
			$this->my_library->set_zone('content', $content);
		} else {
			redirect($this->my_url);
		}
	}
}
