<?php if(isset($zones['content']) == 1) { ?><?php echo json_encode(array_merge($zones['content'], $this->my_library->get_debug())); ?><?php } else { ?><?php echo json_encode($this->my_library->get_debug()); ?><?php } ?>
