<div class="vendors view">
<h2><?php  __('Vendor'); ?></h2>

	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Purpose'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vendor['Vendor']['purpose']; ?>
			&nbsp;
		</dd>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
			echo strtoupper($vendor['Vendor']['name']).'<br>';
			if (strlen($vendor['Vendor']['street1']) > 0 ) 
			{
				echo strtoupper($vendor['Vendor']['street1']).'<br>';
			}
			if (strlen($vendor['Vendor']['street2']) > 0 ) 
			{
				echo strtoupper($vendor['Vendor']['street2']).'<br>';
			}
			echo strtoupper($vendor['Vendor']['city'].', '.$vendor['State']['post_ab'].' '.$vendor['Vendor']['zip'].'<br>');
			?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Apfirstname'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vendor['Vendor']['apfirstname']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Aplastname'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vendor['Vendor']['aplastname']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Apemail'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vendor['Vendor']['apemail']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Apphone1'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vendor['Vendor']['apphone1']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Apphone2'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vendor['Vendor']['apphone2']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Accountnumber'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vendor['Vendor']['accountnumber']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Notes'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vendor['Vendor']['notes']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('State'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($vendor['State']['name'], array('controller'=> 'states', 'action'=>'view', $vendor['State']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Vendor', true), array('action'=>'edit', $vendor['Vendor']['id'])); ?> </li>
		<li><?php echo $html->link(__('Return to Vendor List', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Vendors Memo', true), array('controller'=> 'vendors_memos', 'action'=>'add','vendor_id'=>$vendor['Vendor']['id'] )); ?> </li>
	</ul>
</div>
<style>
div.related table tbody tr td {padding-left: 10px}
div.related table tbody tr td:first-child {width: 80px}
</style>
<div class="related">
	<h3><?php __('Vendors Memos');?></h3>
	<?php if (!empty($vendor['VendorsMemo'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Date'); ?></th>
		<th><?php __('Notes'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($vendor['VendorsMemo'] as $vendorsMemo):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $vendorsMemo['date'];?></td>
			<td><?php echo $vendorsMemo['notes']; ?></td>
			<td class="actions">
				<?php echo $html->link(__('edit', true), array('controller'=> 'vendors_memos', 'action'=>'edit', $vendorsMemo['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'vendors_memos', 'action'=>'delete', $vendorsMemo['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $vendorsMemo['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
		<li><?php echo $html->link(__('New Vendors Memo', true), array('controller'=> 'vendors_memos', 'action'=>'add','vendor_id'=>$vendor['Vendor']['id'] )); ?> </li>
		</ul>
	</div>
</div>
