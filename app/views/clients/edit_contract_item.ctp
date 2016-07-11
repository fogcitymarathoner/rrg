<?php echo $javascript->link('contract_item_form_validate'); ?>
<div class="contractsItems form">
<?php echo $form->create('Clients',array('action'=>'edit_contract_item','id'=>'addedit_contract_item','onsubmit'=>'return validateForm()'));?>
	<fieldset>
 		<legend><?php __($page_title);?></legend>
	<?php
		echo "On-site Regular";
		echo $form->input('ContractsItem.description', array('maxlength' => 60,'size' => 60,'class'=>'textInput'));
		echo $form->input('ContractsItem.amt', array('label' => 'Bill Out Amount')); 
		echo $form->input('ContractsItem.cost', array('label' => 'Wage Paid to Worker')); 
		echo $form->input('ContractsItem.Notes');
		echo $form->input('active',array('name'=>'data[ContractsItem][active]','value'=>$this->data['ContractsItem']['active'],'options'=>$activeOptions));

		echo $form->input('modified_user_id',array('name'=>'data[ContractsItem][modified_user_id]','type'=>'hidden', 'value'=>$currentUser));
		echo $form->input('ContractsItem.id',array('type'=>'hidden'));
		echo $form->input('ContractsItem.contract_id',array('type'=>'hidden'));
		echo $form->input('ContractsItem.next',array('type'=>'hidden','value'=>$next));
		
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>

<?php 

			$res = '<div class="actions">';
			$res .= '<ul>	';
			$res .= '<li><a href="'.$this->webroot.'clients/view_contract_items/'.$this->data['ContractsItem']['contract_id'].'">Cancel</a> </li>';
			$res .= '</ul>';
			$res .= '</div>';
			echo $res;
?>
