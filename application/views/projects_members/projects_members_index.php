<article class="title">
	<?php if($this->router->class == 'projects_members') { ?>
		<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-leaf"></i><?php echo $this->lang->line('projects'); ?></a> / <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-leaf"></i><?php echo $prj->prj_name; ?></a> / <i class="fa fa-rocket"></i><?php echo $this->lang->line('projects_members'); ?> (<?php echo $position; ?>)</h2>
	<?php } else { ?>
		<h2><a href="<?php echo $this->my_url; ?>projects_members/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-rocket"></i><?php echo $this->lang->line('projects_members'); ?></a> (<?php echo $position; ?>)</h2>
	<?php } ?>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>projects_members/create/<?php echo $prj->prj_id; ?>"><i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></a></li>
	<?php if($this->router->class != 'projects_members') { ?>
		<li class="collapse<?php if(!$this->input->cookie($this->router->class.'-projects_members') || $this->input->cookie($this->router->class.'-projects_members') == 'expand') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-projects_members-collapse"><a href="#<?php echo $this->router->class; ?>-projects_members"><i class="fa fa-caret-square-o-up"></i><?php echo $this->lang->line('collapse'); ?></a></li>
		<li class="expand<?php if($this->input->cookie($this->router->class.'-projects_members') == 'collapse') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-projects_members-expand"><a href="#<?php echo $this->router->class; ?>-projects_members"><i class="fa fa-caret-square-o-down"></i><?php echo $this->lang->line('expand'); ?></a></li>
	<?php } ?>
	</ul>
</article>
<article id="<?php echo $this->router->class; ?>-projects_members"<?php if($this->input->cookie($this->router->class.'-projects_members') == 'collapse') { ?> style="display:none;"<?php } ?>>
	<?php echo form_open(current_url()); ?>
	<div class="filters">
		<div>
			<?php echo form_label($this->lang->line('mbr_id'), 'projects_members_mbr_id'); ?>
			<?php echo form_dropdown($this->router->class.'_projects_members_mbr_id', $dropdown_mbr_id, set_value($this->router->class.'_projects_members_mbr_id', $this->session->userdata($this->router->class.'_projects_members_mbr_id')), 'id="projects_members_mbr_id" class="select"'); ?>
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
			<?php $this->my_library->display_column($this->router->class.'_projects_members', $columns[$i++], $this->lang->line('prj_mbr_id')); ?>
			<?php $this->my_library->display_column($this->router->class.'_projects_members', $columns[$i++], $this->lang->line('mbr_id')); ?>
			<?php $this->my_library->display_column($this->router->class.'_projects_members', $columns[$i++], $this->lang->line('mbr_name')); ?>
			<?php $this->my_library->display_column($this->router->class.'_projects_members', $columns[$i++], $this->lang->line('prj_mbr_authorized')); ?>
			<?php $this->my_library->display_column($this->router->class.'_projects_members', $columns[$i++], $this->lang->line('prj_mbr_published')); ?>
			<?php $this->my_library->display_column($this->router->class.'_projects_members', $columns[$i++], $this->lang->line('prj_mbr_datecreated')); ?>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<tr>
			<td><a href="<?php echo $this->my_url; ?>projects_members/read/<?php echo $row->prj_mbr_id; ?>"><?php echo $row->prj_mbr_id; ?></a></td>
			<td><?php echo $row->mbr_id; ?></td>
			<td><?php echo $row->mbr_name; ?></td>
			<td><?php echo $this->lang->line('reply_'.$row->prj_mbr_authorized); ?></td>
			<td><?php echo $this->lang->line('reply_'.$row->prj_mbr_published); ?></td>
			<td><?php echo $row->prj_mbr_datecreated; ?></td>
			<th>
			<a href="<?php echo $this->my_url; ?>projects_members/update/<?php echo $row->prj_mbr_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a>
			<a href="<?php echo $this->my_url; ?>projects_members/delete/<?php echo $row->prj_mbr_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a>
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
