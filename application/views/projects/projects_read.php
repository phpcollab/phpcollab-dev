<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> | <i class="fa fa-eye"></i><?php echo $row->prj_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>projects/statistics/<?php echo $row->prj_id; ?>"><i class="fa fa-bar-chart-o"></i><?php echo $this->lang->line('statistics'); ?></a></li>
	<?php if($row->action_update) { ?><li><a href="<?php echo $this->my_url; ?>projects/update/<?php echo $row->prj_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li><?php } ?>
	<?php if($row->action_delete) { ?><li><a href="<?php echo $this->my_url; ?>projects/delete/<?php echo $row->prj_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li><?php } ?>
	<li class="collapse<?php if(!$this->input->cookie($this->router->class.'-read') || $this->input->cookie($this->router->class.'-read') == 'expand') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-read-collapse"><a href="#<?php echo $this->router->class; ?>-read"><i class="fa fa-caret-square-o-up"></i><?php echo $this->lang->line('collapse'); ?></a></li>
	<li class="expand<?php if($this->input->cookie($this->router->class.'-read') == 'collapse') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-read-expand"><a href="#<?php echo $this->router->class; ?>-read"><i class="fa fa-caret-square-o-down"></i><?php echo $this->lang->line('expand'); ?></a></li>
	</ul>
</article>
<article id="<?php echo $this->router->class; ?>-read"<?php if($this->input->cookie($this->router->class.'-read') == 'collapse') { ?> style="display:none;"<?php } ?>>
	<div class="column third">
		<p>
		<span class="label"><?php echo $this->lang->line('prj_id'); ?></span>
		<?php if($row->prj_id) { ?><?php echo $row->prj_id; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('organization'); ?></span>
		<?php if($row->org_name) { ?><a href="<?php echo $this->my_url; ?>organizations/read/<?php echo $row->org_id; ?>"><?php echo $row->org_name; ?></a><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_owner'); ?></span>
		<?php if($row->mbr_name) { ?><?php if($row->prj_owner == $this->phpcollab_member->mbr_id) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/owner'); ?>" title="<?php echo $this->lang->line('icon_owner'); ?>"></i><?php } ?><?php echo $row->mbr_name; ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
	<div class="column third">
		<p>
		<span class="label"><?php echo $this->lang->line('prj_name'); ?></span>
		<?php if($row->prj_name) { ?><?php echo $row->prj_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_description'); ?></span>
		<?php if($row->prj_description) { ?><?php echo nl2br($row->prj_description); ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
	<div class="column third">
		<p>
		<span class="label"><?php echo $this->lang->line('prj_date_start'); ?></span>
		<?php if($row->prj_date_start) { ?><?php echo $row->prj_date_start; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_date_due'); ?></span>
		<?php if($row->prj_date_due) { ?><?php if($row->prj_date_due <= date('Y-m-d') && $row->stu_isclosed == 0) { ?><strong><?php echo $row->prj_date_due; ?></strong><?php } else { ?><?php echo $row->prj_date_due; ?><?php } ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_date_complete'); ?></span>
		<?php if($row->prj_date_complete) { ?><?php echo $row->prj_date_complete; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_status'); ?></span>
		<?php if($row->prj_status) { ?><?php echo $this->my_model->status($row->prj_status); ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_priority'); ?></span>
		<?php if($row->prj_priority) { ?><span class="color_percent priority_<?php echo $row->prj_priority; ?>" style="width:100%;"><?php echo $this->my_model->priority($row->prj_priority); ?></span><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('tsk_completion'); ?></span>
		<?php if($row->tsk_completion) { ?><span class="color_percent" style="width:<?php echo intval($row->tsk_completion); ?>%;"><?php echo intval($row->tsk_completion); ?>%</span><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_published'); ?></span>
		<?php echo $this->lang->line('reply_'.$row->prj_published); ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('prj_datecreated'); ?></span>
		<?php if($row->prj_datecreated) { ?><?php echo $this->my_library->timezone_datetime($row->prj_datecreated); ?> (<span class="timeago" title="<?php echo $this->my_library->timezone_datetime($row->prj_datecreated); ?>"></span>)<?php } else { ?>-<?php } ?>
		</p>
	</div>
</article>

<?php if($this->auth_library->permission('milestones/index')) { ?><?php echo $this->milestones_model->get_index_list($row); ?><?php } ?>

<?php if($this->auth_library->permission('tasks/index')) { ?><?php echo $this->tasks_model->get_index_list($row); ?><?php } ?>

<?php if($this->auth_library->permission('topics/index')) { ?><?php echo $this->topics_model->get_index_list($row); ?><?php } ?>

<?php if($this->auth_library->permission('notes/index')) { ?><?php echo $this->notes_model->get_index_list($row); ?><?php } ?>

<?php if($this->auth_library->permission('files/index')) { ?><?php echo $this->files_model->get_index_list($row); ?><?php } ?>

<?php if($row->action_read_team) { ?><?php echo $this->projects_members_model->get_index_list($row); ?><?php } ?>

<?php echo $this->my_model->get_logs('project', $row->prj_id); ?>
