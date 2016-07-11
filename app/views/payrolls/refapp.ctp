<?php echo $javascript->link('jquery.tablednd_0_5'); ?>
<script type="text/javascript">
function order_checks(data) {
    // The JQuery plugin tableDnD provides a serialize() function which provides the re-ordered 
    // data in a list. We pass that list as an object called "data" to a Django view 
    // to save the re-ordered data into the database.

            //alert(data);
    //alert(data);
	$.post("<?php echo $this->webroot;?>employees_payments/reorder_payments_renamed_to_work", data, "json");
    return False;
};

$(document).ready(function() {

    
});
</script>
<div class="payrolls view">
<h2><?php  __($page_title);
//debug($payments);
?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $payroll['Payroll']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Amount'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $payroll['Payroll']['amount']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo date('m/d/Y',strtotime($payroll['Payroll']['date'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Notes'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $payroll['Payroll']['notes']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Payroll', true), array('action' => 'select_check_directdeposit')); ?> </li>
	</ul>
	<ul>
		<li><?php echo $html->link(__('Edit Payroll', true), array('action' => 'edit', $payroll['Payroll']['id'])); ?> </li>
	</ul>
	<ul>
		<li><?php echo $html->link(__('Back to Manage', true), array('action' => 'view', $payroll['Payroll']['id'])); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Payments');?></h3>
	<?php if (!empty($payments)):
	
	
	echo $form->create('Payrolls',array('action'=>'refapp'));
	?>
	<table cellpadding="1" cellspacing="1" border=1>
	<tr>
		<th><?php __('Date'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Reference'); ?></th>
		<th><?php __('Notes'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	
	<?php echo $form->input('Payrolls.id', array('value'=>$payroll['Payroll']['id'], 'hidden'=>'True', 'label'=>''
			)); ?>
	<?php
		$i = 0;
		foreach ($payments as $pay):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
				<tr<?php echo $class;?>>
			<td><?php echo $pay['EmployeesPayment']['date'];?></td>
			<td><b><?php echo $pay['EmployeesPayment']['amount'];?></b></td>
			<td><?php echo $form->input('EmployeesPayment.ref', array('value'=>$pay['EmployeesPayment']['ref'], 'id'=>$pay['EmployeesPayment']['id'],
				'name'=>"data[EmployeesPayment][".    $pay['EmployeesPayment']['id']    ."]" , 'label'=>''
			)); ?>
			
			</td>
			<td><?php echo $pay['EmployeesPayment']['notes'];?></td>
			<td class="actions">
				<?php echo $html->link(__('Edit', true), array('action'=>'edit_employeepayment', $pay['EmployeesPayment']['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('action'=>'delete_employeepayment', $pay['EmployeesPayment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $pay['EmployeesPayment']['id'])); ?>
				<?php echo $html->link(__('View invoice', true), array('controller'=>'invoices','action'=>'view', 'target'=>'_blank',$pay['EmployeesPayment']['invoice_id'])); ?>
			</td>
		</tr>
		
		<tr<?php echo $class;?>>
			
			<td  >
	<?php
							$res =  $pay['Employee']['firstname'].' ';
							if($pay['Employee']['nickname']!='')
							{
								$res .=  '('.$pay['Employee']['nickname'].') ';
							}
							$res .=  $pay['Employee']['lastname'];
							echo $html->link(__($res, true), array('controller'=>'employees','action'=>'view', $pay['Employee']['id']));
	?>
	</td>
	<td></td>
			<td colspan=3 >
			<?php 
			$startdatearray = explode('-',$pay['Invoice']['period_start']);
			$startdatetime = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2], $startdatearray[0]);
			$enddatearray = explode('-',$pay['Invoice']['period_end']);
			$enddatetime = mktime(0, 0, 0, $enddatearray[1], $enddatearray[2], $enddatearray[0]);
			$start = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2] , $startdatearray[0]);
			$end = mktime(0, 0, 0, $enddatearray[1], $enddatearray[2] , $enddatearray[0]);
			$startstr = date("m.d.Y",$start);
			$endstr = date("m.d.Y",$end);
                    /*
							$filename =  'paystub_'.str_replace(' ','_',$pay['Employee']['firstname']).'_';
							if($pay['Employee']['nickname']!='')
							{
								$filename .=  $pay['Employee']['nickname'].'_';
							}
							$filename .=  $pay['Employee']['lastname'].'_';
							$filename .= $startstr.'_to_'.$endstr.'_'.$pay['EmployeesPayment']['securitytoken'];
			
			$ssn = str_replace('-','',$pay['Employee']['ssn']);
			$filename = str_replace(' ','_',$filename);
			$encrypt='pdftk '.$filename.'.pdf output '.$filename.'_encrypt.pdf owner_pw hello user_pw '.$ssn.' allow printing';
			
			*/
			
			?></td>
		</tr>


	<?php endforeach; ?>	
	<tr><td colspan=5><?php echo $form->end('Submit');?></td></tr>
	</table>
	

<?php endif; ?>
</div>