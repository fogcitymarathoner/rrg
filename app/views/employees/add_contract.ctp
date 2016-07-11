<?php //debug($clientsMenu);exit;//debug($step);
 //exit;
?>
<script language="javascript" type="text/javascript" >
<!-- hide

function jumpto(x){
if (document.form1.jumpmenu.value != "null" && document.form1.jumpmenu.value != 'Select Employee') {
document.location.href = x
}
}
// end hide -->
</script>
<div class="employees form">
<?php if($step == 1){  

	//$keys = array_keys($clientsMenu);
	//debug($keys);
?>
	<fieldset>
 		<legend><?php __($page_title);?></legend>
<form name="form1" autocomplete="off">
<select name="jumpmenu" onChange="jumpto(document.form1.jumpmenu.options[document.form1.jumpmenu.options.selectedIndex].value)">
<option>Select Client</option>
<?php  
	$keys = array_keys($clientsMenu);
	foreach($keys as $key) {
		echo "<option value='./".$this->data['ClientsContract']['client_id'].'/'.$this->data['ClientsContract']['employee_id'].'/2/'.$key.
				"'>".$clientsMenu[$key].'</option>';
	}
?>
</select>
</form>
</fieldset>
<?php
#### step 1
}
?>


<div class="employees form">
<?php if($step == 2){  

	//$keys = array_keys($employeesMenu);
	//debug($keys);
?>
<div class="clientsContracts form">
<?php echo $form->create('Employee',array('action'=>'add_contract'));?>



<?php echo $this->element('add_clients_contract_form', array(
							'ClientsContract'=>$this->data['ClientsContract'],
							)); 
?>
<?php echo $form->end('Submit');?>
</div>
<?php
#### step 2
}
?>








<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List EmployeesContracts', true), array('action'=>'view_contracts',$this->data['ClientsContract']['employee_id']));?></li>
	</ul>
</div>
