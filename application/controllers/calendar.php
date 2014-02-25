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
		$this->my_library->set_template('template_json');
		$this->my_library->set_content_type('application/json');

		$year = date('Y');
		$month = date('m');

		$content =array(
			array(
				'id' => 111,
				'title' => "Event1",
				'start' => "$year-$month-10",
				'url' => "http://yahoo.com/"
			),
			
			array(
				'id' => 222,
				'title' => "Event2",
				'start' => "$year-$month-20",
				'end' => "$year-$month-22",
				'url' => "http://yahoo.com/"
			)
		
		);
		echo json_encode($content);exit(0);
		$this->my_library->set_zone('content', $content);
	}
}
