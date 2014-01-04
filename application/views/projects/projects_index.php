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
<?php if($this->permissions['project_create'] == 1) { ?><li><a class="create" href="<?php echo base_url(); ?>project/create"><?php echo $this->lang->line('create'); ?></a></li><?php } ?>
</ul>
<div class="display">

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('name'), 'projects_name'); ?><?php echo form_input('projects_name', set_value('projects_name', $this->session->userdata('projects_name')), 'id="projects_name" class="inputtext"'); ?></div>
<div><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('submit'); ?>"></div>
</div>
</form>

<?php if($results) { ?>

<table>
<thead>
<tr>
<?php display_column('projects', $columns[0], $this->lang->line('id')); ?>
<?php display_column('projects', $columns[1], $this->lang->line('project')); ?>
<?php display_column('projects', $columns[2], $this->lang->line('priority')); ?>
<?php display_column('projects', $columns[3], $this->lang->line('organization')); ?>
<?php display_column('projects', $columns[4], $this->lang->line('status')); ?>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo base_url(); ?>project/read/<?php echo $result->id; ?>"><?php echo $result->id; ?></a></td>
<td><a href="<?php echo base_url(); ?>project/read/<?php echo $result->id; ?>"><?php echo $result->name; ?></a></td>
<td><img src="<?php echo base_url(); ?>themes/<?php echo $this->config->item('phpcollab_theme'); ?>/<?php echo $result->priority; ?>.gif" alt=""> <?php echo $this->lang->line('priority_'.$result->priority); ?></td>
<td><?php if($result->org_id) { ?><a href="<?php echo base_url(); ?>organization/read/<?php echo $result->org_id; ?>"><?php echo $result->org_name; ?></a><?php } ?></td>
<td><?php echo $this->lang->line('status_'.$result->status); ?></td>
<th>
<?php if($this->permissions['project_update_all'] == 1 || ($this->permissions['project_update_owned'] == 1 && $result->owner == $this->member->id)) { ?><a href="<?php echo base_url(); ?>project/update/<?php echo $result->id; ?>"><?php echo $this->lang->line('update'); ?></a><?php } ?>
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
