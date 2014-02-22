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
	<?php if($rows) { ?>
	<table>
		<thead>
		<tr>
		<?php $i = 0; ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('fle_id')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('fle_owner')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('fle_name')); ?>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<tr>
			<td><?php echo $row->fle_id; ?></td>
			<td><?php echo $row->mbr_name; ?></td>
			<td><a href="<?php echo $this->my_url; ?>files/read/<?php echo $row->fle_id; ?>"><?php echo $row->fle_name; ?></a></td>
			<th>
			<a href="<?php echo $this->my_url; ?>files/download/<?php echo $row->fle_id; ?>"><i class="fa fa-cloud-download"></i><?php echo $this->lang->line('download'); ?></a>
			<a href="<?php echo $this->my_url; ?>files/delete/<?php echo $row->fle_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a>
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
