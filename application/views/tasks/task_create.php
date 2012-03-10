<div id="box-breadcrumbs">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>home"><?php echo $this->lang->line('home'); ?></a></li>
<li><a href="<?php echo base_url(); ?>projects"><?php echo $this->lang->line('projects'); ?></a></li>
<li><a href="<?php echo base_url(); ?>project/read/<?php echo $pro->id; ?>"><?php echo $pro->name; ?></a></li>
<li><a href="<?php echo base_url(); ?>tasks/index/<?php echo $pro->id; ?>"><?php echo $this->lang->line('tasks'); ?></a></li>
<li><?php echo $this->lang->line('create'); ?></li>
</ul>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('add_task'); ?></h1>
<div class="display">

<?php echo validation_errors(); ?>

<?php echo form_open(current_url()); ?>

<h2><?php echo $this->lang->line('info'); ?></h2>
<div class="box2">
<p><?php echo form_label($this->lang->line('project').' *', 'project'); ?><?php echo form_dropdown('project', $select_project, set_value('', $this->uri->segment(3)), 'id="project" class="select"'); ?></p>
</div>

<h2><?php echo $this->lang->line('details'); ?></h2>
<div class="box2">
<p><?php echo form_label($this->lang->line('name').' *', 'name'); ?><?php echo form_input('name', set_value('name'), 'id="name" class="inputtext"'); ?></p>
<p><span class="label">&nbsp;</span><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('save'); ?>"></p>
</div>

</form>

</div>
</div>
