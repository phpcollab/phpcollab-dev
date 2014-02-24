<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Organizations extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('organizations_model');
		$this->load->model('members_model');
		$this->load->model('projects_model');

		$this->storage_table = 'organizations';
		$this->storage_fields = array();
	}
	public function index() {
		if($this->auth_library->permission('organizations/index')) {
		} else {
			redirect($this->my_url);
		}
		$this->my_library->set_title($this->lang->line('organizations'));
		$content = $this->organizations_model->get_index_list();
		$this->my_library->set_zone('content', $content);
	}
	public function create() {
		if($this->auth_library->permission('organizations/create')) {
		} else {
			redirect($this->my_url);
		}
		$this->my_library->set_title($this->lang->line('organizations').' / '.$this->lang->line('create'));
		$this->load->library('form_validation');
		$data = array();
		$data['dropdown_org_owner'] = $this->organizations_model->dropdown_org_owner();
		$this->form_validation->set_rules('org_owner', 'lang:org_owner', 'required|numeric');
		$this->form_validation->set_rules('org_name', 'lang:org_name', 'required|max_length[255]');
		$this->form_validation->set_rules('org_description', 'lang:org_description', '');
		$this->form_validation->set_rules('org_authorized', 'lang:org_authorized', 'numeric');
		if($this->form_validation->run() == FALSE) {
			$content = $this->load->view('organizations/organizations_create', $data, TRUE);
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
			$this->db->set('org_owner', $this->input->post('org_owner'));
			$this->db->set('org_name', $this->input->post('org_name'));
			$this->db->set('org_description', $this->input->post('org_description'));
			$this->db->set('org_authorized', checkbox2database($this->input->post('org_authorized')));
			$this->db->set('org_datecreated', date('Y-m-d H:i:s'));
			$this->db->insert('organizations');
			$org_id = $this->db->insert_id();

			redirect($this->my_url.'organizations/read/'.$org_id);
		}
	}
	public function read($org_id) {
		$data = array();
		$data['row'] = $this->organizations_model->get_row($org_id);
		if($data['row']) {
			if($this->auth_library->permission('organizations/read/any')) {
			} else if($this->auth_library->permission('organizations/read/ifowner') && $data['row']->org_owner == $this->phpcollab_member->mbr_id) {
			} else if($this->auth_library->permission('organizations/read/ifmember') && $data['row']->ismember == 1) {
			} else {
				redirect($this->my_url);
			}
			$this->my_library->set_title($data['row']->org_name);
			$content = $this->load->view('organizations/organizations_read', $data, TRUE);
			$content .= $this->members_model->get_index_list($data['row']);
			$content .= $this->projects_model->get_index_list($data['row']);
			$content .= $this->my_model->get_logs('organization', $org_id);
			$this->my_library->set_zone('content', $content);
		} else {
			$this->index();
		}
	}
	public function update($org_id) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->organizations_model->get_row($org_id);
		if($data['row']) {
			if($this->auth_library->permission('organizations/update/any')) {
			} else if($this->auth_library->permission('organizations/update/ifowner') && $data['row']->org_owner == $this->phpcollab_member->mbr_id) {
			} else if($this->auth_library->permission('organizations/update/ifmember') && $data['row']->ismember == 1) {
			} else {
				redirect($this->my_url);
			}
			$this->my_library->set_title($data['row']->org_name);
			$data['dropdown_org_owner'] = $this->organizations_model->dropdown_org_owner();
			if($this->auth_library->permission('organizations/update/any')) {
				$this->form_validation->set_rules('org_owner', 'lang:org_owner', 'required|numeric');
			}
			$this->form_validation->set_rules('org_name', 'lang:org_name', 'required|max_length[255]');
			$this->form_validation->set_rules('org_description', 'lang:org_description', '');
			if($data['row']->org_system == 0 && $this->auth_library->permission('organizations/update/any')) {
				$this->form_validation->set_rules('org_authorized', 'lang:org_authorized', 'numeric');
			}
			$this->form_validation->set_rules('log_comments', 'lang:log_comments', '');
			if($this->form_validation->run() == FALSE) {
				$content = $this->load->view('organizations/organizations_update', $data, TRUE);
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
				if($this->auth_library->permission('organizations/update/any')) {
					$this->db->set('org_owner', $this->input->post('org_owner'));
				}
				$this->db->set('org_name', $this->input->post('org_name'));
				$this->db->set('org_description', $this->input->post('org_description'));
				if($data['row']->org_system == 0 && $this->auth_library->permission('organizations/update/any')) {
					$this->db->set('org_authorized', checkbox2database($this->input->post('org_authorized')));
				}
				$this->db->where('org_id', $org_id);
				$this->db->update('organizations');

				$this->my_model->save_log('organization', $org_id, $data['row']);

				redirect($this->my_url.'organizations/read/'.$org_id);
			}
		} else {
			$this->index();
		}
	}
	public function delete($org_id) {
		$this->load->library('form_validation');
		$data = array();
		$data['row'] = $this->organizations_model->get_row($org_id);
		if($data['row']) {
			if($this->auth_library->permission('organizations/delete/any')) {
			} else if($this->auth_library->permission('organizations/delete/ifowner') && $data['row']->org_owner == $this->phpcollab_member->mbr_id) {
			} else {
				redirect($this->my_url);
			}
			if($data['row']->org_system == 0) {
				$this->my_library->set_title($data['row']->org_name);
				$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
				if($this->form_validation->run() == FALSE) {
					$content = $this->load->view('organizations/organizations_delete', $data, TRUE);
					$this->my_library->set_zone('content', $content);
				} else {
					if(count($this->storage_fields) > 0) {
						foreach($this->storage_fields as $field) {
							if($data['row']->{$field} && file_exists('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field})) {
								unlink('./storage/'.$this->storage_table.'/'.$field.'/'.$data['row']->{$field});
							}
						}
					}
					$this->db->where('org_id', $org_id);
					$this->db->delete('organizations');
					$this->index();
				}
			} else {
				$this->index();
			}
		} else {
			$this->index();
		}
	}
	public function statistics($org_id) {
		$data = array();
		$data['row'] = $this->organizations_model->get_row($org_id);
		if($data['row']) {
			$this->my_library->set_title($data['row']->org_name);
			$data['tasks'] = '';

			$legend = array();
			$values = array();
			$query = $this->db->query('SELECT trk.trk_name AS ref, COUNT(DISTINCT(tsk.tsk_id)) AS nb FROM '.$this->db->dbprefix('tasks').' AS tsk LEFT JOIN '.$this->db->dbprefix('trackers').' AS trk ON trk.trk_id = tsk.trk_id WHERE tsk.prj_id IN(SELECT prj.prj_id FROM '.$this->db->dbprefix('projects').' AS prj WHERE prj.org_id = ?) GROUP BY ref ORDER BY nb DESC', array($org_id));
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
			$query = $this->db->query('SELECT prj.prj_name AS ref, prj.prj_id AS id, COUNT(DISTINCT(tsk.tsk_id)) AS nb FROM '.$this->db->dbprefix('tasks').' AS tsk LEFT JOIN '.$this->db->dbprefix('projects').' AS prj ON prj.prj_id = tsk.prj_id WHERE tsk.prj_id IN(SELECT prj.prj_id FROM '.$this->db->dbprefix('projects').' AS prj WHERE prj.org_id = ?) GROUP BY ref ORDER BY nb DESC', array($org_id));
			if($query->num_rows() > 0) {
				$current_month = date('Y-m');
				foreach($query->result() as $row) {
					if($row->ref) {
						$legend[] = '<a href="'.$this->my_url.'projects/statistics/'.$row->id.'">'.$row->ref.'</a>';
					} else {
						$legend[] = '-';
					}
					$values[] = $row->nb;
				}
			}
			$data['tasks'] .= build_table_repartition($this->lang->line('project'), $values, $legend);

			$legend = array();
			$values = array();
			$query = $this->db->query('SELECT mbr.mbr_name AS ref, mbr.mbr_id AS id, COUNT(DISTINCT(tsk.tsk_id)) AS nb FROM '.$this->db->dbprefix('tasks').' AS tsk LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = tsk.tsk_owner WHERE tsk.prj_id IN(SELECT prj.prj_id FROM '.$this->db->dbprefix('projects').' AS prj WHERE prj.org_id = ?) GROUP BY ref ORDER BY nb DESC', array($org_id));
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
			$query = $this->db->query('SELECT mbr.mbr_name AS ref, mbr.mbr_id AS id, COUNT(DISTINCT(tsk.tsk_id)) AS nb FROM '.$this->db->dbprefix('tasks').' AS tsk LEFT JOIN '.$this->db->dbprefix('members').' AS mbr ON mbr.mbr_id = tsk.tsk_assigned WHERE tsk.prj_id IN(SELECT prj.prj_id FROM '.$this->db->dbprefix('projects').' AS prj WHERE prj.org_id = ?) GROUP BY ref ORDER BY nb DESC', array($org_id));
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
			$query = $this->db->query('SELECT SUBSTRING(tsk.tsk_date_start, 1, 7) AS ref, COUNT(DISTINCT(tsk.tsk_id)) AS nb FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.prj_id IN(SELECT prj.prj_id FROM '.$this->db->dbprefix('projects').' AS prj WHERE prj.org_id = ?) GROUP BY ref ORDER BY ref DESC', array($org_id));
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
			$query = $this->db->query('SELECT tsk.tsk_status AS ref, COUNT(DISTINCT(tsk.tsk_id)) AS nb FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.prj_id IN(SELECT prj.prj_id FROM '.$this->db->dbprefix('projects').' AS prj WHERE prj.org_id = ?) GROUP BY ref ORDER BY nb DESC', array($org_id));
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
			$query = $this->db->query('SELECT tsk.tsk_priority AS ref, COUNT(DISTINCT(tsk.tsk_id)) AS nb FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.prj_id IN(SELECT prj.prj_id FROM '.$this->db->dbprefix('projects').' AS prj WHERE prj.org_id = ?) GROUP BY ref ORDER BY nb DESC', array($org_id));
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
			$query = $this->db->query('SELECT tsk.tsk_completion AS ref, COUNT(DISTINCT(tsk.tsk_id)) AS nb FROM '.$this->db->dbprefix('tasks').' AS tsk WHERE tsk.prj_id IN(SELECT prj.prj_id FROM '.$this->db->dbprefix('projects').' AS prj WHERE prj.org_id = ?) GROUP BY ref ORDER BY ref ASC', array($org_id));
			if($query->num_rows() > 0) {
				$current_month = date('Y-m');
				foreach($query->result() as $row) {
					$legend[] = $row->ref.'%';
					$values[] = $row->nb;
				}
			}
			$data['tasks'] .= build_table_repartition($this->lang->line('tsk_completion'), $values, $legend);

			$content = $this->load->view('organizations/organizations_statistics', $data, TRUE);
			$this->my_library->set_zone('content', $content);
		} else {
			redirect($this->my_url);
		}
	}
}
