<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>roles"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/roles') ?>"></i><?php echo $this->lang->line('roles'); ?></a> / <i class="fa fa-wrench"></i><?php echo $row->rol_code; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>roles/read/<?php echo $row->rol_id; ?>"><i class="fa fa-eye"></i><?php echo $this->lang->line('read'); ?></a></li>
	<?php if($row->rol_system == 0) { ?><li><a href="<?php echo $this->my_url; ?>roles/delete/<?php echo $row->rol_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li><?php } ?>
	</ul>
</article>
<?php echo form_open(current_url()); ?>
<?php echo form_hidden('rol_code_old', $row->rol_code); ?>
<article>
	<?php echo validation_errors(); ?>
	<div class="column1">
		<?php if($row->rol_system == 0) { ?>
			<p>
			<?php echo form_label($this->lang->line('rol_code').' *', 'rol_code'); ?>
			<?php echo form_input('rol_code', set_value('rol_code', $row->rol_code), 'id="rol_code" class="inputtext required"'); ?>
			</p>
		<?php } ?>
		<p>
		<span class="label">&nbsp;</span>
		<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</p>
	</div>
</article>
<article class="title">
	<h2><?php echo $this->lang->line('permissions'); ?></h2>
</article>
<article>
	<div class="column2">
		<?php $u = 1; ?>
		<?php foreach($permissions as $per) { ?>
			<p>
			<?php echo form_label($per->per_code, 'per_'.$per->per_id); ?>
			<?php echo form_checkbox('per_'.$per->per_id, '1', set_checkbox('per_'.$per->per_id, '1', value2boolean($per->per_saved, '1')), 'id="per_'.$per->per_id.'" class="inputcheckbox"'); ?>
			</p>
			<?php if($permissions_limit == $u) { ?>
				</div>
				<div class="column2">
				<?php $u = 1; ?>
			<?php } else { ?>
				<?php $u++; ?>
			<?php } ?>
		<?php } ?>
	</div>
</article>
<?php echo form_close(); ?>
