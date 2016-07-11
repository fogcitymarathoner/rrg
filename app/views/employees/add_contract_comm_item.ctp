<?php //debug($this->data);?>
<div class="contractsItemsCommissionsItems form">
<?php echo $form->create('Employees',array('action'=>'add_contract_comm_item'));?>
	<fieldset>
 		<legend><?php __('Add Commissions');?></legend>
	<?php
		echo $form->input('employee_id',array('name'=>'data[ContractsItemsCommissionsItem][employee_id]','label'=>'Sales Person','empty' => '- select sales person -'));
		echo $form->input('ContractsItemsCommissionsItem.contracts_items_id',array('type'=>'hidden','value'=>$this->data['ContractsItemsCommissionsItem']['contracts_items_id']));
		echo $form->input('ContractsItemsCommissionsItem.percent',array('label'=>'Percentage'));

		echo $form->input('ContractsItemsCommissionsItem.next',array('type'=>'hidden','value'=>$next));
		
		echo $form->input('modified_user_id',array('name'=>'data[ContractsItemsCommissionsItem][modified_user_id]','type'=>'hidden', 'value'=>$currentUser));
		echo $form->input('created_user_id',array('name'=>'data[ContractsItemsCommissionsItem][created_user_id]','type'=>'hidden', 'value'=>$currentUser));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>

        <?php echo $this->element('employees/contractactions',array('employee'=>$employee,'webroot'=>$this->webroot));?>