<article class="title">
	<h2><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/statuses') ?>"></i><?php echo $this->lang->line('statuses'); ?> (<?php echo $position; ?>)</h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>statuses/create"><i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></a></li>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<div class="filters">
		<div>
			<?php echo form_label($this->lang->line('stu_name'), 'statuses_stu_name'); ?>
			<?php echo form_input($this->router->class.'_statuses_stu_name', set_value($this->router->class.'_statuses_stu_name', $this->session->userdata($this->router->class.'_statuses_stu_name')), 'id="statuses_stu_name" class="inputtext"'); ?>
		</div>
		<div>
			<?php echo form_label($this->lang->line('stu_isclosed'), 'statuses_stu_isclosed'); ?>
			<?php echo form_dropdown($this->router->class.'_statuses_stu_isclosed', $this->my_model->dropdown_reply(), set_value($this->router->class.'_statuses_stu_isclosed', $this->session->userdata($this->router->class.'_statuses_stu_isclosed')), 'id="statuses_stu_isclosed" class="select"'); ?>
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
			<?php $this->my_library->display_column($this->router->class.'_statuses', $columns[$i++], $this->lang->line('stu_id')); ?>
			<?php $this->my_library->display_column($this->router->class.'_statuses', $columns[$i++], $this->lang->line('stu_name')); ?>
			<?php $this->my_library->display_column($this->router->class.'_statuses', $columns[$i++], $this->lang->line('stu_owner')); ?>
			<?php $this->my_library->display_column($this->router->class.'_statuses', $columns[$i++], $this->lang->line('stu_isclosed')); ?>
			<?php $this->my_library->display_column($this->router->class.'_statuses', $columns[$i++], $this->lang->line('stu_ordering')); ?>
			<?php $this->my_library->display_column($this->router->class.'_statuses', $columns[$i++], $this->lang->line('stu_datecreated')); ?>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<tr>
			<td class="id"><?php echo $row->stu_id; ?></td>
			<td><a href="<?php echo $this->my_url; ?>statuses/read/<?php echo $row->stu_id; ?>"><?php echo $row->stu_name; ?></a></td>
			<td><?php echo $row->mbr_name; ?></td>
			<td><?php echo $this->lang->line('reply_'.$row->stu_isclosed); ?></td>
			<td><?php echo $row->stu_ordering; ?></td>
			<td><?php echo $this->my_library->timezone_datetime($row->stu_datecreated); ?></td>
			<th>
				<?php if($row->stu_owner == $this->phpcollab_member->mbr_id) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/owner'); ?>" title="<?php echo $this->lang->line('icon_owner'); ?>"></i><?php } ?>
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
