<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('clean_attribute')) {
	function clean_attribute($value) {
		return str_replace('"', '&quot;', $value);
	}
}

if( ! function_exists('checkbox2database')) {
	function checkbox2database($value) {
		if($value == 1) {
			return '1';
		} else {
			return '0';
		}
	}
}

if( ! function_exists('value2boolean')) {
	function value2boolean($value, $default) {
		if($value == $default) {
			return true;
		} else {
			return false;
		}
	}
}

if( ! function_exists('generate_string')) {
	function generate_string($size=8, $with_numbers=true, $with_tiny_letters=true, $with_capital_letters=false) { 
		$string = '';
		$sizeof_lchar = 0;
		$letter = '';
		$letter_tiny = 'abcdefghijklmnopqrstuvwxyz';
		$letter_capital = 'ABCDEFGHIJKLMNOPRQSTUVWXYZ';
		$letter_number = '0123456789';
		if($with_tiny_letters == true) {
			$sizeof_lchar += 26;
			if(isset($letter) == 1) {
				$letter .= $letter_tiny;
			} else {
				$letter = $letter_tiny;
			}
		}
		if($with_capital_letters == true) {
			$sizeof_lchar += 26;
			if(isset($letter) == 1) {
				$letter .= $letter_capital;
			} else {
				$letter = $letter_capital;
			}
		}
		if($with_numbers == true) {
			$sizeof_lchar += 10;
			if(isset($letter) == 1) {
				$letter .= $letter_number;
			} else {
				$letter = $letter_number;
			}
		}
		if($sizeof_lchar > 0) {
			//srand((double)microtime()*date('YmdGis'));
			for($cnt = 0; $cnt < $size; $cnt++) {
				$char_select = rand(0, $sizeof_lchar - 1);
				$string .= $letter[$char_select];
			}
		}
		return $string;
	}
}

if( ! function_exists('csv_line')) {
	function csv_line($data) {
		$fields = array();
		foreach($data as $key => $value) {
			$value = str_replace('"', '""', $value);
			$fields[$key] = '"'.utf8_decode($value).'"';
		}
		return implode(';', $fields)."\r";
	}
}

if( ! function_exists('download_header')) {
	function download_header($filename, $filesize) {
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Transfer-Encoding: binary');
		header('Pragma: public');
		header('Content-Description: File Transfer');
		header('Content-Type: application/force-download');
		header('Content-Disposition: attachment; filename="'.$filename.'";');
		header('Content-Length: '.$filesize);
	}
}

if( ! function_exists('build_table_progression')) {
	function build_table_progression($title, $data, $legend) {
		$data = array_reverse($data);
		$legend = array_reverse($legend);

		$content = '<div class="data_table">';
		$content .= '<h3>'.$title.'</h3>';

		if(count($data) > 0) {
			$total = max(array_values($data));
		} else {
			$total = 0;
		}

		$total_resume = 0;
		$lines = array();
		$prev = FALSE;
		foreach($legend as $k => $v) {
			$total_resume += $data[$k];
			if($total > 0) {
				$percent = ($data[$k] * 100) / $total;
			} else {
				$percent = 0;
			}
			if($prev) {
				$progression = round($data[$k] - $prev, 1);
			} else {
				$progression = NULL;
			}
			$prev = $data[$k];

			$lines[] = array($legend[$k], $data[$k], $progression, round($percent, 1));
		}
		$lines = array_reverse($lines);

		$content .= '<table>';
		foreach($lines as $line) {
			$content .= '<tr>';
			$content .= '<td>'.$line[0].'</td>';
			$content .= '<td class="result">'.$line[1].'</td>';
			if(is_null($line[2])) {
				$content .= '<td>&nbsp;</td>';
			} else if($line[2] == 0) {
				$content .= '<td class="result">=</td>';
			} else if($line[2] > 0) {
				$content .= '<td class="result">+'.$line[2].'</td>';
			} else if($line[2] < 0) {
				$content .= '<td class="result">'.$line[2].'</td>';
			}
			$content .= '<td style="width:100px;"><span class="color color_percent" style="width:'.$line[3].'%;">&nbsp;</span></td>';
			$content .= '</tr>';
		}
		$total_lines = count($lines);
		$content .= '<tr>';
		$content .= '<td>Total on '.$total_lines.'</td>';
		$content .= '<td class="result"><strong>'.$total_resume.'</strong></td>';
		$content .= '<td>&nbsp;</td>';
		$content .= '<td>&nbsp;</td>';
		$content .= '</tr>';
		$content .= '</table>';
		$content .= '</div>';

		return $content;
	}
}

