<?php
if(!defined('BASEPATH')) {
	header('HTTP/1.1 403 Forbidden');
	exit(0);
}

if( ! function_exists('build_filters')) {
	function build_filters($filters) {
		$CI =& get_instance();
		$flt = array();
		$flt[] = '1';
		foreach($filters as $k =>$v) {
			$value = false;
			if($CI->input->post($k) || isset($_POST[$k]) == 1) {
				$value = $CI->input->post($k);
				$CI->session->set_userdata($k, $CI->input->post($k));
			} elseif($CI->session->userdata($k)) {
				$value = $CI->session->userdata($k);
			}
			if($value) {
				if($v[1] == 'equal') {
					$flt[] = $v[0].' = '.$CI->db->escape($value);
				}
				if($v[1] == 'like') {
					$flt[] = $v[0].' LIKE '.$CI->db->escape('%'.$value.'%');
				}
			}
		}
		return $flt;
	}
	function tinyint2boolean($value) {
		if($value == 1) {
			return true;
		} else {
			return false;
		}
	}
}
