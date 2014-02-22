<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>members"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/members') ?>"></i><?php echo $this->lang->line('members'); ?></a> / <i class="fa fa-eye"></i><?php echo $row->mbr_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>members/update/<?php echo $row->mbr_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>
	<li><?php if($row->mbr_id != $this->phpcollab_member->mbr_id) { ?><a href="<?php echo $this->my_url; ?>members/delete/<?php echo $row->mbr_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a><?php } ?></li>
	</ul>
</article>
<article>
	<div class="column1">
		<p>
		<span class="label"><?php echo $this->lang->line('mbr_id'); ?></span>
		<?php if($row->mbr_id) { ?><?php echo $row->mbr_id; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('organization'); ?></span>
		<?php if($row->org_name) { ?><a href="<?php echo $this->my_url; ?>organizations/read/<?php echo $row->org_id; ?>"><?php echo $row->org_name; ?></a><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mbr_name'); ?></span>
		<?php if($row->mbr_name) { ?><?php echo $row->mbr_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mbr_description'); ?></span>
		<?php if($row->mbr_description) { ?><?php echo $row->mbr_description; ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
	<div class="column1 columnlast">
		<p>
		<span class="label"><?php echo $this->lang->line('mbr_email'); ?></span>
		<?php if($row->mbr_email) { ?><?php echo $row->mbr_email; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mbr_authorized'); ?></span>
		<?php echo $this->lang->line('reply_'.$row->mbr_authorized); ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('roles'); ?></span>
		<?php if($row->roles) { ?><?php echo $row->roles; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mbr_datecreated'); ?></span>
		<?php if($row->mbr_datecreated) { ?><?php echo $row->mbr_datecreated; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mbr_datemodified'); ?></span>
		<?php if($row->mbr_datemodified) { ?><?php echo $row->mbr_datemodified; ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
</article>
