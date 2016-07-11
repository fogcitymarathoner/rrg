<div class="commissionsReportsTags form">

<?php echo $form->create('CommissionsReports',array('action'=>'add_report_tag')); //debug($this->data);?>
	<fieldset>
 		<legend><?php __('Add CommissionsReportsTag');?></legend>
	<?php
		echo $form->input('CommissionsReportsTag.commissions_report_id',array('value'=>$this->data['CommissionsReport']['id'],'type'=>'hidden'));

		echo $form->input('CommissionsReportsTag.employee_id',array('name'=>'data[ClientsContract][employee_id]','label'=>'Employee','empty' => '- add employee -'));
		
		echo $form->input('CommissionsReportsTag.name');
		echo $form->input('CommissionsReportsTag.longname');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to CommissionsReport', true), array('action' => 'view/'.$this->data['CommissionsReport']['id'])); ?> </li>
	</ul>
</div>