<style>
div.payrolls.view {
font-size: 14pt;

</style>



<?php echo $javascript->link('jquery.tablednd_0_5'); ?>
<?php echo $html->css('urls');?>
<?php echo $html->css('payrolls');?>
<?php echo $this->element('urls',array());?>
<?php echo $html->script('payrolls');?>
<div id='payroll-menu'>
    <?php echo $this->element('payroll/menu', array('payroll'=>$payroll['Payroll'],'webroot'=>$this->webroot,));?>
</div>
<br>
<div class="payrolls view">
    <h2><?php
            __($page_title);?></h2>
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
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Security Token'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $payroll['Payroll']['securitytoken']; ?>
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
		<li><?php echo $html->link(__('Edit Check Numbers', true), array('action' => 'refapp', $payroll['Payroll']['id'])); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Payments');?></h3>
	<?php if (!empty($payments)):?>
	<table cellpadding="1" cellspacing="1" border=1>
	<tr>
		<th><?php __('Date'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Reference'); ?></th>
		<th><?php __('Notes'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
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
			<td><?php echo $pay['EmployeesPayment']['ref'];?></td>
			<td><?php echo $pay['EmployeesPayment']['notes'];?></td>
			<td class="actions">
				<?php echo $html->link(__('Edit', true), array('action'=>'edit_employeepayment', $pay['EmployeesPayment']['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('action'=>'delete_employeepayment', $pay['EmployeesPayment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $pay['EmployeesPayment']['id'])); ?>
				<?php echo $html->link(__('View invoice', true), array('controller'=>'invoices','action'=>'view', $pay['EmployeesPayment']['invoice_id'])); ?>
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
            $res .=  ' #'.$pay['Employee']['payment_number'];
            echo $html->link(__($res, true), array('controller'=>'employees','action'=>'view_payments', $pay['Employee']['id']));
	?>
	</td>
	<td><?php echo 'payment #'.$i;?></td>
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
            $filename =  'paystub_'.str_replace(' ','_',$pay['Employee']['firstname']).'_';
            if($pay['Employee']['nickname']!='')
            {
                $filename .=  $pay['Employee']['nickname'].'_';
            }
            $filename .=  $pay['Employee']['lastname'].'_';
            $filename .= $startstr.'_to_'.$endstr.'_'.$pay['EmployeesPayment']['securitytoken'];

			$ssn = str_replace('-','',$pay['Employee']['ssn']);
			$filename = str_replace(' ','_',$filename);
			$encrypt='pdftk '.$filename.'.pdf output '.$filename.'_encrypt.pdf owner_pw hello user_pw '.$ssn.' allow printing compress';



			?></td>
		</tr>
		<?php
		//debug($pay);exit;
if (!empty($pay['Invoice']))
{
			$j = 0;
	foreach ($pay['Invoice']['InvoicesItem'] as $payitem):
		echo '<tr '.$class.'>';
//debug($payitem);
			if($payitem['quantity']*$payitem['cost'] )
			{
?>
		<tr<?php echo $class;?>>
	<td>

<b><?php echo $payitem['description']?>:</b></td>	
	<td>

<?php echo 'Hours:<b>'.$payitem['quantity'].'</b>'?>:</td>	
	<td>

<?php echo $payitem['cost']?>:</td>	
	<td>

<?php echo '<b>'.number_format  ($payitem['quantity']*$payitem['cost'],2).'</b>'?>:</td>	
<?php 
		}
endforeach;
}
        ?>


	<?php endforeach; ?>	
	</table>
<?php endif; ?>
</div>
<div class="related">
	<h3><?php __('Paystub File Names');?></h3>
	<?php if (!empty($payments)):?>
	<table cellpadding="1" cellspacing="1" border=1>
	<?php
		$i = 0;
		foreach ($payments as $pay):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>

	<td></td>
			<?php 
			$startdatearray = explode('-',$pay['Invoice']['period_start']);
			$startdatetime = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2], $startdatearray[0]);
			$enddatearray = explode('-',$pay['Invoice']['period_end']);
			$enddatetime = mktime(0, 0, 0, $enddatearray[1], $enddatearray[2], $enddatearray[0]);
			$start = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2] , $startdatearray[0]);
			$end = mktime(0, 0, 0, $enddatearray[1], $enddatearray[2] , $enddatearray[0]);
			$startstr = date("m.d.Y",$start);
			$endstr = date("m.d.Y",$end);
            $filename =  'paystub_'.str_replace(' ','_',$pay['Employee']['firstname']).'_';
            if($pay['Employee']['nickname']!='')
            {
                $filename .=  $pay['Employee']['nickname'].'_';
            }
            $filename .=  $pay['Employee']['lastname'].'_';
            $filename .= $startstr.'_to_'.$endstr.'_'.$pay['EmployeesPayment']['securitytoken'];

            $filename = str_replace(' ','_',$filename);
			$ssn = str_replace('-','',$pay['Employee']['ssn']);
			$filename = str_replace(' ','_',$filename);
			$encrypt='pdftk '.$filename.'.pdf output '.$filename.'_encrypt.pdf owner_pw hello user_pw '.$ssn.' allow printing compress';
			
			
			
			?>

		<tr<?php echo $class;?>>
			<td colspan=5 > 
			<?php echo $pay['EmployeesPayment']['filename'].'.pdf'; ?>
			</td>
		</tr>
		<?php
		foreach ($pay['Employee']['EmployeesEmail'] as $employeesEmail):
		?>
		<tr<?php echo $class;?>>
			<td colspan = 5>
                <?php echo $this->element('employee_email_paystub_button', array(
                    'employeesEmail'=>$employeesEmail,
                    'first_last'=>$pay['Employee']['firstname'].' '.$pay['Employee']['lastname'],
                    'subject'=>$filename,
                    'body' => 'Hi, The password is your social security number without hyphens.  FYI',
                    ));
                ?>
			</td>
		</tr>
	<?php endforeach; ?>

	<?php endforeach; ?>	
	</table>
