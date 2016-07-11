<script language="javascript" type="text/javascript" >
<!-- hide

function jumpto(x){
if (document.form1.jumpmenu.value != "null" && document.form1.jumpmenu.value != 'Select Payroll') {
document.location.href = x
}
}
// end hide -->
</script>
<div class="employeesPayments form">
<?php if($step == 1){ ?>
	<fieldset>
 		<legend><?php __('Select Payroll');?></legend>
<form name="form1">
<select name="jumpmenu" onChange="jumpto(document.form1.jumpmenu.options[document.form1.jumpmenu.options.selectedIndex].value)">
<option>Select Payroll</option>
<?php  
$keys = array_keys($payrolls);
foreach($keys as $key) {
	echo "<option value='./".$employee_id.'/2/'.$key.
				"'>".$payrolls[$key].'</option>';
}
?>
</select>
</form>
	</fieldset>
<?php } ?>
<?php if($step == 2){ ?>
<?php echo $form->create('Employees',array('action'=>'add_payment/'.$invoice['ClientsContract']['employee_id'].'/3/'.$invoice['Invoice']['id'])); ?>
	<fieldset>
 		<legend><?php __('Add Employees Payment');?></legend>
	<?php
		echo $form->input('EmployeesPayment.employee_id', array('type'=>'hidden','value'=>$invoice['ClientsContract']['employee_id']));
		echo $form->input('EmployeesPayment.invoice_id', array('type'=>'hidden','value'=>$invoice['Invoice']['id']));
		echo $form->input('EmployeesPayment.date');
		echo $form->input('EmployeesPayment.ref');
		echo $form->input('EmployeesPayment.amount',array('value'=>$amount_due));
		echo $form->input('EmployeesPayment.notes');
		echo $form->input('EmployeesPayment.modified_user_id',array('name'=>'data[EmployeesPayment][modified_user_id]','type'=>'hidden', 'value'=>$currentUser));
		echo $form->input('EmployeesPayment.created_user_id',array('name'=>'data[EmployeesPayment][created_user_id]','type'=>'hidden', 'value'=>$currentUser));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
<?php } ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Employee', true), array('action'=>'view', $employee_id)); ?> </li>
	</ul>
</div>
