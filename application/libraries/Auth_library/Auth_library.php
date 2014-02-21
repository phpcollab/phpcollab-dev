<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_library extends CI_Driver_Library {
	public function __construct($config = array()) {
		if(!file_exists(APPPATH.'/libraries/Auth_library/drivers/Auth_library_'.$config['adapter'].'.php')) {
			$config['adapter'] = 'frontend';
		}
		$this->_adapter = $config['adapter'];
		$this->valid_drivers[] = 'auth_library_'.$config['adapter'];
	}
	public function __call($child, $arguments) {
		return call_user_func_array(array($this->{$this->_adapter}, $child), $arguments);
	}
}
