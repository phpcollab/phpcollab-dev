<article class="title">
	<h2><i class="fa fa-home"></i><?php echo $this->lang->line('home'); ?></h2>
	<ul>
	</ul>
</article>

<?php if($this->auth_library->permission('tasks/index')) { ?><?php echo $this->tasks_model->get_index_list(false, false); ?><?php } ?>

<?php if($this->auth_library->permission('projects/index')) { ?><?php echo $this->projects_model->get_index_list(false); ?><?php } ?>

<?php if($this->auth_library->permission('notes/index')) { ?><?php echo $this->notes_model->get_index_list(false); ?><?php } ?>
