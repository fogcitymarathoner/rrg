<div class="contractsItemsCommissionsItems form">
<?php echo $form->create('Employees',array('action'=>'edit_contract_comm_item_fix'));?>

	<fieldset>
 		<legend><?php __('Edit Commissions');?></legend>
	<?php //debug($this->data);

		echo $form->input('ContractsItemsCommissionsItem.id',array('type'=>'hidden'));
		echo $form->input('ContractsItemsCommissionsItem.employee_id',array('label'=>'Sales Person'));
		echo $form->input('ContractsItemsCommissionsItem.contracts_items_id',array('type'=>'hidden'));
		echo $form->input('ContractsItemsCommissionsItem.percent');
		echo $form->input('ContractsItemsCommissionsItem.next',array('type'=>'hidden','value'=>$next));

		echo $form->input('ContractsItemsCommissionsItem.modified_user_id',
            array('name'=>'data[ContractsItemsCommissionsItem][modified_user_id]',
            'type'=>'hidden', 'value'=>$currentUser));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>


<?php echo $this->element('employees/contractactions',array('employee'=>$employee,'webroot'=>$this->webroot));?>