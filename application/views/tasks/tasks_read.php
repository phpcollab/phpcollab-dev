<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> / <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> / <a href="<?php echo $this->my_url; ?>tasks/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/tasks'); ?>"></i><?php echo $this->lang->line('tasks'); ?></a> / <i class="fa fa-eye"></i><?php echo $row->tsk_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>tasks/update/<?php echo $row->tsk_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>
	<?php if($this->auth_library->permission('tasks/delete/any')) { ?>
		<li><a href="<?php echo $this->my_url; ?>tasks/delete/<?php echo $row->tsk_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>

	<?php } else if($this->auth_library->permission('tasks/delete/ifowner') && $row->tsk_owner == $this->phpcollab_member->mbr_id) { ?>
		<li><a href="<?php echo $this->my_url; ?>tasks/delete/<?php echo $row->tsk_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	<?php } ?>
	<li class="collapse<?php if(!$this->input->cookie($this->router->class.'-read') || $this->input->cookie($this->router->class.'-read') == 'expand') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-read-collapse"><a href="#<?php echo $this->router->class; ?>-read"><i class="fa fa-caret-square-o-up"></i><?php echo $this->lang->line('collapse'); ?></a></li>
	<li class="expand<?php if($this->input->cookie($this->router->class.'-read') == 'collapse') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-read-expand"><a href="#<?php echo $this->router->class; ?>-read"><i class="fa fa-caret-square-o-down"></i><?php echo $this->lang->line('expand'); ?></a></li>
	</ul>
</article>
<article id="<?php echo $this->router->class; ?>-read"<?php if($this->input->cookie($this->router->class.'-read') == 'collapse') { ?> style="display:none;"<?php } ?>>
	<div class="column third">
		<p>
		<span class="label"><?php echo $this->lang->line('tsk_id'); ?></span>
		<?php if($row->tsk_id) { ?><?php echo $row->tsk_id; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('tracker'); ?></span>
		<?php if($row->trk_name) { ?><?php echo $row->trk_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('milestone'); ?></span>
		<?php if($row->mln_name) { ?><a href="<?php echo $this->my_url; ?>milestones/read/<?php echo $row->mln_id; ?>"><?php echo $row->mln_name; ?></a><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('tsk_parent'); ?></span>
		<?php if($row->tsk_parent) { ?><a href="<?php echo $this->my_url; ?>tasks/read/<?php echo $row->tsk_parent; ?>"><?php echo $row->tsk_name_parent; ?></a><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('tsk_owner'); ?></span>
		<?php if($row->mbr_name) { ?><?php if($row->tsk_owner == $this->phpcollab_member->mbr_id) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/owner'); ?>" title="<?php echo $this->lang->line('icon_owner'); ?>"></i><?php } ?><?php echo $row->mbr_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('tsk_assigned'); ?></span>
		<?php if($row->mbr_name_assigned) { ?><?php if($row->tsk_assigned == $this->phpcollab_member->mbr_id) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/assigned'); ?>" title="<?php echo $this->lang->line('icon_assigned'); ?>"></i><?php } ?><?php echo $row->mbr_name_assigned; ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
	<div class="column third">
		<p>
		<span class="label"><?php echo $this->lang->line('tsk_name'); ?></span>
		<?php if($row->tsk_name) { ?><?php echo $row->tsk_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('tsk_description'); ?></span>
		<?php if($row->tsk_description) { ?><?php echo $row->tsk_description; ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
	<div class="column third">
		<p>
		<span class="label"><?php echo $this->lang->line('tsk_date_start'); ?></span>
		<?php if($row->tsk_date_start) { ?><?php echo $row->tsk_date_start; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('tsk_date_due'); ?></span>
		<?php if($row->tsk_date_due) { ?><?php if($row->tsk_date_due <= date('Y-m-d') && $row->stu_isclosed == 0) { ?><strong><?php echo $row->tsk_date_due; ?></strong><?php } else { ?><?php echo $row->tsk_date_due; ?><?php } ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('tsk_date_complete'); ?></span>
		<?php if($row->tsk_date_complete) { ?><?php echo $row->tsk_date_complete; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('tsk_status'); ?></span>
		<?php if($row->tsk_status) { ?><?php echo $this->my_model->status($row->tsk_status); ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('tsk_priority'); ?></span>
		<?php if($row->tsk_priority) { ?><span class="color_percent priority_<?php echo $row->tsk_priority; ?>" style="width:100%;"><?php echo $this->my_model->priority($row->tsk_priority); ?></span><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('tsk_completion'); ?></span>
		<?php if($row->tsk_completion) { ?><span class="color_percent" style="width:<?php echo intval($row->tsk_completion); ?>%;"><?php echo intval($row->tsk_completion); ?>%</span><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('tsk_published'); ?></span>
		<?php echo $this->lang->line('reply_'.$row->tsk_published); ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('tsk_datecreated'); ?></span>
		<?php if($row->tsk_datecreated) { ?><?php echo $this->my_library->timezone_datetime($row->tsk_datecreated); ?> (<span class="timeago" title="<?php echo $this->my_library->timezone_datetime($row->tsk_datecreated); ?>"></span>)<?php } else { ?>-<?php } ?>
		</p>
	</div>
</article>
