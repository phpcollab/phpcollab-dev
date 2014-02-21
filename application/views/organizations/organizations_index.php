<article class="title">
	<h2><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/organizations'); ?>"></i><?php echo $this->lang->line('organizations'); ?> (<?php echo $position; ?>)</h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>organizations/create"><i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></a></li>
	</ul>
</article>
<article>
	<?php echo form_open(current_url()); ?>
	<div class="filters">
		<div>
			<?php echo form_label($this->lang->line('org_owner'), 'organizations_org_owner'); ?>
			<?php echo form_dropdown($this->router->class.'_organizations_org_owner', $dropdown_org_owner, set_value($this->router->class.'_organizations_org_owner', $this->session->userdata($this->router->class.'_organizations_org_owner')), 'id="organizations_org_owner" class="select"'); ?>
		</div>
		<div>
			<?php echo form_label($this->lang->line('org_name'), 'organizations_org_name'); ?>
			<?php echo form_input($this->router->class.'_organizations_org_name', set_value($this->router->class.'_organizations_org_name', $this->session->userdata($this->router->class.'_organizations_org_name')), 'id="organizations_org_name" class="inputtext"'); ?>
		</div>
		<div>
			<?php echo form_label($this->lang->line('org_authorized'), 'organizations_org_authorized'); ?>
			<?php echo form_dropdown($this->router->class.'_organizations_org_authorized', $this->my_model->dropdown_reply(), set_value($this->router->class.'_organizations_org_authorized', $this->session->userdata($this->router->class.'_organizations_org_authorized')), 'id="organizations_org_authorized" class="select"'); ?>
		</div>
		<div>
			<?php echo form_label($this->lang->line('org_datecreated'), 'organizations_org_datecreated'); ?>
			<?php echo form_input($this->router->class.'_organizations_org_datecreated', set_value($this->router->class.'_organizations_org_datecreated', $this->session->userdata($this->router->class.'_organizations_org_datecreated')), 'id="organizations_org_datecreated" class="inputtext"'); ?>
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
			<?php $this->my_library->display_column($this->router->class.'_organizations', $columns[$i++], $this->lang->line('tsk_completion')); ?>
			<?php $this->my_library->display_column($this->router->class.'_organizations', $columns[$i++], $this->lang->line('org_datecreated')); ?>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<tr>
			<td><?php echo $row->org_id; ?></td>
			<td><?php echo $row->mbr_name; ?></td>
			<td><a href="<?php echo $this->my_url; ?>organizations/read/<?php echo $row->org_id; ?>"><?php echo $row->org_name; ?></a></td>
			<td><?php echo $this->lang->line('reply_'.$row->org_authorized); ?></td>
			<td style="width:100px;"><span class="color_percent" style="width:<?php echo intval($row->tsk_completion); ?>%;"><?php echo intval($row->tsk_completion); ?>%</span></td>
			<td><?php echo $row->org_datecreated; ?></td>
			<th>
			<a href="<?php echo $this->my_url; ?>organizations/update/<?php echo $row->org_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a>
			<?php if($row->org_system == 0) { ?><a href="<?php echo $this->my_url; ?>organizations/delete/<?php echo $row->org_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a><?php } ?>
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
