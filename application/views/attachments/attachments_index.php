<article class="title">
	<h2><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/files'); ?>"></i><?php echo $this->lang->line('attachments'); ?> (<?php echo $position; ?>)</h2>
	<ul>
	<?php if($this->router->class != 'attachments') { ?>
		<li class="collapse<?php if(!$this->input->cookie($this->router->class.'-attachments') || $this->input->cookie($this->router->class.'-attachments') == 'expand') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-attachments-collapse"><a href="#<?php echo $this->router->class; ?>-attachments"><i class="fa fa-caret-square-o-up"></i><?php echo $this->lang->line('collapse'); ?></a></li>
		<li class="expand<?php if($this->input->cookie($this->router->class.'-attachments') == 'collapse') { ?> enabled<?php } ?>" id="<?php echo $this->router->class; ?>-attachments-expand"><a href="#<?php echo $this->router->class; ?>-attachments"><i class="fa fa-caret-square-o-down"></i><?php echo $this->lang->line('expand'); ?></a></li>
	<?php } ?>
	</ul>
</article>
<article id="<?php echo $this->router->class; ?>-attachments"<?php if($this->input->cookie($this->router->class.'-attachments') == 'collapse') { ?> style="display:none;"<?php } ?>>
	<?php echo form_open(current_url()); ?>
	<div class="filters">
		<div>
			<?php echo form_label($this->lang->line('att_name'), 'attachments_att_name'); ?>
			<?php echo form_input($ref_filter.'_att_name', set_value($ref_filter.'_att_name', $this->session->userdata($ref_filter.'_att_name')), 'id="attachments_att_name" class="inputtext"'); ?>
		</div>
		<div>
			<?php echo form_submit('submit', $this->lang->line('submit'), 'class="inputsubmit"'); ?>
		</div>
	</div>
	<?php echo form_close(); ?>
	<?php if($rows) { ?>
	<table>
		<thead>
		<tr>
			<?php $i = 0; ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('att_id')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('att_name')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('att_owner')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('att_size')); ?>
			<?php $this->my_library->display_column($ref_filter, $columns[$i++], $this->lang->line('att_datecreated')); ?>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<tr>
			<td class="id"><?php echo $row->att_id; ?></td>
			<td><a href="<?php echo $this->my_url; ?>attachments/download/<?php echo $row->att_id; ?>"><?php echo $row->att_name; ?></a></td>
			<td><?php echo $row->mbr_name; ?></td>
			<td><?php echo convert_size($row->att_size); ?></td>
			<td><?php echo $this->my_library->timezone_datetime($row->att_datecreated); ?> (<span class="timeago" title="<?php echo $this->my_library->timezone_datetime($row->att_datecreated); ?>"></span>)</td>
			<th>
				<?php if($row->att_owner == $this->phpcollab_member->mbr_id) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/owner'); ?>" title="<?php echo $this->lang->line('icon_owner'); ?>"></i><?php } ?>
			</th>
		</tr>
		<?php } ?>
		</tbody>
	</table>
	<div class="paging">
		<?php echo $pagination; ?>
	</div>
	<?php } ?>
</article>
