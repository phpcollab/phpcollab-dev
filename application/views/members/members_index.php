<article class="title">
	<h2><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/members') ?>"></i><?php echo $this->lang->line('members'); ?> (<?php echo $position; ?>)</h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>members/create"><i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></a></li>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<div class="filters">
		<div>
			<?php echo form_label($this->lang->line('org_id'), 'members_org_id'); ?>
			<?php echo form_dropdown($this->router->class.'_members_org_id', $dropdown_org_id, set_value($this->router->class.'_members_org_id', $this->session->userdata($this->router->class.'_members_org_id')), 'id="members_org_id" class="select"'); ?>
		</div>
		<div>
			<?php echo form_label($this->lang->line('mbr_name'), 'members_mbr_name'); ?>
			<?php echo form_input($this->router->class.'_members_mbr_name', set_value($this->router->class.'_members_mbr_name', $this->session->userdata($this->router->class.'_members_mbr_name')), 'id="members_mbr_name" class="inputtext"'); ?>
		</div>
		<div>
			<?php echo form_label($this->lang->line('mbr_email'), 'members_mbr_email'); ?>
			<?php echo form_input($this->router->class.'_members_mbr_email', set_value($this->router->class.'_members_mbr_email', $this->session->userdata($this->router->class.'_members_mbr_email')), 'id="members_mbr_email" class="inputtext"'); ?>
		</div>
		<div>
			<?php echo form_label($this->lang->line('mbr_authorized'), 'members_mbr_authorized'); ?>
			<?php echo form_dropdown($this->router->class.'_members_mbr_authorized', $dropdown_reply, set_value($this->router->class.'_members_mbr_authorized', $this->session->userdata($this->router->class.'_members_mbr_authorized')), 'id="members_mbr_authorized" class="select"'); ?>
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
			<?php $this->my_library->display_column($this->router->class.'_members', $columns[$i++], $this->lang->line('mbr_id')); ?>
			<?php $this->my_library->display_column($this->router->class.'_members', $columns[$i++], $this->lang->line('org_id')); ?>
			<?php $this->my_library->display_column($this->router->class.'_members', $columns[$i++], $this->lang->line('org_name')); ?>
			<?php $this->my_library->display_column($this->router->class.'_members', $columns[$i++], $this->lang->line('mbr_name')); ?>
			<?php $this->my_library->display_column($this->router->class.'_members', $columns[$i++], $this->lang->line('mbr_email')); ?>
			<?php $this->my_library->display_column($this->router->class.'_members', $columns[$i++], $this->lang->line('mbr_authorized')); ?>
			<?php $this->my_library->display_column($this->router->class.'_members', $columns[$i++], $this->lang->line('mbr_datecreated')); ?>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<tr>
			<td><?php echo $row->mbr_id; ?></td>
			<td><?php echo $row->org_id; ?></td>
			<td><?php echo $row->org_name; ?></td>
			<td><a href="<?php echo $this->my_url; ?>members/read/<?php echo $row->mbr_id; ?>"><?php echo $row->mbr_name; ?></a></td>
			<td><?php echo $row->mbr_email; ?></td>
			<td><?php echo $this->lang->line('reply_'.$row->mbr_authorized); ?></td>
			<td><?php echo $row->mbr_datecreated; ?></td>
			<th>
			<a href="<?php echo $this->my_url; ?>members/update/<?php echo $row->mbr_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a>
			<?php if($row->mbr_id != $this->phpcollab_member->mbr_id) { ?><a href="<?php echo $this->my_url; ?>members/delete/<?php echo $row->mbr_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a><?php } ?>
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
