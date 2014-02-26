<article class="title">
	<h2><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?> (<?php echo $position; ?>)</h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>projects/calendar"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/calendar'); ?>"></i><?php echo $this->lang->line('calendar'); ?></a></li>
	<?php if($this->auth_library->permission('projects/create')) { ?><li><a href="<?php echo $this->my_url; ?>projects/create<?php if($this->router->class == 'organizations') { ?>?org_id=<?php echo $org->org_id; ?><?php } ?>"><i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></a></li><?php } ?>
	<?php if($this->router->class != 'projects') { ?>
		<li class="collapse<?php if(!$this->input->cookie($this->router->class.'-projects') || $this->input->cookie($this->router->class.'-projects') == 'expand') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-projects-collapse"><a href="#<?php echo $this->router->class; ?>-projects"><i class="fa fa-caret-square-o-up"></i><?php echo $this->lang->line('collapse'); ?></a></li>
		<li class="expand<?php if($this->input->cookie($this->router->class.'-projects') == 'collapse') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-projects-expand"><a href="#<?php echo $this->router->class; ?>-projects"><i class="fa fa-caret-square-o-down"></i><?php echo $this->lang->line('expand'); ?></a></li>
	<?php } ?>
	</ul>
</article>
<article id="<?php echo $this->router->class; ?>-projects"<?php if($this->input->cookie($this->router->class.'-projects') == 'collapse') { ?> style="display:none;"<?php } ?>>
	<?php echo form_open(current_url()); ?>
	<div class="filters">
		<div>
			<?php echo form_label($this->lang->line('prj_name'), 'projects_prj_name'); ?>
			<?php echo form_input($this->router->class.'_projects_prj_name', set_value($this->router->class.'_projects_prj_name', $this->session->userdata($this->router->class.'_projects_prj_name')), 'id="projects_prj_name" class="inputtext"'); ?>
		</div>
		<div>
			<?php echo form_label($this->lang->line('prj_overdue'), 'projects_prj_overdue'); ?>
			<?php echo form_dropdown($this->router->class.'_projects_prj_overdue', $this->my_model->dropdown_reply(), set_value($this->router->class.'_projects_prj_overdue', $this->session->userdata($this->router->class.'_projects_prj_overdue')), 'id="projects_prj_overdue" class="select"'); ?>
		</div>
		<div>
			<?php echo form_label($this->lang->line('stu_isclosed'), 'projects_stu_isclosed'); ?>
			<?php echo form_dropdown($this->router->class.'_projects_stu_isclosed', $this->my_model->dropdown_reply(), set_value($this->router->class.'_projects_stu_isclosed', $this->session->userdata($this->router->class.'_projects_stu_isclosed')), 'id="projects_stu_isclosed" class="select"'); ?>
		</div>
		<div>
			<?php echo form_label($this->lang->line('prj_status'), 'tasks_prj_status'); ?>
			<?php echo form_dropdown($this->router->class.'_projects_prj_status', $this->my_model->dropdown_status(), set_value($this->router->class.'_projects_prj_status', $this->session->userdata($this->router->class.'_projects_prj_status')), 'id="tasks_prj_status" class="select"'); ?>
		</div>
		<div>
			<?php echo form_label($this->lang->line('prj_priority'), 'tasks_prj_priority'); ?>
			<?php echo form_dropdown($this->router->class.'_projects_prj_priority', $this->my_model->dropdown_priority(), set_value($this->router->class.'_projects_prj_priority', $this->session->userdata($this->router->class.'_projects_prj_priority')), 'id="tasks_prj_priority" class="select"'); ?>
		</div>
		<div>
			<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</div>
	</div>
	<?php echo form_close(); ?>
	<?php if($rows) { ?>
	<table>
		<thead>
		<tr>
			<?php $i = 0; ?>
			<?php $this->my_library->display_column($this->router->class.'_projects', $columns[$i++], $this->lang->line('prj_id')); ?>
			<?php $this->my_library->display_column($this->router->class.'_projects', $columns[$i++], $this->lang->line('prj_name')); ?>
			<?php if($this->router->class != 'organizations') { ?>
				<?php $this->my_library->display_column($this->router->class.'_projects', $columns[$i++], $this->lang->line('organization')); ?>
			<?php } ?>
			<?php $this->my_library->display_column($this->router->class.'_projects', $columns[$i++], $this->lang->line('prj_date_start')); ?>
			<?php $this->my_library->display_column($this->router->class.'_projects', $columns[$i++], $this->lang->line('prj_date_due')); ?>
			<?php $this->my_library->display_column($this->router->class.'_projects', $columns[$i++], $this->lang->line('prj_status')); ?>
			<?php $this->my_library->display_column($this->router->class.'_projects', $columns[$i++], $this->lang->line('tsk_completion')); ?>
			<?php $this->my_library->display_column($this->router->class.'_projects', $columns[$i++], $this->lang->line('prj_priority')); ?>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<tr>
			<td class="id"><?php echo $row->prj_id; ?></td>
			<td><a href="<?php echo $this->my_url; ?>projects/read/<?php echo $row->prj_id; ?>"><?php echo $row->prj_name; ?></a></td>
			<?php if($this->router->class != 'organizations') { ?>
				<td><?php echo $row->org_name; ?></td>
			<?php } ?>
			<td><?php echo $row->prj_date_start; ?></td>
			<td><?php if($row->prj_overdue == 1) { ?><strong><?php echo $row->prj_date_due; ?></strong><?php } else { ?><?php echo $row->prj_date_due; ?><?php } ?></td>
			<td><?php echo $this->my_model->status($row->prj_status); ?></td>
			<td style="width:100px;"><span class="color_percent" style="width:<?php echo intval($row->tsk_completion); ?>%;"><?php echo intval($row->tsk_completion); ?>%</span></td>
			<td style="width:100px;"><span class="color_percent priority_<?php echo $row->prj_priority; ?>" style="width:100%;"><?php echo $this->my_model->priority($row->prj_priority); ?></span></td>
			<th>
				<?php if($row->prj_owner == $this->phpcollab_member->mbr_id) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/owner'); ?>" title="<?php echo $this->lang->line('icon_owner'); ?>"></i><?php } ?>
				<?php if($row->ismember == 1) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/ismember'); ?>" title="<?php echo $this->lang->line('icon_ismember'); ?>"></i><?php } ?>
				<?php if($row->prj_published == 1) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/published'); ?>" title="<?php echo $this->lang->line('icon_published'); ?>"></i><?php } ?>
				<?php if($row->prj_overdue == 1) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/overdue'); ?>" title="<?php echo $this->lang->line('icon_overdue'); ?>"></i><?php } ?>
			</th>
		</tr>
		<?php } ?>
		</tbody>
	</table>
	<div class="paging">
		<?php echo $pagination; ?>
	</div>
	<?php } ?>
</article>
