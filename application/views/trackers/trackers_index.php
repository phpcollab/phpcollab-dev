<article class="title">
	<h2><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/trackers') ?>"></i><?php echo $this->lang->line('trackers'); ?> (<?php echo $position; ?>)</h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>trackers/create"><i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></a></li>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<div class="filters">
		<div>
			<?php echo form_label($this->lang->line('trk_owner'), 'trackers_trk_owner'); ?>
			<?php echo form_dropdown($this->router->class.'_trackers_trk_owner', $dropdown_trk_owner, set_value($this->router->class.'_trackers_trk_owner', $this->session->userdata($this->router->class.'_trackers_trk_owner')), 'id="trackers_trk_owner" class="select"'); ?>
		</div>
		<div>
			<?php echo form_label($this->lang->line('trk_name'), 'trackers_trk_name'); ?>
			<?php echo form_input($this->router->class.'_trackers_trk_name', set_value($this->router->class.'_trackers_trk_name', $this->session->userdata($this->router->class.'_trackers_trk_name')), 'id="trackers_trk_name" class="inputtext"'); ?>
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
			<?php $this->my_library->display_column($this->router->class.'_trackers', $columns[$i++], $this->lang->line('trk_id')); ?>
			<?php $this->my_library->display_column($this->router->class.'_trackers', $columns[$i++], $this->lang->line('trk_owner')); ?>
			<?php $this->my_library->display_column($this->router->class.'_trackers', $columns[$i++], $this->lang->line('trk_name')); ?>
			<?php $this->my_library->display_column($this->router->class.'_trackers', $columns[$i++], $this->lang->line('tsk_description')); ?>
			<?php $this->my_library->display_column($this->router->class.'_trackers', $columns[$i++], $this->lang->line('trk_datecreated')); ?>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<tr>
			<td><?php echo $row->trk_id; ?></td>
			<td><?php echo $row->mbr_name; ?></td>
			<td><a href="<?php echo $this->my_url; ?>trackers/read/<?php echo $row->trk_id; ?>"><?php echo $row->trk_name; ?></a></td>
			<td><?php echo $row->tsk_description; ?></td>
			<td><?php echo $row->trk_datecreated; ?></td>
			<th>
			<a href="<?php echo $this->my_url; ?>trackers/update/<?php echo $row->trk_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a>
			<a href="<?php echo $this->my_url; ?>trackers/delete/<?php echo $row->trk_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a>
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
