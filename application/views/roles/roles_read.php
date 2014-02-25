<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>roles"><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/roles') ?>"></i><?php echo $this->lang->line('roles'); ?></a> | <i class="fa fa-eye"></i><?php echo $row->rol_code; ?></h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>roles/update/<?php echo $row->rol_id; ?>"><i class="fa fa-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>
	<?php if($row->rol_system == 0) { ?><li><a href="<?php echo $this->my_url; ?>roles/delete/<?php echo $row->rol_id; ?>"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('delete'); ?></a></li><?php } ?>
	</ul>
</article>
<article>
	<div class="column half">
		<p>
		<span class="label"><?php echo $this->lang->line('rol_id'); ?></span>
		<?php if($row->rol_id) { ?><?php echo $row->rol_id; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('rol_code'); ?></span>
		<?php if($row->rol_code) { ?><?php echo $row->rol_code; ?><?php } else { ?>-<?php } ?>
		</p>
		<p>
		<span class="label"><?php echo $this->lang->line('rol_datecreated'); ?></span>
		<?php if($row->rol_datecreated) { ?><?php echo $this->my_library->timezone_datetime($row->rol_datecreated); ?> (<span class="timeago" title="<?php echo $this->my_library->timezone_datetime($row->rol_datecreated); ?>"></span>)<?php } else { ?>-<?php } ?>
		</p>
	</div>
	<div class="column half">
	</div>
</article>
<article class="title">
	<h2><?php echo $this->lang->line('permissions'); ?></h2>
</article>
<article>
	<div class="column third">
		<?php $u = 1; ?>
		<?php $title_previous = ''; ?>
		<?php foreach($permissions as $per) { ?>
			<?php list($title, $nice) = explode('/', $per->per_code, 2); ?>
			<?php if($title != $title_previous) { ?>
				<h3><?php echo $this->lang->line($title); ?></h3>
				<?php $title_previous = $title; ?>
			<?php } ?>
			<p<?php if($per->per_saved == 0) { ?> style="font-style:italic;text-decoration:line-through;"<?php } ?>><?php echo $nice; ?></p>
			<?php if($permissions_limit == $u) { ?>
				</div>
				<div class="column third">
				<?php $u = 1; ?>
			<?php } else { ?>
				<?php $u++; ?>
			<?php } ?>
		<?php } ?>
	</div>
</article>
