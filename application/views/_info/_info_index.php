<article class="title">
	<h2><i class="fa fa-info-circle"></i><?php echo $this->lang->line('info'); ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>_info/php"><i class="fa fa-code"></i>phpinfo</a></li>
	</ul>
</article>
<article>
	<h2><?php echo $this->lang->line('info_client'); ?></h2>
	<div class="column half">
		<?php if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) == 1) { ?><p><span class="label">HTTP_X_CLUSTER_CLIENT_IP</span><?php echo $_SERVER['HTTP_X_CLUSTER_CLIENT_IP']; ?></p><?php } ?>
		<?php if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) == 1) { ?><p><span class="label">HTTP_X_FORWARDED_FOR</span><?php echo $_SERVER['HTTP_X_FORWARDED_FOR']; ?></p><?php } ?>
		<?php if(isset($_SERVER['HTTP_CLIENT_IP']) == 1) { ?><p><span class="label">HTTP_CLIENT_IP</span><?php echo $_SERVER['HTTP_CLIENT_IP']; ?></p><?php } ?>
		<?php if(isset($_SERVER['REMOTE_ADDR']) == 1) { ?><p><span class="label">REMOTE_ADDR</span><?php echo $_SERVER['REMOTE_ADDR']; ?></p><?php } ?>
		<?php if(isset($_SERVER['REMOTE_HOST']) == 1) { ?><p><span class="label">REMOTE_HOST</span><?php echo $_SERVER['REMOTE_HOST']; ?></p><?php } ?>
	</div>
	<div class="column half">
		<p><span class="label">HTTP_USER_AGENT</span><?php echo $_SERVER['HTTP_USER_AGENT']; ?></p>
		<p><span class="label">HTTP_ACCEPT_LANGUAGE</span><?php echo $_SERVER['HTTP_ACCEPT_LANGUAGE']; ?></p>
	</div>
</article>

<article>
	<h2><?php echo $this->lang->line('info_server'); ?></h2>
	<div class="column half">
		<?php if(function_exists('sys_getloadavg')) { ?>
		<?php $sys_getloadavg = sys_getloadavg(); ?>
		<p><span class="label">sys_getloadavg</span>&nbsp;&nbsp;1 min. / <?php echo $sys_getloadavg[0]; ?><br>&nbsp;&nbsp;5 min. / <?php echo $sys_getloadavg[1]; ?><br>15 min. / <?php echo $sys_getloadavg[2]; ?></p>
		<?php } ?>
		<p><span class="label">gmdate</span><?php echo gmdate('Y-m-d H:i:s'); ?></p>
		<p><span class="label">date (<?php echo date_default_timezone_get(); ?>)</span><?php echo date('Y-m-d H:i:s'); ?></p>
	</div>
	<div class="column half">
		<p><span class="label">PHP_OS</span><?php echo PHP_OS; ?></p>
		<p><span class="label">SERVER_ADDR</span><?php echo $_SERVER['SERVER_ADDR']; ?></p>
		<p><span class="label">HTTP_HOST</span><?php echo $_SERVER['HTTP_HOST']; ?></p>
		<p><span class="label">SERVER_NAME</span><?php echo $_SERVER['SERVER_NAME']; ?></p>
		<?php if(isset($_SERVER['HTTPS']) == 1) { ?><p><span class="label">HTTPS</span><?php echo $_SERVER['HTTPS']; ?></p><?php } ?>
	</div>
</article>

<article>
	<h2><?php echo $this->lang->line('info_database'); ?></h2>
	<div class="column half">
		<p><span class="label">dbdriver</span><?php echo $this->db->dbdriver; ?></p>
		<p><span class="label">client_info</span><?php echo $this->db->conn_id->client_info; ?></p>
		<p><span class="label">host_info</span><?php echo $this->db->conn_id->host_info; ?></p>
		<p><span class="label">server_info</span><?php echo $this->db->conn_id->server_info; ?></p>
	</div>
	<div class="column half">
		<?php if(isset($this->db->conn_id->stat) == 1) { ?><p><span class="label">stat</span><?php echo $this->db->conn_id->stat; ?></p><?php } ?>
	</div>
</article>

