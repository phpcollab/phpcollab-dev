<article class="title">
	<?php if($this->router->class == 'notes') { ?>
		<h2><a href="<?php echo $this->my_url; ?>projects"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $this->lang->line('projects'); ?></a> / <a href="<?php echo $this->my_url; ?>projects/read/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/projects'); ?>"></i><?php echo $prj->prj_name; ?></a> / <i class="fa fa-<?php echo $this->config->item('phpcollab/icons/notes'); ?>"></i><?php echo $this->lang->line('notes'); ?> (<?php echo $position; ?>)</h2>
	<?php } else { ?>
		<h2><a href="<?php echo $this->my_url; ?>notes/index/<?php echo $prj->prj_id; ?>"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/notes'); ?>"></i><?php echo $this->lang->line('notes'); ?></a> (<?php echo $position; ?>)</h2>
	<?php } ?>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>notes/create/<?php echo $prj->prj_id; ?>"><i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></a></li>
	<?php if($this->router->class != 'notes') { ?>
		<li class="collapse<?php if(!$this->input->cookie($this->router->class.'-notes') || $this->input->cookie($this->router->class.'-notes') == 'expand') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-notes-collapse"><a href="#<?php echo $this->router->class; ?>-notes"><i class="fa fa-caret-square-o-up"></i><?php echo $this->lang->line('collapse'); ?></a></li>
		<li class="expand<?php if($this->input->cookie($this->router->class.'-notes') == 'collapse') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-notes-expand"><a href="#<?php echo $this->router->class; ?>-notes"><i class="fa fa-caret-square-o-down"></i><?php echo $this->lang->line('expand'); ?></a></li>
	<?php } ?>
	</ul>
</article>
<article id="<?php echo $this->router->class; ?>-notes"<?php if($this->input->cookie($this->router->class.'-notes') == 'collapse') { ?> style="display:none;"<?php } ?>>
	<?php echo form_open(current_url()); ?>
	<div class="filters">
		<div>
			<?php echo form_label($this->lang->line('nte_name'), 'notes_nte_name'); ?>
			<?php echo form_input($ref_filter.'_nte_name', set_value($ref_filter.'_nte_name', $this->session->userdata($ref_filter.'_nte_name')), 'id="notes_nte_name" class="select"'); ?>
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
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('nte_id')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('nte_owner')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('nte_name')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('nte_date')); ?>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<tr>
			<td><?php echo $row->nte_id; ?></td>
			<td><?php echo $row->mbr_name; ?></td>
			<td><a href="<?php echo $this->my_url; ?>notes/read/<?php echo $row->nte_id; ?>"><?php echo $row->nte_name; ?></a></td>
			<td><?php echo $row->nte_date; ?></td>
			<th>
			<a href="<?php echo $this->my_url; ?>notes/update/<?php echo $row->nte_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a>
			<a href="<?php echo $this->my_url; ?>notes/delete/<?php echo $row->nte_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a>
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
