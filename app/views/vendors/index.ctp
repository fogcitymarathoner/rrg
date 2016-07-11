<style>
div.vendors.index  table tbody tr  td { padding-left:10px; padding-right:10px }
</style>

<div class="vendors index">
<h2><?php __('Vendors');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0" border=1>
<tr>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('purpose');?></th>

	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($vendors as $vendor):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link(__($vendor['Vendor']['name'], true), array('action'=>'view', $vendor['Vendor']['id'])); ?>
		</td>
		<td>
			<?php echo $vendor['Vendor']['purpose']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $vendor['Vendor']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $vendor['Vendor']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Vendor', true), array('action'=>'add')); ?></li>
	</ul>
</div>