<?php endif; ?>
</div>

<div class="related">
	<h3><?php __('Paystub File Names sort app');?></h3>
	<?php if (!empty($payments)):?>
	<table cellpadding="1" cellspacing="1"  id="paymenttable" border=1>
	<?php
		$i = 0;
		foreach ($payments as $pay):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
			<?php 
			$startdatearray = explode('-',$pay['Invoice']['period_start']);
			$startdatetime = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2], $startdatearray[0]);
			$enddatearray = explode('-',$pay['Invoice']['period_end']);
			$enddatetime = mktime(0, 0, 0, $enddatearray[1], $enddatearray[2], $enddatearray[0]);
			$start = mktime(0, 0, 0, $startdatearray[1], $startdatearray[2] , $startdatearray[0]);
			$end = mktime(0, 0, 0, $enddatearray[1], $enddatearray[2] , $enddatearray[0]);
			$startstr = date("m.d.Y",$start);
			$endstr = date("m.d.Y",$end);
            $filename =  'paystub_'.str_replace(' ','_',$pay['Employee']['firstname']).'_';
            if($pay['Employee']['nickname']!='')
            {
                $filename .=  $pay['Employee']['nickname'].'_';
            }
            $filename .=  $pay['Employee']['lastname'].'_';
            $filename .= $startstr.'_to_'.$endstr.'_'.$pay['EmployeesPayment']['securitytoken'];
			
			$ssn = str_replace('-','',$pay['Employee']['ssn']);
			$filename = str_replace(' ','_',$filename);
			$encrypt='pdftk '.$filename.'.pdf output '.$filename.'_encrypt.pdf owner_pw hello user_pw '.$ssn.' allow printing compress';
			?>
		<tr<?php echo $class;?> id="<?php echo $pay['EmployeesPayment']['id'];?>">
		<td><?php echo $i?></td>
			<td colspan=5 > 
			<?php echo $pay['EmployeesPayment']['filename'].'.pdf'; ?>
			</td>
		</tr>
	<?php endforeach; ?>	
	</table>
<?php endif; ?>
</div>
<div class="related">
    <?php echo $this->element('payrolls/encryption_script',array('payments'=>$payments,'step1_script'=>$step1_script)); ?>
</div>
