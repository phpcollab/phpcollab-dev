<div id="box-breadcrumbs">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>home"><?php echo $this->lang->line('home'); ?></a></li>
<li><?php echo $this->lang->line('organizations'); ?></li>
</ul>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('organizations'); ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo base_url(); ?>organization/create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('name'), 'organizations_name'); ?><?php echo form_input('organizations_name', set_value('organizations_name', $this->session->userdata('organizations_name')), 'id="organizations_name" class="inputtext"'); ?></div>
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
<th><?php display_column('organizations', $columns[0], $this->lang->line('id')); ?></th>
<th><?php display_column('organizations', $columns[1], $this->lang->line('organization')); ?></th>
<th><?php display_column('organizations', $columns[2], $this->lang->line('projects')); ?></th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo base_url(); ?>organization/read/<?php echo $result->id;?>"><?php echo $result->id;?></a></td>
<td><a href="<?php echo base_url(); ?>organization/read/<?php echo $result->id;?>"><?php echo $result->name;?></a></td>
<td><?php echo $result->count_projects;?></td>
<th>
<a href="<?php echo base_url(); ?>organization/update/<?php echo $result->id;?>"><?php echo $this->lang->line('update'); ?></a>
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
