<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>organizations"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/organizations'); ?>"></i><?php echo $this->lang->line('organizations'); ?></a> | <i class="fa fa-eye"></i><?php echo $row->org_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>organizations/statistics/<?php echo $row->org_id; ?>"><i class="fa fa-bar-chart-o"></i><?php echo $this->lang->line('statistics'); ?></a></li>
	<?php if($row->action_update) { ?><li><a href="<?php echo $this->my_url; ?>organizations/update/<?php echo $row->org_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li><?php } ?>
	<?php if($row->org_system == 0 && $row->action_delete) { ?><li><a href="<?php echo $this->my_url; ?>organizations/delete/<?php echo $row->org_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li><?php } ?>
	<li class="collapse<?php if(!$this->input->cookie($this->router->class.'-read') || $this->input->cookie($this->router->class.'-read') == 'expand') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-read-collapse"><a href="#<?php echo $this->router->class; ?>-read"><i class="fa fa-caret-square-o-up"></i><?php echo $this->lang->line('collapse'); ?></a></li>
	<li class="expand<?php if($this->input->cookie($this->router->class.'-read') == 'collapse') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-read-expand"><a href="#<?php echo $this->router->class; ?>-read"><i class="fa fa-caret-square-o-down"></i><?php echo $this->lang->line('expand'); ?></a></li>
	</ul>
</article>
<article id="<?php echo $this->router->class; ?>-read"<?php if($this->input->cookie($this->router->class.'-read') == 'collapse') { ?> style="display:none;"<?php } ?>>
	<div class="column third">
		<p>
		<span class="label"><?php echo $this->lang->line('org_id'); ?></span>
		<?php if($row->org_id) { ?><?php echo $row->org_id; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('org_owner'); ?></span>
		<?php if($row->mbr_name) { ?><?php if($row->org_owner == $this->phpcollab_member->mbr_id) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/owner'); ?>" title="<?php echo $this->lang->line('icon_owner'); ?>"></i><?php } ?><?php echo $row->mbr_name; ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
	<div class="column third">
		<p>
		<span class="label"><?php echo $this->lang->line('org_name'); ?></span>
		<?php if($row->org_name) { ?><?php echo $row->org_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('org_description'); ?></span>
		<?php if($row->org_description) { ?><?php echo nl2br($row->org_description); ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
	<div class="column third">
		<p>
		<span class="label"><?php echo $this->lang->line('org_authorized'); ?></span>
		<?php echo $this->lang->line('reply_'.$row->org_authorized); ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('tsk_completion'); ?></span>
		<span class="color_percent" style="width:<?php echo intval($row->tsk_completion); ?>%;"><?php echo intval($row->tsk_completion); ?>%</span>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('org_datecreated'); ?></span>
		<?php if($row->org_datecreated) { ?><?php echo $this->my_library->timezone_datetime($row->org_datecreated); ?> (<span class="timeago" title="<?php echo $this->my_library->timezone_datetime($row->org_datecreated); ?>"></span>)<?php } else { ?>-<?php } ?>
		</p>
	</div>
</article>

<?php echo $this->members_model->get_index_list($row); ?>

<?php if($this->auth_library->permission('projects/index')) { ?><?php echo $this->projects_model->get_index_list($row); ?><?php } ?>

<?php echo $this->my_model->get_logs('organization', $row->org_id); ?>
