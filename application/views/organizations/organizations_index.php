<article class="title">
	<h2><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/organizations'); ?>"></i><?php echo $this->lang->line('organizations'); ?> (<?php echo $position; ?>)</h2>
	<ul>
	<?php if($this->auth_library->permission('organizations/create')) { ?><li><a href="<?php echo $this->my_url; ?>organizations/create"><i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></a></li><?php } ?>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<div class="filters">
		<div>
			<?php echo form_label($this->lang->line('org_name'), 'organizations_org_name'); ?>
			<?php echo form_input($this->router->class.'_organizations_org_name', set_value($this->router->class.'_organizations_org_name', $this->session->userdata($this->router->class.'_organizations_org_name')), 'id="organizations_org_name" class="inputtext"'); ?>
		</div>
		<div>
			<?php echo form_label($this->lang->line('org_authorized'), 'organizations_org_authorized'); ?>
			<?php echo form_dropdown($this->router->class.'_organizations_org_authorized', $this->my_model->dropdown_reply(), set_value($this->router->class.'_organizations_org_authorized', $this->session->userdata($this->router->class.'_organizations_org_authorized')), 'id="organizations_org_authorized" class="select"'); ?>
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
			<?php $this->my_library->display_column($this->router->class.'_organizations', $columns[$i++], $this->lang->line('org_id')); ?>
			<?php $this->my_library->display_column($this->router->class.'_organizations', $columns[$i++], $this->lang->line('org_owner')); ?>
			<?php $this->my_library->display_column($this->router->class.'_organizations', $columns[$i++], $this->lang->line('org_name')); ?>
			<?php $this->my_library->display_column($this->router->class.'_organizations', $columns[$i++], $this->lang->line('org_authorized')); ?>
			<?php $this->my_library->display_column($this->router->class.'_organizations', $columns[$i++], $this->lang->line('members')); ?>
			<?php $this->my_library->display_column($this->router->class.'_organizations', $columns[$i++], $this->lang->line('projects')); ?>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<tr>
			<td class="id"><?php echo $row->org_id; ?></td>
			<td><?php echo $row->mbr_name; ?></td>
			<td><a href="<?php echo $this->my_url; ?>organizations/read/<?php echo $row->org_id; ?>"><?php echo $row->org_name; ?></a></td>
			<td><?php echo $this->lang->line('reply_'.$row->org_authorized); ?></td>
			<td><?php echo $row->count_members; ?></td>
			<td><?php echo $row->count_projects; ?></td>
			<th>
				<?php if($row->org_owner == $this->phpcollab_member->mbr_id) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/owner'); ?>" title="<?php echo $this->lang->line('icon_owner'); ?>"></i><?php } ?>
				<?php if($row->ismember == 1) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/ismember'); ?>" title="<?php echo $this->lang->line('icon_ismember'); ?>"></i><?php } ?>
				<?php if($row->org_authorized == 0) { ?><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/notauthorized'); ?>" title="<?php echo $this->lang->line('icon_notauthorized'); ?>"></i><?php } ?>
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
