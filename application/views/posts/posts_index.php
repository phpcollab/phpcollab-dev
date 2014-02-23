<article class="title">
	<h2><i class="fa fa-<?php echo $this->config->item('phpcollab/icons/posts'); ?>"></i><?php echo $this->lang->line('posts'); ?> (<?php echo $position; ?>)</h2>
	<ul>
	<?php if($this->router->method != 'post') { ?>
		<li><a href="<?php echo $this->my_url; ?>topics/post/<?php echo $row->tcs_id; ?>"><i class="fa fa-plus"></i><?php echo $this->lang->line('create'); ?></a></li>
	<?php } ?>
	</ul>
</article>
<?php if($rows) { ?>
	<?php foreach($rows as $row) { ?>
	<article>
		<div class="column third">
			<p><?php echo $row->mbr_name; ?></p>
			<p><?php echo $this->my_library->timezone_datetime($row->pst_datecreated); ?> (<span class="timeago" title="<?php echo $this->my_library->timezone_datetime($row->pst_datecreated); ?>"></span>)</p>
		</div>
		<div class="column two-thirds">
			<p><?php echo nl2br($row->pst_description); ?></p>
		</div>
	</article>
	<?php } ?>
<div class="paging">
	<?php echo $pagination; ?>
</div>
<?php } ?>
