<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_library {
	public function __construct() {
		$this->CI =& get_instance();

		$this->mode = 'codeigniter';
		$this->modes = array('codeigniter', 'emailstrategie');
		$this->priority = 3;
		$this->protocol = 'mail';
		$this->protocols = array('mail', 'sendmail', 'smtp');
		$this->salt_email = $this->CI->config->item('salt_email');
		$this->sender_email = $this->CI->config->item('sender_email');
		$this->sender_name = $this->CI->config->item('sender_name');
		$this->smtp_host = '';
		$this->smtp_user = '';
		$this->smtp_pass = '';
		$this->smtp_port = 25;
		$this->smtp_timeout = 5;
		$this->url = base_url();
	}
	function initialize($config) {
		foreach($config as $k => $v) {
			$this->{$k} = $v;
		}
	}
	function salt_email($eml_id) {
		return sha1($eml_id.$this->salt_email);
	}
	function send($to, $language, $template, $tags) {
		if(stristr($to, '@example.com')) {
		} else {
			$this->CI->load->helper('email');

			if(valid_email($to) && file_exists('emails/'.$language.'/'.$template.'.html') && in_array($this->mode, $this->modes)) {
				$this->CI->db->set('eml_to', $to);
				$this->CI->db->set('eml_language', $language);
				$this->CI->db->set('eml_template', $template);
				$this->CI->db->set('eml_datesent', date('Y-m-d H:i:s'));
				$this->CI->db->insert('_emails');
				$eml_id = $this->CI->db->insert_id();

				$message = file_get_contents('emails/'.$language.'/'.$template.'.html');

				$tags['</body>'] = '<img border="0" alt="" src="'.$this->url.'email/open/'.$this->salt_email($eml_id).'" width="1" height="1"></body>';
				$tags['href="'.$this->url] = 'href="'.$this->url.'email/click/'.$this->salt_email($eml_id).'?redirect='.$this->url;
				$tags['href="/'] = 'href="'.$this->url.'email/click/'.$this->salt_email($eml_id).'?redirect='.$this->url;
				$tags['src="/emails/'] = 'src="'.$this->url.'emails/';
				$tags['src="/medias/'] = 'src="'.$this->url.'medias/';
				$tags['src="/storage/'] = 'src="'.$this->url.'storage/';

				foreach($tags as $k => $v) {
					$message = str_replace($k, $v, $message);
				}

				preg_match_all("|<[tT][iI][tT][lL][eE](.*)>(.*)<\/[tT][iI][tT][lL][eE]>|U", $message, $matches);
				$subject = $matches[2][0];
				$subject = str_replace('&quot;', '"', $subject);

				if($this->mode == 'emailstrategie') {
				}

				if($this->mode == 'codeigniter') {
					$this->CI->load->library('email');
					$this->CI->email->clear();

					$config = array();
					$config['charset'] = 'utf-8';
					$config['mailtype'] = 'html';
					$config['priority'] = $this->priority;
					if(in_array($this->protocol, $this->protocols)) {
						$config['protocol'] = $this->protocol;
					}
					$this->CI->email->initialize($config);

					$this->CI->email->from($this->sender_email, $this->sender_name);
					$this->CI->email->to($to);
					$this->CI->email->subject($subject);
					$this->CI->email->message($message);
					$this->CI->email->set_alt_message($this->alt_message($message));
					$this->CI->email->send();
				}
			}
		}
	}
	public function emailstrategie() {
	}
	function alt_message($message) {
		$messageText = $message;
		$messageText = str_replace('&amp;', '&', $messageText);
		$messageText = str_replace('&nbsp;', ' ', $messageText);
		$messageText = str_replace('<strong>', '*', $messageText);
		$messageText = str_replace('</strong>', '*', $messageText);
		$messageText = str_replace("\t", '', $messageText);

		$result = preg_match_all("|<[aA](.*)[hH][rR][eE][fF]=[\"'](.*)[\"'](.*)>(.*)</a>|U", $messageText, $matches);
		for($i=0;$i<$result;$i++) {
			if($matches[2][$i] != $matches[4][$i] && stristr($matches[4][$i], ' alt="')) {
				preg_match_all("|(.*)[aA][lL][tT]=\"(.*)\"(.*)|U", $matches[4][$i], $matches_sub, PREG_SET_ORDER);
				$messageText = str_replace('<a'.$matches[1][$i].'href="'.$matches[2][$i].'"'.$matches[3][$i].'>'.$matches[4][$i].'</a>', $matches_sub[0][2]."\n".$matches[2][$i], $messageText);
			} else if($matches[2][$i] != $matches[4][$i]) {
				$messageText = str_replace('<a'.$matches[1][$i].'href="'.$matches[2][$i].'"'.$matches[3][$i].'>'.$matches[4][$i].'</a>', $matches[4][$i].' ('.$matches[2][$i].')', $messageText);
			} else {
				$messageText = str_replace('<a'.$matches[1][$i].'href="'.$matches[2][$i].'"'.$matches[3][$i].'>'.$matches[4][$i].'</a>', $matches[4][$i], $messageText);
			}
		}

		$result = preg_match_all("|<[iI][mM][gG](.*)[sS][rR][cC]=[\"'](.*)[\"'](.*)[aA][lL][tT]=[\"'](.*)[\"'](.*)>|U", $messageText, $matches);
		for($i=0;$i<$result;$i++) {
			if($matches[4][$i] != '') {
				$messageText = str_replace('<img'.$matches[1][$i].'src="'.$matches[2][$i].'"'.$matches[3][$i].'alt="'.$matches[4][$i].'"'.$matches[5][$i].'>', $matches[4][$i].' ('.$matches[2][$i].')', $messageText);
			}
		}

		$messageText = strip_tags($messageText);
		$messageText = stripslashes($messageText);
		$messageText = str_replace("\n\n\n", "\n\n", $messageText);
		$messageText = trim($messageText);
		return $messageText;
	}
}
