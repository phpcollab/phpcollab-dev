<div id="box-breadcrumbs">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>home"><?php echo $this->lang->line('home'); ?></a></li>
<li><a href="<?php echo base_url(); ?>projects"><?php echo $this->lang->line('projects'); ?></a></li>
<li><?php echo $this->lang->line('create'); ?></li>
</ul>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('add_project'); ?></h1>
<div class="display">

<?php echo validation_errors(); ?>

<?php echo form_open(current_url()); ?>

<h2><?php echo $this->lang->line('details'); ?></h2>
<div class="box2">
<p><?php echo form_label($this->lang->line('name').' *', 'name'); ?><?php echo form_input('name', set_value('name'), 'id="name" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('priority').' *', 'priority'); ?><?php echo form_dropdown('priority', $select_priority, set_value('priority', 3), 'id="priority" class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('description'), 'description'); ?><?php echo form_textarea('description', set_value('description'), 'id="description" class="textarea"'); ?></p>
<p><?php echo form_label($this->lang->line('url_dev'), 'url_dev'); ?><?php echo form_input('url_dev', set_value('url_dev'), 'id="url_dev" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('url_prod'), 'url_prod'); ?><?php echo form_input('url_prod', set_value('url_prod'), 'id="url_prod" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('organization').' *', 'organization'); ?><?php echo form_dropdown('organization', $select_organization, set_value('organization'), 'id="organization" class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('status').' *', 'status'); ?><?php echo form_dropdown('status', $select_status, set_value('status', 2), 'id="status" class="select"'); ?></p>
<p><span class="label">&nbsp;</span><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('save'); ?>"></p>
</div>

</form>

</div>
</div>
