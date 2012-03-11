<?php if($this->uri->segment(1) == 'topics') { ?>
<div id="box-breadcrumbs">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>home"><?php echo $this->lang->line('home'); ?></a></li>
<li><a href="<?php echo base_url(); ?>projects"><?php echo $this->lang->line('projects'); ?></a></li>
<li><a href="<?php echo base_url(); ?>project/read/<?php echo $pro->id; ?>"><?php echo $pro->name; ?></a></li>
<li><?php echo $this->lang->line('topics'); ?></li>
</ul>
</div>
<?php } ?>

<div class="box1">
<h1><?php echo $this->lang->line('discussions'); ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo base_url(); ?>topic/create/<?php echo $this->uri->segment(3); ?>"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('name'), 'topics_name'); ?><?php echo form_input('topics_name', set_value('topics_name', $this->session->userdata('topics_name')), 'id="topics_name" class="inputtext"'); ?></div>
<div><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('submit'); ?>"></div>
</div>
</form>

<?php if($results) { ?>

<table>
<thead>
<tr>
<?php display_column('topics', $columns[0], $this->lang->line('id')); ?>
<?php display_column('topics', $columns[1], $this->lang->line('topic')); ?>
<?php display_column('topics', $columns[2], $this->lang->line('posts')); ?>
<?php display_column('topics', $columns[3], $this->lang->line('last_post')); ?>
<?php display_column('topics', $columns[4], $this->lang->line('status')); ?>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo base_url(); ?>topic/read/<?php echo $result->id; ?>"><?php echo $result->id; ?></a></td>
<td><a href="<?php echo base_url(); ?>topic/read/<?php echo $result->id; ?>"><?php echo $result->subject; ?></a></td>
<td><?php echo $result->posts; ?></td>
<td><?php echo $result->last_post; ?></td>
<td><?php echo $this->lang->line('status_topic_'.$result->status); ?></td>
<th>
<a href="<?php echo base_url(); ?>topic/update/<?php echo $result->id; ?>"><?php echo $this->lang->line('update'); ?></a>
</th>
</tr>
<?php } ?>

</tbody>
</table>

<div class="paging">
<?php echo $pagination; ?> <?php if($this->uri->segment(1) != 'topics') { ?><a href="<?php echo base_url(); ?>topics/index/<?php echo $pro->id; ?>"><?php echo $this->lang->line('show_all'); ?></a><?php } ?>
</div>

<?php } ?>

</div>
</div>
