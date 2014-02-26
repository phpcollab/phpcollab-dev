<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar extends CI_Controller {
	public function index() {
		$data = array();

		$this->my_library->head[] = '<link href="'.base_url().'thirdparty/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css">';
		$this->my_library->head[] = '<link href="'.base_url().'thirdparty/fullcalendar/fullcalendar.print.css" rel="stylesheet" type="text/css">';

		$this->my_library->foot[] = '<script src="'.base_url().'thirdparty/fullcalendar/fullcalendar.min.js"></script>';

		$this->my_library->foot[] = '<script>
		$(document).ready(function() {
			$(\'#calendar\').fullCalendar({
				events: my_url + \'calendar/load\',
				loading: function(bool) {
					if (bool) $(\'#loading\').show();
					else $(\'#loading\').hide();
				}
				
			});
			
		});
		</script>';

		$content = $this->load->view('calendar/calendar_index', $data, TRUE);
		$this->my_library->set_zone('content', $content);
	}
	public function load() {
		$this->my_library->set_template('template_json_calendar');
		$this->my_library->set_content_type('application/json');

		$flt = array();
		$flt[] = '1';
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

		$start = date('Y-m-d', $this->input->get('start'));
		$end = date('Y-m-d', $this->input->get('end'));

		$flt[] = 'prj.prj_date_start <= \''.$end.'\'';
		$flt[] = '(prj.prj_date_due >= \''.$start.'\' OR prj.prj_date_due IS NULL)';

		if($this->auth_library->permission('projects/read/onlypublished')) {
			$flt[] = 'prj.prj_published = \'1\'';
		}

		$query = $this->db->query('SELECT prj.prj_id, prj.prj_date_start, prj.prj_date_due, prj.prj_name FROM '.$this->db->dbprefix('projects').' AS prj LEFT JOIN '.$this->db->dbprefix('projects_members').' AS prj_mbr ON prj_mbr.prj_id = prj.prj_id AND prj_mbr.prj_mbr_authorized = ? AND prj_mbr.mbr_id = ? WHERE '.implode(' AND ', $flt).' GROUP BY prj.prj_id', array(1, $this->phpcollab_member->mbr_id));
		foreach($query->result() as $row) {
			$content[] = array(
				'id' => $row->prj_id,
				'title' => $row->prj_name,
				'start' => $row->prj_date_start,
				'end' => $row->prj_date_due,
				'url' => $this->my_url.'projects/read/'.$row->prj_id,
			);
		}
		$this->my_library->set_zone('content', $content);
	}
}
