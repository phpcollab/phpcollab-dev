<article class="title">
	<h2><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/roles') ?>"></i><?php echo $this->lang->line('roles'); ?> (<?php echo $position; ?>)</h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>roles/create"><i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></a></li>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<div class="filters">
		<div>
			<?php echo form_label($this->lang->line('rol_code'), 'roles_rol_code'); ?>
			<?php echo form_input($this->router->class.'_roles_rol_code', set_value($this->router->class.'_roles_rol_code', $this->session->userdata($this->router->class.'_roles_rol_code')), 'id="roles_rol_code" class="inputtext"'); ?>
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
			<?php $this->my_library->display_column($this->router->class.'_roles', $columns[$i++], $this->lang->line('rol_id')); ?>
			<?php $this->my_library->display_column($this->router->class.'_roles', $columns[$i++], $this->lang->line('rol_code')); ?>
			<?php $this->my_library->display_column($this->router->class.'_roles', $columns[$i++], $this->lang->line('rol_datecreated')); ?>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<tr>
			<td><?php echo $row->rol_id; ?></td>
			<td><a href="<?php echo $this->my_url; ?>roles/read/<?php echo $row->rol_id; ?>"><?php echo $row->rol_code; ?></a></td>
			<td><?php echo $row->rol_datecreated; ?></td>
			<th>
			<a href="<?php echo $this->my_url; ?>roles/update/<?php echo $row->rol_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a>
			<a href="<?php echo $this->my_url; ?>roles/delete/<?php echo $row->rol_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a>
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
