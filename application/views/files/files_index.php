<article class="title">
	<?php if($this->router->class == 'files') { ?>
		<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> / <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> / <i class="fa fa-<?php echo $this->config->item('phpcollab/icons/files'); ?>"></i><?php echo $this->lang->line('files'); ?> (<?php echo $position; ?>)</h2>
	<?php } else { ?>
		<h2><a href="<?php echo $this->my_url; ?>files/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/files'); ?>"></i><?php echo $this->lang->line('files'); ?></a> (<?php echo $position; ?>)</h2>
	<?php } ?>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>files/create/<?php echo $prj->prj_id; ?>"><i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></a></li>
	<?php if($this->router->class != 'files') { ?>
		<li class="collapse<?php if(!$this->input->cookie($this->router->class.'-files') || $this->input->cookie($this->router->class.'-files') == 'expand') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-files-collapse"><a href="#<?php echo $this->router->class; ?>-files"><i class="fa fa-caret-square-o-up"></i><?php echo $this->lang->line('collapse'); ?></a></li>
		<li class="expand<?php if($this->input->cookie($this->router->class.'-files') == 'collapse') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-files-expand"><a href="#<?php echo $this->router->class; ?>-files"><i class="fa fa-caret-square-o-down"></i><?php echo $this->lang->line('expand'); ?></a></li>
	<?php } ?>
	</ul>
</article>
<article id="<?php echo $this->router->class; ?>-files"<?php if($this->input->cookie($this->router->class.'-files') == 'collapse') { ?> style="display:none;"<?php } ?>>
	<?php echo form_open(current_url()); ?>
	<div class="filters">
		<div>
			<?php echo form_label($this->lang->line('fle_name'), 'files_fle_name'); ?>
			<?php echo form_input($ref_filter.'_fle_name', set_value($ref_filter.'_fle_name', $this->session->userdata($ref_filter.'_fle_name')), 'id="files_fle_name" class="inputtext"'); ?>
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
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('fle_id')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('fle_owner')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('fle_name')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('fle_size')); ?>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<tr>
			<td>
				<?php if($row->fle_owner == $this->phpcollab_member->mbr_id) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/owner'); ?>" title="<?php echo $this->lang->line('icon_owner'); ?>"></i><?php } ?>
				<?php if($row->fle_published == 1) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/published'); ?>" title="<?php echo $this->lang->line('icon_published'); ?>"></i><?php } ?>
			</td>
			<td><?php echo $row->fle_id; ?></td>
			<td><?php echo $row->mbr_name; ?></td>
			<td><a href="<?php echo $this->my_url; ?>files/read/<?php echo $row->fle_id; ?>"><?php echo $row->fle_name; ?></a></td>
			<td><?php echo convert_size($row->fle_size); ?></td>
			<th>
			<a href="<?php echo $this->my_url; ?>files/download/<?php echo $row->fle_id; ?>"><i class="fa fa-cloud-download"></i><?php echo $this->lang->line('download'); ?></a>
			<a href="<?php echo $this->my_url; ?>files/update/<?php echo $row->fle_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a>
			<?php if($this->auth_library->permission('files/delete/any')) { ?>
				<a href="<?php echo $this->my_url; ?>files/delete/<?php echo $row->fle_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a>

			<?php } else if($this->auth_library->permission('files/delete/ifowner') && $row->fle_owner == $this->phpcollab_member->mbr_id) { ?>
				<a href="<?php echo $this->my_url; ?>files/delete/<?php echo $row->fle_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a>
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