<article>
	<h2><?php echo $this->lang->line('info_webserver'); ?></h2>
	<div class="column half">
		<p><span class="label">SERVER_SOFTWARE</span><?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>
		<p><span class="label">DOCUMENT_ROOT</span><?php echo $_SERVER['DOCUMENT_ROOT']; ?></p>
		<p><span class="label">PHP_SELF</span><?php echo $_SERVER['PHP_SELF']; ?></p>
		<p><span class="label">SCRIPT_FILENAME</span><?php echo $_SERVER['SCRIPT_FILENAME']; ?></p>
	</div>
	<div class="column half">
		<?php if(function_exists('apache_get_modules')) { ?><p><span class="label">apache_get_modules</span><textarea class="textarea"><?php echo print_r(apache_get_modules(), 1); ?></textarea></p><?php } ?>
		<?php if(function_exists('apache_request_headers')) { ?><p><span class="label">apache_request_headers</span><textarea class="textarea"><?php echo print_r(apache_request_headers(), 1); ?></textarea></p><?php } ?>
		<?php if(function_exists('apache_response_headers')) { ?><p><span class="label">apache_response_headers</span><textarea class="textarea"><?php echo print_r(apache_response_headers(), 1); ?></textarea></p><?php } ?>
	</div>
</article>

<article>
	<h2><?php echo $this->lang->line('info_language'); ?></h2>
	<div class="column half">
		<p><span class="label">CodeIgniter</span><?php echo CI_VERSION; ?></p>
		<p><span class="label">BASEPATH</span><?php echo BASEPATH; ?></p>
		<p><span class="label">phpversion</span><?php echo phpversion(); ?></p>
		<p><span class="label">php_sapi_name</span><?php echo php_sapi_name(); ?></p>
		<p><span class="label">get_current_user</span><?php echo get_current_user(); ?></p>
		<?php if(function_exists('posix_getpwuid') && function_exists('posix_geteuid')) {$processUser = posix_getpwuid(posix_geteuid()); ?><p><span class="label">posix_getpwuid</span><?php echo implode(', ', $processUser); ?></p><?php } ?>
		<p><span class="label">session_name</span><?php echo session_name(); ?></p>
		<p><span class="label">session_id</span><?php echo session_id(); ?></p>
		<?php if(session_save_path()) { ?><p><span class="label">session_save_path</span><?php echo session_save_path(); ?></p><?php } ?>
		<?php $expire = ini_get('session.gc_maxlifetime')/60; ?><p><span class="label">session.gc_maxlifetime</span><?php echo $expire; ?> minutes</p>
		<p><span class="label">file_uploads</span><?php echo ini_get('file_uploads'); ?></p>
		<p><span class="label">upload_max_filesize</span><?php echo ini_get('upload_max_filesize'); ?></p>
		<p><span class="label">post_max_size</span><?php echo ini_get('post_max_size'); ?></p>
		<p><span class="label">memory_limit</span><?php echo ini_get('memory_limit'); ?></p>
		<?php $safe_mode = ini_get('safe_mode');if($safe_mode != '') { ?><p><span class="label">safe_mode</span><?php echo $safe_mode; ?></p><?php } ?>
		<?php $open_basedir = ini_get('open_basedir');if($open_basedir != '') { ?><p><span class="label">open_basedir</span><?php echo $open_basedir; ?></p><?php } ?>
		<?php if(function_exists('sys_get_temp_dir')) { ?><p><span class="label">sys_get_temp_dir</span><?php echo sys_get_temp_dir(); ?></p><?php } ?>
		<?php $extensions = get_loaded_extensions();sort($extensions); ?>
	</div>
	<div class="column half">
		<p><span class="label">get_loaded_extensions</span><textarea class="textarea"><?php echo print_r($extensions, 1); ?></textarea></p>
		<p><span class="label">get_included_files</span><textarea class="textarea"><?php echo str_replace($_SERVER['DOCUMENT_ROOT'], '', print_r(get_included_files(), 1)); ?></textarea></p>
		<p><span class="label">get_declared_classes</span><textarea class="textarea"><?php echo print_r(get_declared_classes(), 1); ?></textarea></p>
		<p><span class="label">$_SESSION</span><textarea class="textarea"><?php echo print_r($_SESSION, 1); ?></textarea></p>
		<p><span class="label">$_COOKIE</span><textarea class="textarea"><?php echo print_r($_COOKIE, 1); ?></textarea></p>
		<p><span class="label">$_SERVER</span><textarea class="textarea"><?php echo print_r($_SERVER, 1); ?></textarea></p>
	</div>
</article>
