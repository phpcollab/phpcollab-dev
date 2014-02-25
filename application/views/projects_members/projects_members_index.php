<article class="title">
	<?php if($this->router->class == 'projects_members') { ?>
		<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> | <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> | <i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects_members'); ?>"></i><?php echo $this->lang->line('projects_members'); ?> (<?php echo $position; ?>)</h2>
	<?php } else { ?>
		<h2><a href="<?php echo $this->my_url; ?>projects_members/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects_members'); ?>"></i><?php echo $this->lang->line('projects_members'); ?></a> (<?php echo $position; ?>)</h2>
	<?php } ?>
	<ul>
	<?php if($this->auth_library->permission('projects_members/manage/any')) { ?>
		<li><a href="<?php echo $this->my_url; ?>projects_members/create/<?php echo $prj->prj_id; ?>"><i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></a></li>

	<?php } else if($this->auth_library->permission('projects_members/manage/ifowner') && $prj->prj_owner == $this->phpcollab_member->mbr_id) { ?>
		<li><a href="<?php echo $this->my_url; ?>projects_members/create/<?php echo $prj->prj_id; ?>"><i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></a></li>
	<?php } ?>

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
			<?php echo form_label($this->lang->line('mbr_name'), 'projects_members_mbr_name'); ?>
			<?php echo form_input($ref_filter.'_mbr_name', set_value($ref_filter.'_mbr_name', $this->session->userdata($ref_filter.'_mbr_name')), 'id="projects_members_mbr_name" class="inputtext"'); ?>
		</div>
		<div>
			<?php echo form_label($this->lang->line('mbr_email'), 'projects_members_mbr_email'); ?>
			<?php echo form_input($ref_filter.'_mbr_email', set_value($ref_filter.'_mbr_email', $this->session->userdata($ref_filter.'_mbr_email')), 'id="projects_members_mbr_email" class="inputtext"'); ?>
		</div>
		<div>
			<?php echo form_label($this->lang->line('mbr_authorized'), 'projects_members_mbr_authorized'); ?>
			<?php echo form_dropdown($ref_filter.'_mbr_authorized', $this->my_model->dropdown_reply(), set_value($ref_filter.'_mbr_authorized', $this->session->userdata($ref_filter.'_mbr_authorized')), 'id="projects_members_mbr_authorized" class="select"'); ?>
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
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('prj_mbr_id')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('member')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('organization')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('prj_mbr_authorized')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('prj_mbr_published')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('roles')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('prj_mbr_datecreated')); ?>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<tr>
			<td class="id"><?php echo $row->prj_mbr_id; ?></td>
			<td><a href="<?php echo $this->my_url; ?>projects_members/read/<?php echo $row->prj_mbr_id; ?>"><?php echo $row->mbr_name; ?></a></td>
			<td><?php echo $row->org_name; ?></td>
			<td><?php echo $this->lang->line('reply_'.$row->prj_mbr_authorized); ?></td>
			<td><?php echo $this->lang->line('reply_'.$row->prj_mbr_published); ?></td>
			<td><?php echo $row->roles; ?></td>
			<td><?php echo $this->my_library->timezone_datetime($row->prj_mbr_datecreated); ?></td>
			<th>
				<?php if($row->mbr_id == $this->phpcollab_member->mbr_id) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/ismember'); ?>" title="<?php echo $this->lang->line('icon_ismember'); ?>"></i><?php } ?>
				<?php if($row->prj_mbr_authorized == 0) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/notauthorized'); ?>" title="<?php echo $this->lang->line('icon_notauthorized'); ?>"></i><?php } ?>
				<?php if($row->prj_mbr_published == 1) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/published'); ?>" title="<?php echo $this->lang->line('icon_published'); ?>"></i><?php } ?>
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
