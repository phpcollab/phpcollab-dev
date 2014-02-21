<article class="title">
	<?php if($this->router->class == 'tasks') { ?>
		<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> / <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> / <i class="fa fa-<?php echo $this->config->item('phpcollab/icons/tasks'); ?>"></i><?php echo $this->lang->line('tasks'); ?> (<?php echo $position; ?>)</h2>
	<?php } else { ?>
		<h2><a href="<?php echo $this->my_url; ?>tasks/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/tasks'); ?>"></i><?php echo $this->lang->line('tasks'); ?></a> (<?php echo $position; ?>)</h2>
	<?php } ?>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>tasks/create/<?php echo $prj->prj_id; ?><?php if($this->router->class == 'milestones') { ?>?mln_id=<?php echo $mln->mln_id; ?><?php } ?>"><i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></a></li>
	<?php if($this->router->class != 'tasks') { ?>
		<li class="collapse<?php if(!$this->input->cookie($this->router->class.'-tasks') || $this->input->cookie($this->router->class.'-tasks') == 'expand') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-tasks-collapse"><a href="#<?php echo $this->router->class; ?>-tasks"><i class="fa fa-caret-square-o-up"></i><?php echo $this->lang->line('collapse'); ?></a></li>
		<li class="expand<?php if($this->input->cookie($this->router->class.'-tasks') == 'collapse') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-tasks-expand"><a href="#<?php echo $this->router->class; ?>-tasks"><i class="fa fa-caret-square-o-down"></i><?php echo $this->lang->line('expand'); ?></a></li>
	<?php } ?>
	</ul>
</article>
<article id="<?php echo $this->router->class; ?>-tasks"<?php if($this->input->cookie($this->router->class.'-tasks') == 'collapse') { ?> style="display:none;"<?php } ?>>
	<?php echo form_open(current_url()); ?>
	<div class="filters">
		<div>
			<?php echo form_label($this->lang->line('tracker'), 'tasks_trk_id'); ?>
			<?php echo form_dropdown($ref_filter.'_trk_id', $dropdown_trk_id, set_value($ref_filter.'_trk_id', $this->session->userdata($ref_filter.'_trk_id')), 'id="tasks_trk_id" class="select"'); ?>
		</div>
		<?php if($this->router->class != 'milestones') { ?>
			<div>
				<?php echo form_label($this->lang->line('milestone'), 'tasks_mln_id'); ?>
				<?php echo form_dropdown($ref_filter.'_mln_id', $dropdown_mln_id, set_value($ref_filter.'_mln_id', $this->session->userdata($ref_filter.'_mln_id')), 'id="tasks_mln_id" class="select"'); ?>
			</div>
		<?php } ?>
		<div>
			<?php echo form_label($this->lang->line('tsk_assigned'), 'tasks_tsk_assigned'); ?>
			<?php echo form_dropdown($ref_filter.'_tsk_assigned', $dropdown_tsk_assigned, set_value($ref_filter.'_tsk_assigned', $this->session->userdata($ref_filter.'_tsk_assigned')), 'id="tasks_tsk_assigned" class="select"'); ?>
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
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('tsk_id')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('tracker')); ?>
			<?php if($this->router->class != 'milestones') { ?>
				<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('milestone')); ?>
			<?php } ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('tsk_assigned')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('tsk_name')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('tsk_date_start')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('tsk_status')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('tsk_priority')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('tsk_completion')); ?>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<tr>
			<td><?php echo $row->tsk_id; ?></td>
			<td><?php echo $row->trk_name; ?></td>
			<?php if($this->router->class != 'milestones') { ?>
				<td><a href="<?php echo $this->my_url; ?>milestones/read/<?php echo $row->mln_id; ?>"><?php echo $row->mln_name; ?></a></td>
			<?php } ?>
			<td><?php echo $row->mbr_name_assigned; ?></td>
			<td><a href="<?php echo $this->my_url; ?>tasks/read/<?php echo $row->tsk_id; ?>"><?php echo $row->tsk_name; ?></a></td>
			<td><?php echo $row->tsk_date_start; ?></td>
			<td><?php echo $this->lang->line('status_'.$row->tsk_status); ?></td>
			<td><span class="color_percent priority_<?php echo $row->tsk_priority; ?>" style="width:100%;"><?php echo $this->lang->line('priority_'.$row->tsk_priority); ?></span></td>
			<td style="width:100px;"><span class="color_percent" style="width:<?php echo intval($row->tsk_completion); ?>%;"><?php echo intval($row->tsk_completion); ?>%</span></td>
			<th>
			<a href="<?php echo $this->my_url; ?>tasks/update/<?php echo $row->tsk_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a>
			<a href="<?php echo $this->my_url; ?>tasks/delete/<?php echo $row->tsk_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a>
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
