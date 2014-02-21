<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>organizations"><i class="fa fa-building-o"></i><?php echo $this->lang->line('organizations'); ?></a> / <i class="fa fa-eye"></i><?php echo $row->org_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>organizations/update/<?php echo $row->org_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>
	<li><a href="<?php echo $this->my_url; ?>organizations/delete/<?php echo $row->org_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	</ul>
</article>
<article>
	<div class="column1">
		<p>
		<span class="label"><?php echo $this->lang->line('org_id'); ?></span>
		<?php if($row->org_id) { ?><?php echo $row->org_id; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('org_owner'); ?></span>
		<?php if($row->org_owner) { ?><?php echo $row->org_owner; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mbr_name'); ?></span>
		<?php if($row->mbr_name) { ?><?php echo $row->mbr_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('org_name'); ?></span>
		<?php if($row->org_name) { ?><?php echo $row->org_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('org_description'); ?></span>
		<?php if($row->org_description) { ?><?php echo $row->org_description; ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
	<div class="column1 columnlast">
		<p>
		<span class="label"><?php echo $this->lang->line('org_comments'); ?></span>
		<?php if($row->org_comments) { ?><?php echo $row->org_comments; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('org_authorized'); ?></span>
		<?php echo $this->lang->line('reply_'.$row->org_authorized); ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('org_system'); ?></span>
		<?php echo $this->lang->line('reply_'.$row->org_system); ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('org_datecreated'); ?></span>
		<?php if($row->org_datecreated) { ?><?php echo $row->org_datecreated; ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
</article>
