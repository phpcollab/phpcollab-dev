<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>_configuration"><i class="fa fa-gears"></i><?php echo $this->lang->line('configuration'); ?></a> | <i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></h2>
	<ul>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column half">
		<p>
		<?php echo form_label($this->lang->line('cfg_path').' *', 'cfg_path'); ?>
		<?php echo form_input('cfg_path', set_value('cfg_path', ''), 'id="cfg_path" class="inputtext required"'); ?>
		</p>
		<p>
		<?php echo form_label($this->lang->line('cfg_value'), 'cfg_value'); ?>
		<?php echo form_input('cfg_value', set_value('cfg_value', ''), 'id="cfg_value" class="inputtext"'); ?>
		</p>
		<p>
		<span class="label">&nbsp;</span>
		<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</p>
	</div>
	<div class="column half">
	</div>
	<?php echo form_close(); ?>
</article>
