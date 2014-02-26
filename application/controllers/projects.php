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
		if(!$this->auth_library->permission('projects/index')) {
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
			if(!$data['row']->action_read) {
				redirect($this->my_url);
			}
			if($this->auth_library->permission('projects/read/onlypublished') && $data['row']->prj_published == 0) {
				redirect($this->my_url);
			}
			$this->my_library->set_title($data['row']->prj_name);
			$content = $this->load->view('projects/projects_read', $data, TRUE);
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
			if(!$data['row']->action_update) {
				redirect($this->my_url);
			}
			$this->my_library->set_title($data['row']->prj_name);
			$data['dropdown_org_id'] = $this->projects_model->dropdown_org_id();
			$data['dropdown_prj_owner'] = $this->projects_model->dropdown_prj_owner();
			$this->form_validation->set_rules('org_id', 'lang:organization', 'required|numeric');
			if($this->auth_library->permission('projects/update/any')) {
				$this->form_validation->set_rules('prj_owner', 'lang:prj_owner', 'required|numeric');
			}
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
				$this->db->set('org_id', $this->input->post('org_id'));
				if($this->auth_library->permission('projects/update/any')) {
					$this->db->set('prj_owner', $this->input->post('prj_owner'));
				}
				$this->db->set('prj_name', $this->input->post('prj_name'));
				$this->db->set('prj_description', $this->input->post('prj_description'));
				$this->db->set('prj_date_start', $this->input->post('prj_date_start'));
				$this->db->set('prj_date_due', $this->input->post('prj_date_due'));
				$this->db->set('prj_date_complete', $this->input->post('prj_date_complete'));
				$this->db->set('prj_status', $this->input->post('prj_status'));
				$this->db->set('prj_priority', $this->input->post('prj_priority'));
				$this->db->set('prj_published', checkbox2database($this->input->post('prj_published')));
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
			if(!$data['row']->action_delete) {
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
			if(!$data['row']->action_read) {
				redirect($this->my_url);
			}

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
	public function calendar($prj_id = false) {
		$data = array();
		if(!$this->auth_library->permission('projects/index') && !$prj_id) {
			redirect($this->my_url);
		}
		if($prj_id) {
			$data['row'] = $this->projects_model->get_row($prj_id);
			if($data['row']) {
				if(!$data['row']->action_read) {
					redirect($this->my_url);
				}
				$url = 'projects/calendar_load/'.$prj_id;
			} else {
				$this->index();
			}
		} else {
			$url = 'projects/calendar_load';
		}

		$this->my_library->head[] = '<link href="'.base_url().'thirdparty/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css">';
		$this->my_library->head[] = '<link href="'.base_url().'thirdparty/fullcalendar/fullcalendar.print.css" rel="stylesheet" type="text/css">';

		$this->my_library->foot[] = '<script src="'.base_url().'thirdparty/fullcalendar/fullcalendar.min.js"></script>';

		$this->my_library->foot[] = '<script>
		$(document).ready(function() {
			$(\'#calendar\').fullCalendar({
				weekNumbers: true,
				aspectRatio: 2,
				events: my_url + \''.$url.'\',
				eventRender: function(event, element) {
					if($(element).hasClass(\'fc-event-start\')) {
						$(element).html(\'<i class="fa fa-\' + event.icon + \'"></i>\' + event.title);
					} else {
						$(element).html(\'... \' + event.title);
					}
				},
				loading: function(bool) {
					if (bool) $(\'#loading\').show();
					else $(\'#loading\').hide();
				}
				
			});
			
		});
		</script>';

		$content = $this->load->view('projects/projects_calendar', $data, TRUE);
		$this->my_library->set_zone('content', $content);
	}
	public function calendar_load($prj_id = false) {
		$data = array();
		if(!$this->auth_library->permission('projects/index') && !$prj_id) {
			redirect($this->my_url);
		}
		if($prj_id) {
			$data['row'] = $this->projects_model->get_row($prj_id);
			if($data['row']) {
				if(!$data['row']->action_read) {
					redirect($this->my_url);
				}
			} else {
				$this->index();
			}
		}

		$this->my_library->set_template('template_json_calendar');
		$this->my_library->set_content_type('application/json');

		$start = date('Y-m-d', $this->input->get('start'));
		$end = date('Y-m-d', $this->input->get('end'));

		if(!$prj_id) {
			$flt = array();
			$flt[] = '1';
			$flt[] = 'prj.prj_date_start <= \''.$end.'\'';
			$flt[] = '(prj.prj_date_due >= \''.$start.'\' OR prj.prj_date_due IS NULL)';

			if($this->auth_library->permission('projects/read/any')) {
			} else if($this->auth_library->permission('projects/read/ifowner') && $this->auth_library->permission('projects/read/ifmember')) {
				$flt[] = '( prj.prj_owner = \''.intval($this->phpcollab_member->mbr_id).'\' OR prj_mbr.prj_mbr_id IS NOT NULL )';
			} else if($this->auth_library->permission('projects/read/ifowner')) {
				$flt[] = 'prj.prj_owner = \''.intval($this->phpcollab_member->mbr_id).'\'';
			} else if($this->auth_library->permission('projects/read/ifmember')) {
				$flt[] = 'prj_mbr.prj_mbr_id IS NOT NULL';
			} else {
				return array();
			}

			if($this->auth_library->permission('projects/read/onlypublished')) {
				$flt[] = 'prj.prj_published = \'1\'';
			}

			$icon = $this->config->item('phpcollab/icons/projects');
			$query = $this->db->query('SELECT prj.prj_id, prj.prj_date_start, prj.prj_date_due, prj.prj_name FROM '.$this->db->dbprefix('projects').' AS prj LEFT JOIN '.$this->db->dbprefix('projects_members').' AS prj_mbr ON prj_mbr.prj_id = prj.prj_id AND prj_mbr.prj_mbr_authorized = ? AND prj_mbr.mbr_id = ? WHERE '.implode(' AND ', $flt).' GROUP BY prj.prj_id', array(1, $this->phpcollab_member->mbr_id));
			foreach($query->result() as $row) {
				$content[] = array(
					'id' => $row->prj_id,
					'icon' => $icon,
					'title' => $row->prj_name,
					'start' => $row->prj_date_start,
					'end' => $row->prj_date_due,
					'url' => $this->my_url.'projects/read/'.$row->prj_id,
				);
			}

		} else {
			$flt = array();
			$flt[] = '1';
			$flt[] = 'mln.mln_date_start <= \''.$end.'\'';
			$flt[] = '(mln.mln_date_due >= \''.$start.'\' OR mln.mln_date_due IS NULL)';

			$flt[] = 'mln.prj_id = \''.$prj_id.'\'';
			if($this->auth_library->permission('milestones/read/onlypublished')) {
				$flt[] = 'mln.mln_published = \'1\'';
			}

			$icon = $this->config->item('phpcollab/icons/milestones');
			$query = $this->db->query('SELECT mln.mln_id, mln.mln_date_start, mln.mln_date_due, mln.mln_name FROM '.$this->db->dbprefix('milestones').' AS mln WHERE '.implode(' AND ', $flt).' GROUP BY mln.mln_id', array(1, $this->phpcollab_member->mbr_id));
			foreach($query->result() as $row) {
				$content[] = array(
					'id' => $row->mln_id,
					'icon' => $icon,
					'title' => $row->mln_name,
					'start' => $row->mln_date_start,
					'end' => $row->mln_date_due,
					'url' => $this->my_url.'milestones/read/'.$row->mln_id,
				);
			}
		}

		$this->my_library->set_zone('content', $content);
	}
}
