<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>home"><?php echo $this->lang->line('home'); ?></a></li>
<li><a href="<?php echo base_url(); ?>projects"><?php echo $this->lang->line('projects'); ?></a></li>
<li><?php echo $this->lang->line('create'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('project'); ?></h1>
<div class="display">

<h2><?php echo $this->lang->line('create'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url()); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('project').' *', 'project'); ?><?php echo form_dropdown('project', $select_project, set_value('', $this->uri->segment(3)), 'id="project" class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('name').' *', 'name'); ?><?php echo form_input('name', set_value('name'), 'id="name" class="inputtext"'); ?></p>
<p><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('save'); ?>"></p>
</div>

</form>

</div>
</div>
