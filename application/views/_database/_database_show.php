<article class="title">
	<h2><a href="<?php echo $this->my_url; ?>_database"><i class="fa fa-hdd-o"></i><?php echo $this->db->database; ?></a> | <i class="fa fa-eye"></i><?php echo $table; ?><?php if($status->Comment) { ?> (<?php echo $status->Comment; ?>)<?php } ?></h2>
</article>
<article>
	<table>
		<thead>
		<tr>
		<th>Field</th>
		<th>Type</th>
		<th>Collation</th>
		<th>Null</th>
		<th>Key</th>
		<th>Default</th>
		<th>Extra</th>
		<th>Comment</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<tr>
		<td><?php echo $row->Field; ?></td>
		<td><?php echo $row->Type; ?></td>
		<td><?php echo $row->Collation; ?></td>
		<td><?php echo $row->Null; ?></td>
		<td><?php echo $row->Key; ?></td>
		<td><?php echo $row->Default; ?></td>
		<td><?php echo $row->Extra; ?></td>
		<td><?php echo $row->Comment; ?></td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
</article>
