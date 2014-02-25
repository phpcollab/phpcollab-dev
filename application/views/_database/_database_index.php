<article class="title">
	<h2><i class="fa fa-hdd-o"></i><?php echo $this->db->database; ?> (<?php echo count($rows); ?>)</h2>
	<ul>
	<li><a href="<?php echo $this->my_url; ?>_database/optimize"><i class="fa fa-bolt"></i><?php echo $this->lang->line('optimize'); ?></a></li>
	</ul>
</article>
<article>
	<table>
		<thead>
		<tr>
		<th class="sort_asc"><span>Name</span></th>
		<th>Engine</th>
		<th>Collation</th>
		<th>Rows</th>
		<th>Auto_increment</th>
		<th>Data_length</th>
		<th>Index_length</th>
		<th class="hide-tablet">Create_time</th>
		<th class="hide-tablet">Update_time</th>
		<th>Comment</th>
		<th>&nbsp;</th>
		</tr>
		</thead>
		<?php $total_rows = 0; ?>
		<?php $total_data = 0; ?>
		<?php $total_index = 0; ?>
		<tbody>
		<?php foreach($rows as $row) { ?>
		<?php $total_rows += $row->Rows; ?>
		<?php $total_data += $row->Data_length; ?>
		<?php $total_index += $row->Index_length; ?>
		<tr>
		<td><a href="<?php echo $this->my_url; ?>_database/show/<?php echo $row->Name; ?>"><?php echo $row->Name; ?></a></td>
		<td><?php if(isset($row->Engine) == 1) { ?><?php echo $row->Engine; ?><?php } else { ?><?php echo $row->Type; ?><?php } ?></td>
		<td><?php echo $row->Collation; ?></td>
		<td><?php echo $row->Rows; ?></td>
		<td><?php if($row->Auto_increment) { ?><?php echo $row->Auto_increment; ?><?php } else { ?>-<?php } ?></td>
		<td><?php echo convert_size($row->Data_length); ?></td>
		<td><?php echo convert_size($row->Index_length); ?></td>
		<td class="hide-tablet"><?php echo $row->Create_time; ?></td>
		<td class="hide-tablet"><?php echo $row->Update_time; ?></td>
		<td><?php if($row->Comment) { ?><?php echo $row->Comment; ?><?php } else { ?>-<?php } ?></td>
		<th>&nbsp;</th>
		</tr>
		<?php } ?>
		<tr>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th><strong><?php echo $total_rows; ?></strong></th>
		<th>&nbsp;</th>
		<th><strong><?php echo convert_size($total_data); ?></strong></th>
		<th><strong><?php echo convert_size($total_index); ?></strong></th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		</tr>
		</tbody>
	</table>
</article>
