<div id="box-breadcrumbs">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>administration"><?php echo $this->lang->line('administration'); ?></a></li>
<li><?php echo $this->lang->line('logs'); ?></li>
</ul>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('logs'); ?> (<?php echo $position; ?>)</h1>
<div class="display">

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('user_name'), 'logs_login'); ?><?php echo form_input('logs_login', set_value('logs_login', $this->session->userdata('logs_login')), 'id="logs_login" class="inputtext"'); ?></div>
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
<?php display_column('logs', $columns[0], $this->lang->line('id')); ?>
<?php display_column('logs', $columns[1], $this->lang->line('user_name')); ?>
<?php display_column('logs', $columns[2], $this->lang->line('ip')); ?>
<?php display_column('logs', $columns[3], $this->lang->line('session')); ?>
<?php display_column('logs', $columns[4], $this->lang->line('compteur')); ?>
<?php display_column('logs', $columns[5], $this->lang->line('last_visit')); ?>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><?php echo $result->id; ?></td>
<td><?php echo $result->login; ?></td>
<td><?php echo $result->ip; ?></td>
<td><?php echo $result->session; ?></td>
<td><?php echo $result->compt; ?></td>
<td><?php echo $result->last_visite; ?></td>
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