if( ! function_exists('build_table_repartition')) {
	function build_table_repartition($title, $data, $legend) {
		$content = '<div class="data_table">';
		$content .= '<h3>'.$title.'</h3>';

		$total = array_sum($data);

		$total_resume = 0;
		$percent_resume = 0;
		$lines = array();
		foreach($legend as $k => $v) {
			$total_resume += $data[$k];
			if($total > 0) {
				$percent = ($data[$k] * 100) / $total;
			} else {
				$percent = 0;
			}
			$percent_resume += $percent;

			$lines[] = array($legend[$k], $data[$k], round($percent, 1));
		}

		$content .= '<table>';
		foreach($lines as $line) {
			$content .= '<tr>';
			$content .= '<td>'.$line[0].'</td>';
			$content .= '<td class="result">'.$line[1].'</td>';
			$content .= '<td class="result">'.$line[2].'%</td>';
			$content .= '<td style="width:100px;"><span class="color color_percent" style="width:'.$line[2].'%;">&nbsp;</span></td>';
			$content .= '</tr>';
		}
		$total_lines = count($lines);
		$content .= '<tr>';
		$content .= '<td>Total on '.$total_lines.'</td>';
		$content .= '<td class="result"><strong>'.$total_resume.'</strong></td>';
		$content .= '<td class="result"><strong>'.round($percent_resume, 1).'%</strong></td>';
		$content .= '<td>&nbsp;</td>';
		$content .= '</tr>';
		$content .= '</table>';
		$content .= '</div>';

		return $content;
	}
}

if( ! function_exists('fileperms_test')) {
	function fileperms_test($file) {
		$perms = fileperms($file);
		$fileperms = '0'.substr(sprintf('%o', $perms), -3);
		return $fileperms;
	}
}

if( ! function_exists('convert_size')) {
	function convert_size($b) {
		$size_giga = 1073741824;
		$size_mega = 1048576;
		$size_kilo = 1024;
		$r = '';
		if($b >= $size_giga) {
			$giga = floor($b/$size_giga);
			$b = $b%$size_giga;
			$r .= $giga;
			$r .= 'gb';
			if($b > 0) {
				$r .= ' ';
			}
		}
		if($b >= $size_mega) {
			$mega = floor($b/$size_mega);
			$b = $b%$size_mega;
			$r .= $mega;
			$r .= 'mb';
			if($b > 0) {
				$r .= ' ';
			}
		}
		if($b >= $size_kilo) {
			$kilo = ceil($b/$size_kilo);
			$b = $b%$size_kilo;
			$r .= $kilo;
			$r .= 'kb';
			if($b > 0) {
				$r .= ' ';
			}
		}
		if($b < $size_kilo && $b > 0) {
			$r .= $b.' ';
			$r .= 'b';
		}
		if($b == 0 && $r == '') {
			$r .= '-';
		}
		return $r;
	}
}

if( ! function_exists('directory_size')) {
	function directory_size($location, $recursive = 1) {
		$size = 0;
		if(is_dir($location)) {
			$dir = opendir($location);
			while($file = readdir($dir)) {
				if($file != '.' && $file != '..' && $file != '.htaccess' && $file != 'index.html' && $file != '.DS_Store' && $file != 'Thumbs.db' && $file != 'index.php') {
					if(@is_dir($location.'/'.$file)) {
						$size += $recursive ? directory_size($location.'/'.$file) : 0;
					} else {
						$size += filesize($location.'/'.$file);
					}
				}
			}
			closedir($dir);
			return $size;
		}
	}
}

