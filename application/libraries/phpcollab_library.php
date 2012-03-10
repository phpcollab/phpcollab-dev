<?php
if(!defined('BASEPATH')) {
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

class phpcollab_library {
	public function __construct($params = array()) {
		if(function_exists('date_default_timezone_set')) {
			date_default_timezone_set('Etc/UCT');
		}
		set_error_handler(array($this, 'error_handler'));
		$this->CI =& get_instance();
		$this->CI->err = array();
		$this->CI->hlp = array();
		$this->CI->msg = array();
		$this->CI->head = array();
		$this->CI->foot = array();
		$this->debug = array();
		$this->jquery = array();
		$this->base_url = base_url();
	}
	function error_handler($e_type, $e_message, $e_file, $e_line) {
		$e_type_values = array(1=>'E_ERROR', 2=>'E_WARNING', 4=>'E_PARSE', 8=>'E_NOTICE', 16=>'E_CORE_ERROR', 32=>'E_CORE_WARNING', 64=>'E_COMPILE_ERROR', 128=>'E_COMPILE_WARNING', 256=>'E_USER_ERROR', 512=>'E_USER_WARNING', 1024=>'E_USER_NOTICE', 2048=>'E_STRICT', 4096=>'E_RECOVERABLE_ERROR', 8192=>'E_DEPRECATED', 16384=>'E_USER_DEPRECATED', 30719=>'E_ALL');
		if(isset($e_type_values[$e_type]) == 1) {
			$e_type = $e_type_values[$e_type];
		}
		$key = md5($e_type.' | '.$e_message.' | '.$e_file.' | '.$e_line);
		$this->debug[$key] = $e_type.' | '.$e_message.' | '.$e_file.' | '.$e_line;
		$this->watchdog(array('e_type'=>$e_type, 'e_message'=>$e_message, 'e_file'=>$e_file, 'e_line'=>$e_line));
	}
	function watchdog($data) {
		/*$wtd_content = '';
		foreach($data as $k => $v) {
			$wtd_content .= $k.':'."\r\n";
			$wtd_content .= $v."\r\n";
		}
		$wtd_key = md5($wtd_content);
        $query = $this->CI->db->query('SELECT wtd_id FROM '.$this->CI->db->dbprefix('wtd').' AS wtd WHERE wtd.wtd_key = ? GROUP BY wtd.wtd_id', array($wtd_key));
		if($query->num_rows() > 0) {
			$this->CI->db->set('wtd_datemodified', date('Y-m-d H:i:s'));
			$this->CI->db->where('wtd_key', $wtd_key);
			$this->CI->db->update('wtd');
		} else {
			$this->CI->db->set('wtd_key', $wtd_key);
			$this->CI->db->set('wtd_content', $wtd_content);
			$this->CI->db->set('wtd_datecreated', date('Y-m-d H:i:s'));
			$this->CI->db->insert('wtd');
		}*/
	}
	function debug($data) {
		$this->debug[] = '<p><textarea>'.print_r($data, 1).'</textarea></p>';
	}
	function build_pagination($total, $per_page, $ref = 'default') {
		$this->CI->load->library('pagination');

		$config = array();
		$config['base_url'] = '?';
		$config['num_links'] = 5;
		$config['total_rows'] = $total;
		$config['per_page'] = $per_page;
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['query_string_segment'] = $ref.'_pg';
		$config['first_url'] = '?'.$config['query_string_segment'].'=1';

		$pages = ceil($total/$config['per_page']);

		$key = 'per_page_'.$config['query_string_segment'];
		if($this->CI->input->get($config['query_string_segment']) && is_numeric($this->CI->input->get($config['query_string_segment']))) {
			$page = $this->CI->input->get($config['query_string_segment']);
			$this->CI->session->set_userdata($key, $page);
		} elseif($this->CI->session->userdata($key) && is_numeric($this->CI->session->userdata($key))) {
			$_GET[$config['query_string_segment']] = $this->CI->session->userdata($key);
		} else {
			$_GET[$config['query_string_segment']] = 0;
		}
		$start = ($this->CI->input->get($config['query_string_segment']) * $config['per_page']) - $config['per_page'];
		if($start < 0 || $this->CI->input->get($config['query_string_segment']) > $pages) {
			$start = 0;
			$_GET[$config['query_string_segment']] = 1;
		}

		if($pages == 1) {
			$position = $total;
		} elseif($_GET[$config['query_string_segment']] == $pages && $pages != 0) {
			$position = ($start+1).'-'.$total.'/'.$total;
		} elseif($pages != 0) {
			$position = ($start+1).'-'.($start+$config['per_page']).'/'.$total;
		} else {
			$position = $total;
		}

		$this->CI->pagination->initialize($config);
		return array('output'=>$this->CI->pagination->create_links(), 'start'=>$start, 'limit'=>$config['per_page'], 'position'=>$position);
	}
	function get_head() {
		$head = array();
		if($this->CI->lay->lay_type == 'text/html') {
			$titles = array();
			$titles[] = 'phpCollab';
			$head[] = '<title>'.implode(' | ', $titles).'</title>';

			$head[] = '<meta charset="UTF-8">';
			$head[] = '<link href="'.$this->base_url.'themes/'.$this->CI->config->item('phpcollab_theme').'/phpcollab.css" rel="stylesheet" type="text/css">';
		}
		$head = array_merge($head, $this->CI->head);
		return implode("\r\n", $head)."\r\n";
	}
	function get_foot() {
		$foot = array();
		if($this->CI->lay->lay_type == 'text/html') {
			$this->jquery = array_unique($this->jquery);
			if(count($this->jquery) != 0) {
				foreach($this->jquery as $v) {
					if(file_exists('thirdparty/jquery/scripts/'.$v.'.min.js')) {
						$foot[] = '<script type="text/javascript" src="'.$this->base_url.'thirdparty/jquery/scripts/'.$v.'.min.js" charset="UTF-8"></script>';
					} elseif(file_exists('thirdparty/jquery/scripts/'.$v.'.js')) {
						$foot[] = '<script type="text/javascript" src="'.$this->base_url.'thirdparty/jquery/scripts/'.$v.'.js" charset="UTF-8"></script>';
					}
				}
				if(file_exists('assets/phpcollab.js')) {
					$foot[] = '<script src="'.$this->base_url.'assets/phpcollab.js" type="text/javascript"></script>';
				} elseif(file_exists('assets/phpcollab.dist.js')) {
					$foot[] = '<script src="'.$this->base_url.'assets/phpcollab.dist.js" type="text/javascript"></script>';
				}
			}
		}
		$foot = array_merge($foot, $this->CI->foot);
		return implode("\r\n", $foot)."\r\n";
	}
	function jquery_load($k) {
		$this->jquery[] = $k;
	}
	function get_debug() {
		$debug = '';
		if($this->CI->lay->lay_type == 'text/html') {
			if($this->CI->config->item('phpcollab_debug')) {
				$debug = '<div id="box-debug">';
				$debug .= '<h1>Debug</h1>';
				$debug .= '<div class="display">';
			
				$debug .= '<p>elapsed time: '.$this->CI->benchmark->elapsed_time().'</p>';
				if(function_exists('memory_get_peak_usage')) {
					$debug .= '<p>memory peak usage: '.number_format(memory_get_peak_usage(), 0, '.', ' ').'</p>';
				}
				if(function_exists('memory_get_usage')) {
					$debug .= '<p>memory usage: '.number_format(memory_get_usage(), 0, '.', ' ').'</p>';
				}
	
				if(count($this->debug) != 0) {
					foreach($this->debug as $item) {
						$debug .= '<p>'.$item.'</p>';
					}
				}

				$debug .= '<h2>queries ('.count($this->CI->db->queries).')</h2>';
				foreach($this->CI->db->queries as $query) {
					$debug .= '<p>'.$query.'</p>';
				}
			
				$debug .= '</div>';
				$debug .= '</div>';
			}
		}
		return $debug."\r\n";
	}
}
