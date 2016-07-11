<div class="commissionsReportsTags form">
<?php echo $form->create('CommissionsReports',array('action'=>'edit_report_tag')); //debug($this->data);?>
	<fieldset>
 		<legend><?php __('Edit CommissionsReportsTag');?></legend>
	<?php
		echo $form->input('CommissionsReportsTag.id',array('type'=>'hidden'));
		echo $form->input('CommissionsReportsTag.commissions_report_id',array('value'=>$this->data['CommissionsReport']['id'],'type'=>'hidden'));
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