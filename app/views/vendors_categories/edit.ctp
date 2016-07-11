<div class="vendorsCategories form">
<?php echo $form->create('VendorsCategory');?>
	<fieldset>
 		<legend><?php __('Edit VendorsCategory');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('VendorsCategory.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('VendorsCategory.id'))); ?></li>
		<li><?php echo $html->link(__('List VendorsCategories', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Vendors', true), array('controller'=> 'vendors', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Vendor', true), array('controller'=> 'vendors', 'action'=>'add')); ?> </li>
	</ul>
</div>
