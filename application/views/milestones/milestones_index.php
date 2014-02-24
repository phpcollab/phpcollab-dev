<article class="title">
	<?php if($this->router->class == 'milestones') { ?>
		<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> / <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> / <i class="fa fa-<?php echo $this->config->item('phpcollab/icons/milestones'); ?>"></i><?php echo $this->lang->line('milestones'); ?> (<?php echo $position; ?>)</h2>
	<?php } else { ?>
		<h2><a href="<?php echo $this->my_url; ?>milestones/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/milestones'); ?>"></i><?php echo $this->lang->line('milestones'); ?></a> (<?php echo $position; ?>)</h2>
	<?php } ?>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>milestones/create/<?php echo $prj->prj_id; ?>"><i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></a></li>
	<?php if($this->router->class != 'milestones') { ?>
		<li class="collapse<?php if(!$this->input->cookie($this->router->class.'-milestones') || $this->input->cookie($this->router->class.'-milestones') == 'expand') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-milestones-collapse"><a href="#<?php echo $this->router->class; ?>-milestones"><i class="fa fa-caret-square-o-up"></i><?php echo $this->lang->line('collapse'); ?></a></li>
		<li class="expand<?php if($this->input->cookie($this->router->class.'-milestones') == 'collapse') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-milestones-expand"><a href="#<?php echo $this->router->class; ?>-milestones"><i class="fa fa-caret-square-o-down"></i><?php echo $this->lang->line('expand'); ?></a></li>
	<?php } ?>
	</ul>
</article>
<article id="<?php echo $this->router->class; ?>-milestones"<?php if($this->input->cookie($this->router->class.'-milestones') == 'collapse') { ?> style="display:none;"<?php } ?>>
	<?php echo form_open(current_url()); ?>
	<div class="filters">
		<div>
			<?php echo form_label($this->lang->line('stu_isclosed'), 'milestones_stu_isclosed'); ?>
			<?php echo form_dropdown($ref_filter.'_stu_isclosed', $this->my_model->dropdown_reply(), set_value($ref_filter.'_stu_isclosed', $this->session->userdata($ref_filter.'_stu_isclosed')), 'id="milestones_stu_isclosed" class="select"'); ?>
		</div>
		<div>
			<?php echo form_label($this->lang->line('mln_status'), 'milestoness_mln_status'); ?>
			<?php echo form_dropdown($ref_filter.'_mln_status', $this->my_model->dropdown_status(), set_value($ref_filter.'_mln_status', $this->session->userdata($ref_filter.'_mln_status')), 'id="milestoness_mln_status" class="select"'); ?>
		</div>
		<div>
			<?php echo form_label($this->lang->line('mln_priority'), 'milestoness_mln_priority'); ?>
			<?php echo form_dropdown($ref_filter.'_mln_priority', $this->my_model->dropdown_priority(), set_value($ref_filter.'_mln_priority', $this->session->userdata($ref_filter.'_mln_priority')), 'id="milestoness_mln_priority" class="select"'); ?>
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
			<th>&nbsp;</th>
			<?php $i = 0; ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('mln_id')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('mln_owner')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('mln_name')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('mln_date_start')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('mln_date_due')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('mln_status')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('mln_priority')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('tsk_completion')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('tasks')); ?>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<tr>
			<td>
				<?php if($row->mln_owner == $this->phpcollab_member->mbr_id) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/owner'); ?>" title="<?php echo $this->lang->line('icon_owner'); ?>"></i><?php } ?>
				<?php if($row->mln_published == 1) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/published'); ?>" title="<?php echo $this->lang->line('icon_published'); ?>"></i><?php } ?>
			</td>
			<td><?php echo $row->mln_id; ?></td>
			<td><?php echo $row->mbr_name; ?></td>
			<td><a href="<?php echo $this->my_url; ?>milestones/read/<?php echo $row->mln_id; ?>"><?php echo $row->mln_name; ?></a></td>
			<td><?php echo $row->mln_date_start; ?></td>
			<td><?php echo $row->mln_date_due; ?></td>
			<td><?php echo $this->my_model->status($row->mln_status); ?></td>
			<td><span class="color_percent priority_<?php echo $row->mln_priority; ?>" style="width:100%;"><?php echo $this->my_model->priority($row->mln_priority); ?></span></td>
			<td style="width:100px;"><span class="color_percent" style="width:<?php echo intval($row->tsk_completion); ?>%;"><?php echo intval($row->tsk_completion); ?>%</span></td>
			<td><?php echo $row->count_tasks; ?></td>
			<th>
			<a href="<?php echo $this->my_url; ?>milestones/update/<?php echo $row->mln_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a>
			<?php if($this->auth_library->permission('milestones/delete/any')) { ?>
				<a href="<?php echo $this->my_url; ?>milestones/delete/<?php echo $row->mln_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a>

			<?php } else if($this->auth_library->permission('milestones/delete/ifowner') && $row->mln_owner == $this->phpcollab_member->mbr_id) { ?>
				<a href="<?php echo $this->my_url; ?>milestones/delete/<?php echo $row->mln_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a>
			<?php } ?>
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
