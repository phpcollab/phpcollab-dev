<div id="box-breadcrumbs">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>administration"><?php echo $this->lang->line('administration'); ?></a></li>
<li><?php echo $this->lang->line('company_details'); ?></li>
</ul>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('system_information'); ?></h1>
<div class="display">

<h2><?php echo $this->lang->line('product_information'); ?></h2>
<div class="box2">
<p><span class="label">Theme</span><?php echo $this->config->item('phpcollab_theme'); ?></p>
</div>

<h2><?php echo $this->lang->line('system_properties'); ?></h2>
<div class="box2">
<p><span class="label">PHP Version</span><?php echo phpversion(); ?></p>
<p><span class="label">MySql version</span><?php echo $this->db->conn_id->client_info; ?></p>
<p><span class="label">extension_dir</span><?php echo ini_get('extension_dir'); ?></p>
<p><span class="label">Loaded extensions</span><?php echo implode(', ', get_loaded_extensions()); ?></p>
<p><span class="label">include_path</span><?php echo ini_get('include_path'); ?></p>
<p><span class="label">upload_max_filesize</span><?php echo ini_get('upload_max_filesize'); ?></p>
<p><span class="label">session.id</span><?php echo $this->session->userdata('session_id'); ?></p>
<p><span class="label">HTTP_HOST</span><?php echo $_SERVER['HTTP_HOST']; ?></p>
<p><span class="label">PATH_TRANSLATED</span><?php echo $_SERVER['PATH_TRANSLATED']; ?></p>
<p><span class="label">SERVER_NAME</span><?php echo $_SERVER['SERVER_NAME']; ?></p>
<p><span class="label">SERVER_PORT</span><?php echo $_SERVER['SERVER_PORT']; ?></p>
<p><span class="label">SERVER_SOFTWARE</span><?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>
<p><span class="label">SERVER_OS</span><?php echo PHP_OS; ?></p>
</div>

</div>
</div>
