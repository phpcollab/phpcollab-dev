<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class projects extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('projects_model');
		$this->load->model('milestones_model');
		$this->load->model('tasks_model');
		$this->load->model('topics_model');
		$this->load->model('notes_model');
		$this->load->model('files_model');
		$this->load->model('projects_members_model');

		$this->storage_table = 'projects';
		$this->storage_fields = array();
	}
	public function index() {
		$this->my_library->set_title($this->lang->line('projects'));
		$content = $this->projects_model->get_index_list();
		$this->my_library->set_zone('content', $content);
	}
	public function create() {
		$this->my_library->set_title($this->lang->line('projects'));
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
			$this->read($prj_id);
		}
	}
	public function read($prj_id) {
		$data = array();
		$data['row'] = $this->projects_model->get_row($prj_id);
		if($data['row']) {
			$this->my_library->set_title($this->lang->line('projects').' / '.$data['row']->prj_name);
			$content = $this->load->view('projects/projects_read', $data, TRUE);
			$content .= $this->milestones_model->get_index_list($data['row']);
			$content .= $this->tasks_model->get_index_list($data['row']);
			$content .= $this->topics_model->get_index_list($data['row']);
			$content .= $this->notes_model->get_index_list($data['row']);
			$content .= $this->files_model->get_index_list($data['row']);
			$content .= $this->projects_members_model->get_index_list($data['row']);
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
			$this->my_library->set_title($this->lang->line('projects').' / '.$data['row']->prj_name);
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
			$this->form_validation->set_rules('log_comments', 'lang:log_comments', '');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('projects/projects_update', $data, TRUE);
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
				$this->db->set('prj_owner', $this->input->post('prj_owner'));
				$this->db->set('prj_name', $this->input->post('prj_name'));
				$this->db->set('prj_description', $this->input->post('prj_description'));
				$this->db->set('prj_date_start', $this->input->post('prj_date_start'));
				$this->db->set('prj_date_due', $this->input->post('prj_date_due'));
				$this->db->set('prj_date_complete', $this->input->post('prj_date_complete'));
				$this->db->set('prj_status', $this->input->post('prj_status'));
				$this->db->set('prj_priority', $this->input->post('prj_priority'));
				$this->db->set('prj_published', checkbox2database($this->input->post('prj_published')));
				$this->db->set('prj_datemodified', date('Y-m-d H:i:s'));
				$this->db->where('prj_id', $prj_id);
				$this->db->update('projects');

				$this->my_model->save_log('project', $prj_id, $data['row']);

				$this->read($prj_id);
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
			$this->my_library->set_title($this->lang->line('projects').' / '.$data['row']->prj_name);
			$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('projects/projects_delete', $data, TRUE);
				$this->my_library->set_zone('content', $content);
			} else {
				if(count($this->storage_fields) > 0) {
					foreach($this->storage_fields as $field) {
						if($data['row']->{$field} && file_exists('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field})) {
							unlink('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field});
						}
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
				$this->db->delete('files_projects');

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
			$this->my_library->set_title($this->lang->line('projects').' / '.$data['row']->prj_name);

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
			$data['milestones'] .= build_table_repartition($this->lang->line('mln_date_start'), $values, $legend);

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
			$data['tasks'] .= build_table_repartition($this->lang->line('tsk_date_start'), $values, $legend);

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
