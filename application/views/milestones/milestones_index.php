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
			<?php echo form_label($this->lang->line('mln_owner'), 'milestones_mln_owner'); ?>
			<?php echo form_dropdown($ref_filter.'_mln_owner', $dropdown_mln_owner, set_value($ref_filter.'_mln_owner', $this->session->userdata($ref_filter.'_mln_owner')), 'id="milestones_mln_owner" class="select"'); ?>
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
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('mln_owner')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('mln_name')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('mln_date_start')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('mln_status')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('mln_priority')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('tsk_completion')); ?>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<tr>
			<td><?php echo $row->mln_id; ?></td>
			<td><?php echo $row->mbr_name; ?></td>
			<td><a href="<?php echo $this->my_url; ?>milestones/read/<?php echo $row->mln_id; ?>"><?php echo $row->mln_name; ?></a></td>
			<td><?php echo $row->mln_date_start; ?></td>
			<td><?php echo $this->lang->line('status_'.$row->mln_status); ?></td>
			<td><span class="color_percent priority_<?php echo $row->mln_priority; ?>" style="width:100%;"><?php echo $this->lang->line('priority_'.$row->mln_priority); ?></span></td>
			<td style="width:100px;"><span class="color_percent" style="width:<?php echo intval($row->tsk_completion); ?>%;"><?php echo intval($row->tsk_completion); ?>%</span></td>
			<th>
			<a href="<?php echo $this->my_url; ?>milestones/update/<?php echo $row->mln_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a>
			<a href="<?php echo $this->my_url; ?>milestones/delete/<?php echo $row->mln_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a>
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
