<div class="employeesPayments form">
<?php 
//debug($this->data);
echo $this->data['Employee']['firstname'].' '.$this->data['Employee']['lastname'].'<br>';
echo $this->data['Invoice']['period_start'].' '.$this->data['Invoice']['period_end'].'<br>';
echo $this->data['Client']['Client']['name'].'<br>';
echo $form->create('Payrolls',array('action'=>'edit_employeepayment'));?>
	<fieldset>
 		<legend><?php __('Edit EmployeesPayment');?></legend>
	<?php
		echo $form->input('EmployeesPayment.id', array('type'=>'hidden','value'=>$this->data['EmployeesPayment']['id']));
		echo $form->input('EmployeesPayment.payroll_id', array('type'=>'hidden','value'=>$this->data['EmployeesPayment']['payroll_id']));
		echo $form->input('EmployeesPayment.employee_id', array('type'=>'hidden','value'=>$this->data['Employee']['id']));
		echo $form->input('EmployeesPayment.invoice_id', array('type'=>'hidden','value'=>$this->data['Invoice']['id']));
		echo $form->input('EmployeesPayment.date', array('value'=>$this->data['EmployeesPayment']['date']));
		echo $form->input('EmployeesPayment.ref', array('value'=>$this->data['EmployeesPayment']['ref']));
		echo $form->input('EmployeesPayment.amount', array('value'=>$this->data['EmployeesPayment']['amount']));
		echo $form->input('EmployeesPayment.notes', array('value'=>$this->data['EmployeesPayment']['notes']));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('return to payroll', true), array('controller'=>'payrolls','action'=>'view', $this->data['EmployeesPayment']['payroll_id'])); ?> </li>
	</ul>
</div>