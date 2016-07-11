<div class="commissionsReportsTags form">
<?php echo $form->create('CommissionsReportsTag');?>
	<fieldset>
 		<legend><?php __('Add CommissionsReportsTag');?></legend>
	<?php
		echo $form->input('commissions_report_id');
		echo $form->input('name');
		echo $form->input('longname');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List CommissionsReportsTags', true), array('action' => 'index'));?></li>
	</ul>
</div>
