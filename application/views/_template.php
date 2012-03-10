<!DOCTYPE html>
<html lang="<?php echo $this->lng->lng_code; ?>">
<head>
<?php echo $this->phpcollab_library->get_head(); ?>
</head>
<body>

<div id="box-page">
<div id="display-page">

<div id="box-pageheader">
<div id="display-pageheader">
<h1>phpCollab</h1>

<?php if($this->session->userdata('id')) { ?>
<div id="box-account">
<p>User:Administrator <a href="<?php echo base_url(); ?>logout"><?php echo $this->lang->line('logout'); ?></a> <a href="#"><?php echo $this->lang->line('preferences'); ?></a> <a href="#" target="_blank"><?php echo $this->lang->line('go_projects_site'); ?></a></p>
</div>
<?php } ?>

<div id="box-menu">
<ul>
<?php if($this->session->userdata('id')) { ?>
<li><a href="<?php echo base_url(); ?>home"><?php echo $this->lang->line('home'); ?></a></li>
<li><a href="<?php echo base_url(); ?>projects"><?php echo $this->lang->line('projects'); ?></a></li>
<li><a href="<?php echo base_url(); ?>organizations"><?php echo $this->lang->line('clients'); ?></a></li>
<li><a href="<?php echo base_url(); ?>administration"><?php echo $this->lang->line('administration'); ?></a></li>
<?php } else { ?>
<li><a href="<?php echo base_url(); ?>login"><?php echo $this->lang->line('login'); ?></a></li>
<li><a href="<?php echo base_url(); ?>license"><?php echo $this->lang->line('license'); ?></a></li>
<?php } ?>
</ul>
</div>

<?php if(isset($zones['pageheader']) == 1) { echo $zones['pageheader']; } ?>
</div>
</div>

<div id="box-pagecontent">
<div id="display-pagecontent">

	<div id="box-contentheader">
	<div id="display-contentheader">
	<?php if(isset($zones['contentheader']) == 1) { echo $zones['contentheader']; } ?>
	</div>
	</div>

	<div id="box-content">
	<div id="display-content">
	<?php echo $zones['content']; ?>
	</div>
	</div>

	<div id="box-contentfooter">
	<div id="display-contentfooter">
	<?php if(isset($zones['contentfooter']) == 1) { echo $zones['contentfooter']; } ?>
	</div>
	</div>

</div>
</div>

<div id="box-pagefooter">
<div id="display-pagefooter">
<?php if(isset($zones['pagefooter']) == 1) { echo $zones['pagefooter']; } ?>
</div>
</div>

</div>
</div>

<?php echo $this->phpcollab_library->get_debug(); ?>
<?php echo $this->phpcollab_library->get_foot(); ?>
</body>
</html>
