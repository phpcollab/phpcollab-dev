<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>home"><?php echo $this->lang->line('home'); ?></a></li>
<li><?php echo $this->lang->line('projects'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('projects'); ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo base_url(); ?>project/create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('pro_name'), 'home_projects_pro_name'); ?><?php echo form_input('home_projects_pro_name', set_value('home_projects_pro_name', $this->session->userdata('home_projects_pro_name')), 'id="home_projects_pro_name" class="inputtext"'); ?></div>
<div><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></div>
</div>
</form>

<?php if($results) { ?>

<div class="paging">
<?php echo $pagination; ?>
</div>

<table>
<thead>
<tr>
<th><a class="sort_desc" href="#"><?php echo $this->lang->line('pro_id'); ?></a></th>
<th><?php echo $this->lang->line('pro_name'); ?></th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo base_url(); ?>project/read/<?php echo $result->pro_id;?>"><?php echo $result->pro_id;?></a></td>
<td><?php echo $result->pro_name; ?></td>
<th>
<a href="<?php echo base_url(); ?>project/update/<?php echo $result->pro_id;?>"><?php echo $this->lang->line('update'); ?></a>
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
