<div id="box-breadcrumbs">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>administration"><?php echo $this->lang->line('administration'); ?></a></li>
<li><?php echo $this->lang->line('permissions'); ?></li>
</ul>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('permissions'); ?> (<?php echo $position; ?>)</h1>
<div class="display">

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('per_code'), 'permissions_per_code'); ?><?php echo form_input('permissions_per_code', set_value('permissions_per_code', $this->session->userdata('permissions_per_code')), 'id="permissions_per_code" class="inputtext"'); ?></div>
<div><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('submit'); ?>"></div>
</div>
</form>

<?php if($results) { ?>

<?php echo form_open(current_url()); ?>

<table>
<thead>
<tr>
<?php display_column('permissions', $columns[0], $this->lang->line('id')); ?>
<?php display_column('permissions', $columns[1], $this->lang->line('per_code')); ?>
<?php foreach($roles as $rol_id => $rol_title) { ?>
<th><?php echo $rol_title; ?></th>
<?php } ?>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo current_url(); ?>?a=read&amp;per_id=<?php echo $result->per_id;?>"><?php echo $result->per_id;?></a></td>
<td><?php echo $result->per_code; ?></td>
<?php foreach($roles as $rol_id => $rol_title) { ?>
<td><?php echo form_checkbox($result->per_id.$rol_id, 1, isset($permissions_roles[$result->per_id][$rol_id]), 'id="'.$result->per_id.$rol_id.'" class="inputcheckbox"'); ?></td>
<?php } ?>
</tr>
<?php } ?>

</tbody>
</table>

<p><input class="inputsubmit" type="submit" name="submit_roles" id="submit_roles" value="<?php echo $this->lang->line('submit'); ?>"></p>

</form>

<div class="paging">
<?php echo $pagination; ?>
</div>

<?php } ?>

</div>
</div>
