<article class="title">
	<h2><i class="fa fa-gears"></i><?php echo $this->lang->line('configuration'); ?> (<?php echo $position; ?>)</h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>_configuration/create"><i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></a></li>
	</ul>
</article>
<article>
		<?php echo form_open(current_url()); ?>
	<div class="filters">
		<div>
			<?php echo form_label($this->lang->line('cfg_path'), '_configuration_cfg_path'); ?>
			<?php echo form_input($this->router->class.'__configuration_cfg_path', set_value($this->router->class.'__configuration_cfg_path', $this->session->userdata($this->router->class.'__configuration_cfg_path')), 'id="_configuration_cfg_path" class="inputtext"'); ?>
		</div>
		<div>
			<?php echo form_label($this->lang->line('cfg_value'), '_configuration_cfg_value'); ?>
			<?php echo form_input($this->router->class.'__configuration_cfg_value', set_value($this->router->class.'__configuration_cfg_value', $this->session->userdata($this->router->class.'__configuration_cfg_value')), 'id="_configuration_cfg_value" class="inputtext"'); ?>
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
			<?php $this->my_library->display_column($this->router->class.'__configuration', $columns[$i++], $this->lang->line('cfg_id')); ?>
			<?php $this->my_library->display_column($this->router->class.'__configuration', $columns[$i++], $this->lang->line('cfg_path')); ?>
			<?php $this->my_library->display_column($this->router->class.'__configuration', $columns[$i++], $this->lang->line('cfg_value')); ?>
			<?php $this->my_library->display_column($this->router->class.'__configuration', $columns[$i++], $this->lang->line('cfg_datecreated')); ?>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<tr>
			<td><?php echo $row->cfg_id; ?></td>
			<td><a href="<?php echo $this->my_url; ?>_configuration/read/<?php echo $row->cfg_id; ?>"><?php echo $row->cfg_path; ?></a></td>
			<td><?php echo $row->cfg_value; ?></td>
			<td><?php echo $this->my_library->timezone_datetime($row->cfg_datecreated); ?></td>
			<th>
			<a href="<?php echo $this->my_url; ?>_configuration/update/<?php echo $row->cfg_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a>
			<a href="<?php echo $this->my_url; ?>_configuration/delete/<?php echo $row->cfg_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a>
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
