<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<my>
<?php if(isset($zones['content']) == 1) { ?><?php echo $zones['content']; ?><?php } ?>
<?php echo $this->my_library->get_debug(); ?>
</my>
