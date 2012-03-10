<div id="box-breadcrumbs">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>administration"><?php echo $this->lang->line('administration'); ?></a></li>
<li><?php echo $this->lang->line('company_details'); ?></li>
</ul>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('company_details'); ?></h1>
<div class="display">

<?php echo validation_errors(); ?>

<?php echo form_open(current_url()); ?>

<h2><?php echo $this->lang->line('company_info'); ?></h2>
<div class="box2">
<p><?php echo form_label($this->lang->line('name').' *', 'name'); ?><?php echo form_input('name', set_value('name', $org->name), 'id="name" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('address'), 'address1'); ?><?php echo form_input('address1', set_value('address1', $org->address1), 'id="address1" class="inputtext"'); ?></p>
<p><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('save'); ?>"></p>
</div>

</form>

</div>
</div>
