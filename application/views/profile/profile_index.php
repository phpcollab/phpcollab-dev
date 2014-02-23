<article class="title">
	<h2><i class="fa fa-user"></i><?php echo $this->phpcollab_member->mbr_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>profile/update"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>
	</ul>
</article>
<article>
	<div class="column half">
		<?php if($this->auth_library->permission('organizations/read/any')) { ?>
			<p>
			<span class="label"><?php echo $this->lang->line('organization'); ?></span>
			<?php if($this->phpcollab_member->org_name) { ?><a href="<?php echo $this->my_url; ?>organizations/read/<?php echo $this->phpcollab_member->org_id; ?>"><?php echo $this->phpcollab_member->org_name; ?></a><?php } else { ?>-<?php } ?>
			</p>

		<?php } else if($this->auth_library->permission('organizations/read/ifowner') && $row->org_owner == $this->phpcollab_member->mbr_id) { ?>
			<p>
			<span class="label"><?php echo $this->lang->line('organization'); ?></span>
			<?php if($this->phpcollab_member->org_name) { ?><a href="<?php echo $this->my_url; ?>organizations/read/<?php echo $this->phpcollab_member->org_id; ?>"><?php echo $this->phpcollab_member->org_name; ?></a><?php } else { ?>-<?php } ?>
			</p>

		<?php } else if($this->auth_library->permission('organizations/read/ifmember')) { ?>
			<p>
			<span class="label"><?php echo $this->lang->line('organization'); ?></span>
			<?php if($this->phpcollab_member->org_name) { ?><a href="<?php echo $this->my_url; ?>organizations/read/<?php echo $this->phpcollab_member->org_id; ?>"><?php echo $this->phpcollab_member->org_name; ?></a><?php } else { ?>-<?php } ?>
			</p>
		<?php } ?>
		<p>
		<span class="label"><?php echo $this->lang->line('mbr_name'); ?></span>
		<?php if($this->phpcollab_member->mbr_name) { ?><?php echo $this->phpcollab_member->mbr_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mbr_description'); ?></span>
		<?php if($this->phpcollab_member->mbr_description) { ?><?php echo $this->phpcollab_member->mbr_description; ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
	<div class="column half">
		<p>
		<span class="label"><?php echo $this->lang->line('mbr_email'); ?></span>
		<?php if($this->phpcollab_member->mbr_email) { ?><?php echo $this->phpcollab_member->mbr_email; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('roles'); ?></span>
		<?php if($this->phpcollab_member->roles) { ?><?php echo $this->phpcollab_member->roles; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mbr_datecreated'); ?></span>
		<?php if($this->phpcollab_member->mbr_datecreated) { ?><?php echo $this->my_library->timezone_datetime($this->phpcollab_member->mbr_datecreated); ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('mbr_datemodified'); ?></span>
		<?php if($this->phpcollab_member->mbr_datemodified) { ?><?php echo $this->my_library->timezone_datetime($this->phpcollab_member->mbr_datemodified); ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
</article>
