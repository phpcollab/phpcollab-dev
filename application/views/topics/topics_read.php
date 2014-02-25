<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> | <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> | <a href="<?php echo $this->my_url; ?>topics/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/topics'); ?>"></i><?php echo $this->lang->line('topics'); ?></a> | <i class="fa fa-eye"></i><?php echo $row->tcs_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>topics/update/<?php echo $row->tcs_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>
	<?php if($this->auth_library->permission('topics/delete/any')) { ?>
		<li><a href="<?php echo $this->my_url; ?>topics/delete/<?php echo $row->tcs_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>

	<?php } else if($this->auth_library->permission('topics/delete/ifowner') && $row->tcs_owner == $this->phpcollab_member->mbr_id) { ?>
		<li><a href="<?php echo $this->my_url; ?>topics/delete/<?php echo $row->tcs_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	<?php } ?>
	<li class="collapse<?php if(!$this->input->cookie($this->router->class.'-read') || $this->input->cookie($this->router->class.'-read') == 'expand') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-read-collapse"><a href="#<?php echo $this->router->class; ?>-read"><i class="fa fa-caret-square-o-up"></i><?php echo $this->lang->line('collapse'); ?></a></li>
	<li class="expand<?php if($this->input->cookie($this->router->class.'-read') == 'collapse') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-read-expand"><a href="#<?php echo $this->router->class; ?>-read"><i class="fa fa-caret-square-o-down"></i><?php echo $this->lang->line('expand'); ?></a></li>
	</ul>
</article>
<article id="<?php echo $this->router->class; ?>-read"<?php if($this->input->cookie($this->router->class.'-read') == 'collapse') { ?> style="display:none;"<?php } ?>>
	<div class="column third">
		<p>
		<span class="label"><?php echo $this->lang->line('tcs_id'); ?></span>
		<?php if($row->tcs_id) { ?><?php echo $row->tcs_id; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('tcs_owner'); ?></span>
		<?php if($row->mbr_name) { ?><?php if($row->tcs_owner == $this->phpcollab_member->mbr_id) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/owner'); ?>" title="<?php echo $this->lang->line('icon_owner'); ?>"></i><?php } ?><?php echo $row->mbr_name; ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
	<div class="column third">
		<p>
		<span class="label"><?php echo $this->lang->line('tcs_name'); ?></span>
		<?php if($row->tcs_name) { ?><?php echo $row->tcs_name; ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
	<div class="column third">
		<p>
		<span class="label"><?php echo $this->lang->line('tcs_status'); ?></span>
		<?php if($row->tcs_status) { ?><?php echo $this->my_model->status($row->tcs_status); ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('tcs_priority'); ?></span>
		<?php if($row->tcs_priority) { ?><span class="color_percent priority_<?php echo $row->tcs_priority; ?>" style="width:100%;"><?php echo $this->my_model->priority($row->tcs_priority); ?></span><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('tcs_published'); ?></span>
		<?php echo $this->lang->line('reply_'.$row->tcs_published); ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('tcs_datecreated'); ?></span>
		<?php if($row->tcs_datecreated) { ?><?php echo $this->my_library->timezone_datetime($row->tcs_datecreated); ?> (<span class="timeago" title="<?php echo $this->my_library->timezone_datetime($row->tcs_datecreated); ?>"></span>)<?php } else { ?>-<?php } ?>
		</p>
	</div>
</article>
