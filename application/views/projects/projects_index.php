<article class="title">
	<h2><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?> (<?php echo $position; ?>)</h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>projects/create<?php if($this->router->class == 'organizations') { ?>?org_id=<?php echo $org->org_id; ?><?php } ?>"><i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></a></li>
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
			<?php if($this->router->class != 'organizations') { ?>
				<?php $this->my_library->display_column($this->router->class.'_projects', $columns[$i++], $this->lang->line('organization')); ?>
			<?php } ?>
			<?php $this->my_library->display_column($this->router->class.'_projects', $columns[$i++], $this->lang->line('prj_owner')); ?>
			<?php $this->my_library->display_column($this->router->class.'_projects', $columns[$i++], $this->lang->line('prj_name')); ?>
			<?php $this->my_library->display_column($this->router->class.'_projects', $columns[$i++], $this->lang->line('prj_date_start')); ?>
			<?php $this->my_library->display_column($this->router->class.'_projects', $columns[$i++], $this->lang->line('prj_status')); ?>
			<?php $this->my_library->display_column($this->router->class.'_projects', $columns[$i++], $this->lang->line('prj_priority')); ?>
			<?php $this->my_library->display_column($this->router->class.'_projects', $columns[$i++], $this->lang->line('tsk_completion')); ?>
			<?php $this->my_library->display_column($this->router->class.'_projects', $columns[$i++], $this->lang->line('prj_datecreated')); ?>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<tr>
			<td><?php echo $row->prj_id; ?></td>
			<?php if($this->router->class != 'organizations') { ?>
				<td><?php echo $row->org_name; ?></td>
			<?php } ?>
			<td><?php echo $row->mbr_name; ?></td>
			<td><a href="<?php echo $this->my_url; ?>projects/read/<?php echo $row->prj_id; ?>"><?php echo $row->prj_name; ?></a></td>
			<td><?php echo $row->prj_date_start; ?></td>
			<td><?php echo $this->lang->line('status_'.$row->prj_status); ?></td>
			<td><span class="color_percent priority_<?php echo $row->prj_priority; ?>" style="width:100%;"><?php echo $this->lang->line('priority_'.$row->prj_priority); ?></span></td>
			<td style="width:100px;"><span class="color_percent" style="width:<?php echo intval($row->tsk_completion); ?>%;"><?php echo intval($row->tsk_completion); ?>%</span></td>
			<td><?php echo $row->prj_datecreated; ?></td>
			<th>
			<a href="<?php echo $this->my_url; ?>projects/update/<?php echo $row->prj_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a>
			<a href="<?php echo $this->my_url; ?>projects/delete/<?php echo $row->prj_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a>
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
