<article class="title">
	<?php if($this->router->class == 'milestones') { ?>
		<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> | <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> | <i class="fa fa-<?php echo $this->config->item('phpcollab/icons/milestones'); ?>"></i><?php echo $this->lang->line('milestones'); ?> (<?php echo $position; ?>)</h2>
	<?php } else { ?>
		<h2><a href="<?php echo $this->my_url; ?>milestones/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/milestones'); ?>"></i><?php echo $this->lang->line('milestones'); ?></a> (<?php echo $position; ?>)</h2>
	<?php } ?>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>projects/calendar/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/calendar'); ?>"></i><?php echo $this->lang->line('calendar'); ?></a></li>
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
			<?php echo form_label($this->lang->line('mln_name'), 'milestones_mln_name'); ?>
			<?php echo form_input($ref_filter.'_mln_name', set_value($ref_filter.'_mln_name', $this->session->userdata($ref_filter.'_mln_name')), 'id="milestones_mln_name" class="inputtext"'); ?>
		</div>
		<div>
			<?php echo form_label($this->lang->line('mln_overdue'), 'milestones_mln_overdue'); ?>
			<?php echo form_dropdown($ref_filter.'_mln_overdue', $this->my_model->dropdown_reply(), set_value($ref_filter.'_mln_overdue', $this->session->userdata($ref_filter.'_mln_overdue')), 'id="milestones_mln_overdue" class="select"'); ?>
		</div>
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
			<?php $i = 0; ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('mln_id')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('mln_name')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('mln_date_start'), array('hide-tablet')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('mln_date_due')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('mln_status')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('tsk_completion')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('mln_priority')); ?>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<tr>
			<td class="id"><?php echo $row->mln_id; ?></td>
			<td><a href="<?php echo $this->my_url; ?>milestones/read/<?php echo $row->mln_id; ?>"><?php echo $row->mln_name; ?></a></td>
			<td class="date hide-tablet"><?php echo $row->mln_date_start; ?></td>
			<td class="date"><?php if($row->mln_overdue == 1) { ?><strong><?php echo $row->mln_date_due; ?></strong><?php } else { ?><?php echo $row->mln_date_due; ?><?php } ?></td>
			<td><?php echo $this->my_model->status($row->mln_status); ?></td>
			<td style="width:100px;"><span class="color_percent" style="width:<?php echo intval($row->tsk_completion); ?>%;"><?php echo intval($row->tsk_completion); ?>%</span></td>
			<td style="width:100px;"><span class="color_percent priority_<?php echo $row->mln_priority; ?>" style="width:100%;"><?php echo $this->my_model->priority($row->mln_priority); ?></span></td>
			<th>
				<?php if($row->stu_isclosed == 1) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/closed'); ?>" title="<?php echo $this->lang->line('icon_closed'); ?>"></i><?php } ?>
				<?php if($row->mln_owner == $this->phpcollab_member->mbr_id) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/owner'); ?>" title="<?php echo $this->lang->line('icon_owner'); ?>"></i><?php } ?>
				<?php if($row->mln_published == 1) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/published'); ?>" title="<?php echo $this->lang->line('icon_published'); ?>"></i><?php } ?>
				<?php if($row->mln_overdue == 1) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/overdue'); ?>" title="<?php echo $this->lang->line('icon_overdue'); ?>"></i><?php } ?>
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