if( ! function_exists('directory_files')) {
	function directory_files($location, $recursive = 1, $remove = '') {
		if(is_dir($location)) {
			$dir = opendir($location);
			while($file = readdir($dir)) {
				if($file != '.' && $file != '..' && $file != '.htaccess' && $file != 'index.html' && $file != '.DS_Store' && $file != 'Thumbs.db' && $file != 'index.php') {
					if(@is_dir($location.'/'.$file)) {
						directory_files($location.'/'.$file, $recursive, $remove);
					} else {
						$files[] = substr(str_replace($remove, '', $location).'/'.$file, 1);
					}
				}
			}
			closedir($dir);
		}
	}
}

if( ! function_exists('directory_files_count')) {
	function directory_files_count($location, $recursive = 1) {
		$files_count = 0;
		if(is_dir($location)) {
			$dir = opendir($location);
			while($file = readdir($dir)) {
				if($file != '.' && $file != '..' && $file != '.htaccess' && $file != 'index.html' && $file != '.DS_Store' && $file != 'Thumbs.db' && $file != 'index.php') {
					if(@is_dir($location.'/'.$file)) {
						$files_count += $recursive ? directory_files_count($location.'/'.$file, $recursive) : 0;
					} else {
						$files_count++;
					}
				}
			}
			closedir($dir);
		}
		return $files_count;
	}
}

if( ! function_exists('clean_string')) {
	function clean_string($str) {
		$allowed = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_.';

		$from = explode(',', 'À,Á,Â,Ã,Ä,Å,à,á,â,ã,ä,å,Ò,Ó,Ô,Õ,Ö,Ø,ò,ó,ô,õ,ö,ø,È,É,Ê,Ë,è,é,ê,ë,Ç,ç,Ì,Í,Î,Ï,ì,í,î,ï,Ù,Ú,Û,Ü,ù,ú,û,ü,ÿ,Ñ,ñ');
		$to = explode(',', 'A,A,A,A,A,A,a,a,a,a,a,a,O,O,O,O,O,O,o,o,o,o,o,o,E,E,E,E,e,e,e,e,C,c,I,I,I,I,i,i,i,i,U,U,U,U,u,u,u,u,y,N,n');
		$str = str_replace($from, $to, $str);

		$str = strtolower($str);
		$str = str_replace('&#039;', '-', $str);
		$str = str_replace('&quot;', '', $str);
		$str = str_replace('&amp;', '-', $str);
		$str = str_replace('&lt;', '', $str);
		$str = str_replace('&gt;', '', $str);
		$str = str_replace('\'', '-', $str);
		$str = str_replace('@', '-', $str);
		$str = str_replace('(', '-', $str);
		$str = str_replace(')', '-', $str);
		$str = str_replace('#', '-', $str);
		$str = str_replace('&', '-', $str);
		$str = str_replace(' ', '-', $str);
		$str = str_replace('_', '-', $str);
		$str = str_replace('\\', '', $str);
		$str = str_replace('/', '', $str);
		$str = str_replace('"', '', $str);
		$str = str_replace('?', '-', $str);
		$str = str_replace(':', '-', $str);
		$str = str_replace('*', '-', $str);
		$str = str_replace('|', '-', $str);
		$str = str_replace('<', '-', $str);
		$str = str_replace('>', '-', $str);
		$str = str_replace('°', '-', $str);
		$str = str_replace(',', '-', $str);

		$strlen = strlen($allowed);
		for($i=0;$i<$strlen;$i++) {
			$accepted[] = substr($allowed, $i, 1);
		}
		$newstr = '';
		$strlen = strlen($str);
		for($i=0;$i<$strlen;$i++) {
			$asc = substr($str, $i, 1);
			if(in_array($asc, $accepted)) {
				$newstr .= $asc;
			}
		}
		while(strstr($newstr, '--')) {
			$newstr = str_replace('--', '-', $newstr);
		}
		if(substr($newstr, -1) == '-') {
			$newstr = substr($newstr, 0, -1);
		}
		return $newstr;
	}
}
