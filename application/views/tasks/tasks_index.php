<?php if($this->uri->segment(1) == 'tasks') { ?>
<div id="box-breadcrumbs">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>home"><?php echo $this->lang->line('home'); ?></a></li>
<li><a href="<?php echo base_url(); ?>projects"><?php echo $this->lang->line('projects'); ?></a></li>
<li><a href="<?php echo base_url(); ?>project/read/<?php echo $pro->id; ?>"><?php echo $pro->name; ?></a></li>
<li><?php echo $this->lang->line('tasks'); ?></li>
</ul>
</div>
<?php } ?>

<div class="box1">
<h1><?php echo $this->lang->line('tasks'); ?> (<?php echo $position; ?>)</h1>
<ul>
<?php if($this->permissions['task_create'] == 1) { ?><li><a class="create" href="<?php echo base_url(); ?>task/create/<?php echo $this->uri->segment(3); ?>"><?php echo $this->lang->line('create'); ?></a></li><?php } ?>
</ul>
<div class="display">

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('name'), 'tasks_name'); ?><?php echo form_input('tasks_name', set_value('tasks_name', $this->session->userdata('tasks_name')), 'id="tasks_name" class="inputtext"'); ?></div>
<div><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('submit'); ?>"></div>
</div>
</form>

<?php if($results) { ?>

<table>
<thead>
<tr>
<?php display_column('tasks', $columns[0], $this->lang->line('id')); ?>
<?php display_column('tasks', $columns[1], $this->lang->line('task')); ?>
<?php display_column('tasks', $columns[2], $this->lang->line('priority')); ?>
<?php display_column('tasks', $columns[3], $this->lang->line('status')); ?>
<?php display_column('tasks', $columns[4], $this->lang->line('completion')); ?>
<?php display_column('tasks', $columns[5], $this->lang->line('due_date')); ?>
<?php display_column('tasks', $columns[6], $this->lang->line('published')); ?>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo base_url(); ?>task/read/<?php echo $result->id; ?>"><?php echo $result->id; ?></a></td>
<td><a href="<?php echo base_url(); ?>task/read/<?php echo $result->id; ?>"><?php echo $result->name; ?></a></td>
<td><img src="<?php echo base_url(); ?>themes/<?php echo $this->config->item('phpcollab_theme'); ?>/<?php echo $result->priority; ?>.gif" alt=""> <?php echo $this->lang->line('priority_'.$result->priority); ?></td>
<td><?php echo $this->lang->line('status_'.$result->status); ?></td>
<td><?php echo $result->completion_percent; ?> %</td>
<td><?php echo $result->due_date; ?></td>
<td><?php echo $this->lang->line('status_published_'.$result->published); ?></td>
<th>
<a href="<?php echo base_url(); ?>task/update/<?php echo $result->id; ?>"><?php echo $this->lang->line('update'); ?></a>
</th>
</tr>
<?php } ?>

</tbody>
</table>

<div class="paging">
<?php echo $pagination; ?> <?php if($this->uri->segment(1) != 'tasks') { ?><a href="<?php echo base_url(); ?>tasks/index/<?php echo $pro->id; ?>"><?php echo $this->lang->line('show_all'); ?></a><?php } ?>
</div>

<?php if($this->config->item('jpgraph')) { ?>
<div>
<img src="<?php echo base_url(); ?>tasks/gantt/<?php echo $pro->id; ?>" alt="">
</div>
<?php } ?>

<?php } ?>

</div>
</div>
