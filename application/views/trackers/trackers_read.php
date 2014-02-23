<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>trackers"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/trackers') ?>"></i><?php echo $this->lang->line('trackers'); ?></a> / <i class="fa fa-eye"></i><?php echo $row->trk_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>trackers/update/<?php echo $row->trk_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>
	<li><a href="<?php echo $this->my_url; ?>trackers/delete/<?php echo $row->trk_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	</ul>
</article>
<article>
	<div class="column half">
		<p>
		<span class="label"><?php echo $this->lang->line('trk_id'); ?></span>
		<?php if($row->trk_id) { ?><?php echo $row->trk_id; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('trk_owner'); ?></span>
		<?php if($row->mbr_name) { ?><?php echo $row->mbr_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('trk_name'); ?></span>
		<?php if($row->trk_name) { ?><?php echo $row->trk_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('tsk_description'); ?></span>
		<?php if($row->tsk_description) { ?><?php echo $row->tsk_description; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('trk_datecreated'); ?></span>
		<?php if($row->trk_datecreated) { ?><?php echo $this->my_library->timezone_datetime($row->trk_datecreated); ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
</article>
