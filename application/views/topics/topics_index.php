<article class="title">
	<?php if($this->router->class == 'topics') { ?>
		<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> | <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> | <i class="fa fa-<?php echo $this->config->item('phpcollab/icons/topics'); ?>"></i><?php echo $this->lang->line('topics'); ?> (<?php echo $position; ?>)</h2>
	<?php } else { ?>
		<h2><a href="<?php echo $this->my_url; ?>topics/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/topics'); ?>"></i><?php echo $this->lang->line('topics'); ?></a> (<?php echo $position; ?>)</h2>
	<?php } ?>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>topics/create/<?php echo $prj->prj_id; ?>"><i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></a></li>
	<?php if($this->router->class != 'topics') { ?>
		<li class="collapse<?php if(!$this->input->cookie($this->router->class.'-topics') || $this->input->cookie($this->router->class.'-topics') == 'expand') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-topics-collapse"><a href="#<?php echo $this->router->class; ?>-topics"><i class="fa fa-caret-square-o-up"></i><?php echo $this->lang->line('collapse'); ?></a></li>
		<li class="expand<?php if($this->input->cookie($this->router->class.'-topics') == 'collapse') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-topics-expand"><a href="#<?php echo $this->router->class; ?>-topics"><i class="fa fa-caret-square-o-down"></i><?php echo $this->lang->line('expand'); ?></a></li>
	<?php } ?>
	</ul>
</article>
<article id="<?php echo $this->router->class; ?>-topics"<?php if($this->input->cookie($this->router->class.'-topics') == 'collapse') { ?> style="display:none;"<?php } ?>>
	<?php echo form_open(current_url()); ?>
	<div class="filters">
		<div>
			<?php echo form_label($this->lang->line('tcs_name'), 'topics_tcs_name'); ?>
			<?php echo form_input($ref_filter.'_tcs_name', set_value($ref_filter.'_tcs_name', $this->session->userdata($ref_filter.'_tcs_name')), 'id="topics_tcs_name" class="inputtext"'); ?>
		</div>
		<div>
			<?php echo form_label($this->lang->line('tcs_status'), 'topics_tcs_status'); ?>
			<?php echo form_dropdown($ref_filter.'_tcs_status', $this->my_model->dropdown_status(), set_value($ref_filter.'_tcs_status', $this->session->userdata($ref_filter.'_tcs_status')), 'id="topics_tcs_status" class="select"'); ?>
		</div>
		<div>
			<?php echo form_label($this->lang->line('tcs_priority'), 'topics_tcs_priority'); ?>
			<?php echo form_dropdown($ref_filter.'_tcs_priority', $this->my_model->dropdown_priority(), set_value($ref_filter.'_tcs_priority', $this->session->userdata($ref_filter.'_tcs_priority')), 'id="topics_tcs_priority" class="select"'); ?>
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
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('tcs_id')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('tcs_name')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('tcs_owner')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('tcs_datecreated')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('last_post')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('posts')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('tcs_status')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('tcs_priority')); ?>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<tr>
			<td class="id"><?php echo $row->tcs_id; ?></td>
			<td><a href="<?php echo $this->my_url; ?>topics/read/<?php echo $row->tcs_id; ?>"><?php echo $row->tcs_name; ?></a></td>
			<td><?php echo $row->mbr_name; ?></td>
			<td><?php echo $this->my_library->timezone_datetime($row->tcs_datecreated); ?></td>
			<td><?php echo $this->my_library->timezone_datetime($row->last_post); ?> (<span class="timeago" title="<?php echo $this->my_library->timezone_datetime($row->last_post); ?>"></span>)</td>
			<td><?php echo $row->count_posts; ?></td>
			<td><?php echo $this->my_model->status($row->tcs_status); ?></td>
			<td style="width:100px;"><span class="color_percent priority_<?php echo $row->tcs_priority; ?>" style="width:100%;"><?php echo $this->my_model->priority($row->tcs_priority); ?></span></td>
			<th>
				<?php if($row->tcs_owner == $this->phpcollab_member->mbr_id) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/owner'); ?>" title="<?php echo $this->lang->line('icon_owner'); ?>"></i><?php } ?>
				<?php if($row->tcs_published == 1) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/published'); ?>" title="<?php echo $this->lang->line('icon_published'); ?>"></i><?php } ?>
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
