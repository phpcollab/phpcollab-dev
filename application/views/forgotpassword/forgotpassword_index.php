<article class="title">
	<h2><i class="fa fa-key"></i><?php echo $this->lang->line('forgotpassword'); ?></h2>
	<ul>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<?php echo validation_errors(); ?>
	<div class="column half">
		<p>
		<?php echo form_label($this->lang->line('mbr_email').' *', 'mbr_email'); ?>
		<?php echo form_input('mbr_email', set_value('mbr_email'), 'maxlength="255" id="mbr_email" class="inputtext valid_email required"'); ?>
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
