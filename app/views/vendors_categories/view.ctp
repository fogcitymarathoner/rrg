<div class="vendorsCategories view">
<h2><?php  __('VendorsCategory');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vendorsCategory['VendorsCategory']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vendorsCategory['VendorsCategory']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit VendorsCategory', true), array('action'=>'edit', $vendorsCategory['VendorsCategory']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete VendorsCategory', true), array('action'=>'delete', $vendorsCategory['VendorsCategory']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $vendorsCategory['VendorsCategory']['id'])); ?> </li>
		<li><?php echo $html->link(__('List VendorsCategories', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New VendorsCategory', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Vendors', true), array('controller'=> 'vendors', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Vendor', true), array('controller'=> 'vendors', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Vendors');?></h3>
	<?php if (!empty($vendorsCategory['Vendor'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Purpose'); ?></th>
		<th><?php __('Street1'); ?></th>
		<th><?php __('Street2'); ?></th>
		<th><?php __('City'); ?></th>
		<th><?php __('State'); ?></th>
		<th><?php __('Zip'); ?></th>
		<th><?php __('Ssn'); ?></th>
		<th><?php __('Apfirstname'); ?></th>
		<th><?php __('Aplastname'); ?></th>
		<th><?php __('Apemail'); ?></th>
		<th><?php __('Apphonetype1'); ?></th>
		<th><?php __('Apphone1'); ?></th>
		<th><?php __('Apphonetype2'); ?></th>
		<th><?php __('Apphone2'); ?></th>
		<th><?php __('Accountnumber'); ?></th>
		<th><?php __('Notes'); ?></th>
		<th><?php __('State Id'); ?></th>
		<th><?php __('Category Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($vendorsCategory['Vendor'] as $vendor):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $vendor['id'];?></td>
			<td><?php echo $vendor['name'];?></td>
			<td><?php echo $vendor['purpose'];?></td>
			<td><?php echo $vendor['street1'];?></td>
			<td><?php echo $vendor['street2'];?></td>
			<td><?php echo $vendor['city'];?></td>
			<td><?php echo $vendor['state'];?></td>
			<td><?php echo $vendor['zip'];?></td>
			<td><?php echo $vendor['ssn'];?></td>
			<td><?php echo $vendor['apfirstname'];?></td>
			<td><?php echo $vendor['aplastname'];?></td>
			<td><?php echo $vendor['apemail'];?></td>
			<td><?php echo $vendor['apphonetype1'];?></td>
			<td><?php echo $vendor['apphone1'];?></td>
			<td><?php echo $vendor['apphonetype2'];?></td>
			<td><?php echo $vendor['apphone2'];?></td>
			<td><?php echo $vendor['accountnumber'];?></td>
			<td><?php echo $vendor['notes'];?></td>
			<td><?php echo $vendor['state_id'];?></td>
			<td><?php echo $vendor['category_id'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'vendors', 'action'=>'view', $vendor['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'vendors', 'action'=>'edit', $vendor['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'vendors', 'action'=>'delete', $vendor['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $vendor['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Vendor', true), array('controller'=> 'vendors', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
