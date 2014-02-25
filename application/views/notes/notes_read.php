<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> / <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> / <a href="<?php echo $this->my_url; ?>notes/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/notes'); ?>"></i><?php echo $this->lang->line('notes'); ?></a> / <i class="fa fa-eye"></i><?php echo $row->nte_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>notes/update/<?php echo $row->nte_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>
	<?php if($this->auth_library->permission('notes/delete/any')) { ?>
		<li><a href="<?php echo $this->my_url; ?>notes/delete/<?php echo $row->nte_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>

	<?php } else if($this->auth_library->permission('notes/delete/ifowner') && $row->nte_owner == $this->phpcollab_member->mbr_id) { ?>
		<li><a href="<?php echo $this->my_url; ?>notes/delete/<?php echo $row->nte_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	<?php } ?>
	<li class="collapse<?php if(!$this->input->cookie($this->router->class.'-read') || $this->input->cookie($this->router->class.'-read') == 'expand') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-read-collapse"><a href="#<?php echo $this->router->class; ?>-read"><i class="fa fa-caret-square-o-up"></i><?php echo $this->lang->line('collapse'); ?></a></li>
	<li class="expand<?php if($this->input->cookie($this->router->class.'-read') == 'collapse') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-read-expand"><a href="#<?php echo $this->router->class; ?>-read"><i class="fa fa-caret-square-o-down"></i><?php echo $this->lang->line('expand'); ?></a></li>
	</ul>
</article>
<article id="<?php echo $this->router->class; ?>-read"<?php if($this->input->cookie($this->router->class.'-read') == 'collapse') { ?> style="display:none;"<?php } ?>>
	<div class="column half">
		<p>
		<span class="label"><?php echo $this->lang->line('nte_id'); ?></span>
		<?php if($row->nte_id) { ?><?php echo $row->nte_id; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('nte_owner'); ?></span>
		<?php if($row->mbr_name) { ?><?php if($row->nte_owner == $this->phpcollab_member->mbr_id) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/owner'); ?>" title="<?php echo $this->lang->line('icon_owner'); ?>"></i><?php } ?><?php echo $row->mbr_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('nte_name'); ?></span>
		<?php if($row->nte_name) { ?><?php echo $row->nte_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('nte_date'); ?></span>
		<?php if($row->nte_date) { ?><?php echo $row->nte_date; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('nte_published'); ?></span>
		<?php echo $this->lang->line('reply_'.$row->nte_published); ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('nte_datecreated'); ?></span>
		<?php if($row->nte_datecreated) { ?><?php echo $this->my_library->timezone_datetime($row->nte_datecreated); ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
	<div class="column half">
		<?php if($row->nte_description) { ?><?php echo $row->nte_description; ?><?php } else { ?>-<?php } ?>
	</div>
</article>
