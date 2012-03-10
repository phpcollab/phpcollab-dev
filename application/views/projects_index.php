<?php if($this->uri->segment(1) == 'projects') { ?>
<div id="box-breadcrumbs">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>home"><?php echo $this->lang->line('home'); ?></a></li>
<li><?php echo $this->lang->line('projects'); ?></li>
</ul>
</div>
<?php } ?>

<div class="box1">
<h1><?php echo $this->lang->line('projects'); ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo base_url(); ?>project/create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('name'), 'projects_name'); ?><?php echo form_input('projects_name', set_value('projects_name', $this->session->userdata('projects_name')), 'id="projects_name" class="inputtext"'); ?></div>
<div><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('submit'); ?>"></div>
</div>
</form>

<?php if($results) { ?>

<div class="paging">
<?php echo $pagination; ?>
</div>

<table>
<thead>
<tr>
<th><?php display_column('projects', $columns[0], $this->lang->line('id')); ?></th>
<th><?php display_column('projects', $columns[1], $this->lang->line('project')); ?></th>
<th><?php display_column('projects', $columns[2], $this->lang->line('priority')); ?></th>
<th><?php display_column('projects', $columns[3], $this->lang->line('organization')); ?></th>
<th><?php display_column('projects', $columns[4], $this->lang->line('status')); ?></th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo base_url(); ?>project/read/<?php echo $result->id; ?>"><?php echo $result->id; ?></a></td>
<td><a href="<?php echo base_url(); ?>project/read/<?php echo $result->id; ?>"><?php echo $result->name; ?></a></td>
<td><img src="<?php echo base_url(); ?>themes/<?php echo $this->config->item('phpcollab_theme'); ?>/<?php echo $result->priority; ?>.gif" alt=""> <?php echo $this->lang->line('priority_'.$result->priority); ?></td>
<td><?php echo $result->organization; ?></td>
<td><?php echo $this->lang->line('status_'.$result->status); ?></td>
<th>
<a href="<?php echo base_url(); ?>project/update/<?php echo $result->id; ?>"><?php echo $this->lang->line('update'); ?></a>
</th>
</tr>
<?php } ?>

</tbody>
</table>

<div class="paging">
<?php echo $pagination; ?>
</div>

<?php } ?>

</div>
</div>
