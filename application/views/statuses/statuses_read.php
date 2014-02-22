<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>statuses"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/statuses') ?>"></i><?php echo $this->lang->line('statuses'); ?></a> / <i class="fa fa-eye"></i><?php echo $row->stu_name; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>statuses/update/<?php echo $row->stu_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>
	<li><a href="<?php echo $this->my_url; ?>statuses/delete/<?php echo $row->stu_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li>
	</ul>
</article>
<article>
	<div class="column1">
		<p>
		<span class="label"><?php echo $this->lang->line('stu_id'); ?></span>
		<?php if($row->stu_id) { ?><?php echo $row->stu_id; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('stu_owner'); ?></span>
		<?php if($row->mbr_name) { ?><?php echo $row->mbr_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('stu_name'); ?></span>
		<?php if($row->stu_name) { ?><?php echo $row->stu_name; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('stu_isclosed'); ?></span>
		<?php echo $this->lang->line('reply_'.$row->stu_isclosed); ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('stu_ordering'); ?></span>
		<?php if($row->stu_ordering) { ?><?php echo $row->stu_ordering; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('stu_datecreated'); ?></span>
		<?php if($row->stu_datecreated) { ?><?php echo $row->stu_datecreated; ?><?php } else { ?>-<?php } ?>
		</p>
	</div>
</article>
