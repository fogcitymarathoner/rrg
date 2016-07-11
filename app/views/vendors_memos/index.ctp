<div class="vendorsMemos index">
<h2><?php __('VendorsMemos');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('vendor_id');?></th>
	<th><?php echo $paginator->sort('date');?></th>
	<th><?php echo $paginator->sort('notes');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($vendorsMemos as $vendorsMemo):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $vendorsMemo['VendorsMemo']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($vendorsMemo['Vendor']['name'], array('controller'=> 'vendors', 'action'=>'view', $vendorsMemo['Vendor']['id'])); ?>
		</td>
		<td>
			<?php echo $vendorsMemo['VendorsMemo']['date']; ?>
		</td>
		<td>
			<?php echo $vendorsMemo['VendorsMemo']['notes']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $vendorsMemo['VendorsMemo']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $vendorsMemo['VendorsMemo']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $vendorsMemo['VendorsMemo']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $vendorsMemo['VendorsMemo']['id'])); ?>
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
		<li><?php echo $html->link(__('New VendorsMemo', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Vendors', true), array('controller'=> 'vendors', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Vendor', true), array('controller'=> 'vendors', 'action'=>'add')); ?> </li>
	</ul>
</div>
