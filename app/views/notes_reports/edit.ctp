<div class="commissionsReports form">
<?php echo $form->create('CommissionsReport');?>
	<fieldset>
 		<legend><?php __('Edit CommissionsReport');?></legend>
	<?php
		echo $form->input('title');
		echo $form->input('notes');
		echo $form->input('previous_balance');
		echo $form->input('start');
		echo $form->input('end');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('CommissionsReport.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('CommissionsReport.id'))); ?></li>
		<li><?php echo $html->link(__('List CommissionsReports', true), array('action' => 'index'));?></li>
	</ul>
</div>