<?php
if($tsk) {
?>

<div id="box-breadcrumbs">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>home"><?php echo $this->lang->line('home'); ?></a></li>
<li><a href="<?php echo base_url(); ?>projects"><?php echo $this->lang->line('projects'); ?></a></li>
<li><a href="<?php echo base_url(); ?>project/read/<?php echo $pro->id; ?>"><?php echo $pro->name; ?></a></li>
<li><a href="<?php echo base_url(); ?>tasks/index/<?php echo $pro->id; ?>"><?php echo $this->lang->line('tasks'); ?></a></li>
<li><a href="<?php echo base_url(); ?>task/read/<?php echo $tsk->id; ?>"><?php echo $tsk->name; ?></a></li>
<li><?php echo $this->lang->line('update'); ?></li>
</ul>
</div>

<div class="box1">
<h1><?php echo $tsk->name; ?></h1>
<ul>
<li><a class="read" href="<?php echo base_url(); ?>task/read/<?php echo $tsk->id; ?>"><?php echo $this->lang->line('view'); ?></a></li>
</ul>
<div class="display">

<?php echo validation_errors(); ?>

<?php echo form_open(current_url()); ?>

<h2><?php echo $this->lang->line('update'); ?></h2>
<div class="box2">
<p><?php echo form_label($this->lang->line('project').' *', 'project'); ?><?php echo form_dropdown('project', $select_project, set_value('project', $tsk->project), 'id="project" class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('name').' *', 'name'); ?><?php echo form_input('name', set_value('name', $tsk->name), 'id="name" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('description'), 'description'); ?><?php echo form_textarea('description', set_value('description', $tsk->description), 'id="description" class="textarea"'); ?></p>
<p><?php echo form_label($this->lang->line('status').' *', 'status'); ?><?php echo form_dropdown('status', $select_status, set_value('status', $tsk->status), 'id="status" class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('completion').' *', 'completion'); ?><?php echo form_dropdown('completion', $select_completion, set_value('completion', $tsk->completion), 'id="completion" class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('priority').' *', 'priority'); ?><?php echo form_dropdown('priority', $select_priority, set_value('priority', $tsk->priority), 'id="priority" class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('start_date').' *', 'start_date'); ?><?php echo form_input('start_date', set_value('start_date', $tsk->start_date), 'id="start_date" class="inputtext datefield"'); ?></p>
<p><?php echo form_label($this->lang->line('due_date'), 'due_date'); ?><?php echo form_input('due_date', set_value('due_date', $tsk->due_date), 'id="due_date" class="inputtext datefield"'); ?></p>
<p><span class="label">&nbsp;</span><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('save'); ?>"></p>
</div>

</form>

</div>
</div>

<?php
}
?>
