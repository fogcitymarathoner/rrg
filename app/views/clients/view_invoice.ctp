<div class="client invoice view">
<h2><?php  __("Client's Invoice");?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($this->data['Invoice']['id'], array('controller'=> 'clients', 'action'=>'edit_invoice', $this->data['Invoice']['id'], 'next'=>'view_invoice')); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo date('m/d/Y',strtotime($this->data['Invoice']['date'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Period'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php
				echo date('m/d/Y',strtotime($this->data['Invoice']['period_start'])).'-'.
							date('m/d/Y',strtotime($this->data['Invoice']['period_end'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Amount'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo sprintf('%8.2f',round($this->data['Invoice']['amount'],2)); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __("term's"); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->data['Invoice']['terms']; ?>
			&nbsp;
		</dd>
		<dt<?php

        $datearray = getdate(strtotime($this->data['Invoice']['date']));
        $duedate  = mktime(0, 0, 0, date('m',strtotime($datearray['month']))  , $datearray['mday']+$this->data['Invoice']['terms'], $datearray['year']);

        if ($i % 2 == 0) echo $class;?>><?php __('Due date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo date('m/d/Y',strtotime(date('Y-m-d',$duedate))); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Client'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->data['Client']['Client']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->data['ClientsContract']['title']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<!-- begin invoice payments -->
<?php if (!empty($this->data['InvoicesPayment'])):?>

  <h3><?php __('Invoice Payments');?></h3>
   	<table cellpadding = "1" cellspacing = "1" border = '1'>
   	<tr>
   		<th><?php __('ID'); ?></th>
   		<th><?php __('Amount'); ?></th>
   		<th><?php __('Notes'); ?></th>
   		<th><?php __('Check ID'); ?></th>
   	</tr>
        	<?php
        		$i = 0;
        		foreach ($this->data['InvoicesPayment'] as $payment):
        			$class = null;
        			if ($i++ % 2 == 0) {
        				$class = ' class="altrow"';
        			}
        		?>
        		<tr<?php echo $class;?>>
        			<td><?php echo $payment['id'];?></td>
        			<td align=right><?php echo sprintf("%8.2f",$payment['amount']);?>
        			</td>
        			<td align=right><?php echo $payment['notes'];?>
        			</td>
        			<td>
        			<?php echo $payment['check_id'];?>
        			</td>

        		</tr>

        	<?php endforeach; ?>
        	</table>
        <?php endif; ?>
 <!-- end invoice payments -->

        <!-- begin invoice items -->
        <?php if (!empty($this->data['InvoicesItem'])):?>

        <h3><?php __('Invoice Items');?></h3>
           	<table cellpadding = "1" cellspacing = "1" border='1' >
           	<tr>
           		<th><?php __('Description'); ?></th>
           		<th><?php __('Quantity'); ?></th>
           		<th><?php __('Cost'); ?></th>
           		<th><?php __('amount'); ?></th>
           		<th><?php __('Line Item Amount'); ?></th>
           	</tr>
                	<?php
                		$i = 0;
                		foreach ($this->data['InvoicesItem'] as $item):
                			$class = null;
                			if ($i++ % 2 == 0) {
                				$class = ' class="altrow"';
                			}
                		?>
                		<tr<?php echo $class;?>>
                			<td><?php echo $item['description'];?></td>
                			<td align=right><?php echo sprintf("%8.2f",$item['quantity']);?></td>
                			<td align=right><?php echo sprintf("%8.2f",$item['cost']);?></td>
                			<td align=right><?php echo sprintf("%8.2f",$item['amount']);?></td>
                			<td align=right><?php echo sprintf("%8.2f",$item['amount']*$item['quantity']);?></td>
                			</td>
                		</tr>

                	<?php endforeach; ?>
                	</table>
                <?php endif; ?>
         <!-- end invoice items -->


                        <!-- begin employees payments -->
                        <?php if (!empty($this->data['EmployeesPayment'])):?>

                        <h3><?php __('Employee Payments');?></h3>
                           	<table cellpadding = "1" cellspacing = "1" border='1' >
                           	<tr>
                           		<th><?php __('Date'); ?></th>
                           		<th><?php __('Ref'); ?></th>
                           		<th><?php __('Amount'); ?></th>
                           		<th><?php __('Notes'); ?></th>
                           	</tr>
                                	<?php
                                		$i = 0;
                                		foreach ($this->data['EmployeesPayment'] as $payment):
                                			$class = null;
                                			if ($i++ % 2 == 0) {
                                				$class = ' class="altrow"';
                                			}
                                		?>
                                		<tr <?php echo $class;?>>
                                            <td><?php echo date('m/d/Y',strtotime($payment['date'])); ?> </td>
                                            <td><?php echo $payment['ref'];?></td>
                                            <td align=right><?php echo sprintf("%8.2f",$item['amount']);?></td>                    			<td align=right><?php echo sprintf("%8.2f",$payment['amount']);?></td>
                                		    <td><?php echo $payment['notes'];?></td>
                                		</tr>

                                	<?php endforeach; ?>
                                	</table>
                                <?php endif; ?>
                         <!-- end employees payments -->


                        <!-- begin timecard reminders log -->
                        <?php if (!empty($this->data['InvoicesTimecardReminderLog'])):?>

                         <h3><?php __('Timecard Reminders Log');?></h3>
                           	<table cellpadding = "1" cellspacing = "1" border='1' >
                           	<tr>
                           		<th><?php __('email'); ?></th>
                           		<th><?php __('timestamp'); ?></th>
                           	</tr>
                                	<?php
                                		$i = 0;
                                		foreach ($this->data['InvoicesTimecardReminderLog'] as $post):
                                			$class = null;
                                			if ($i++ % 2 == 0) {
                                				$class = ' class="altrow"';
                                			}
                                		?>
                                		<tr <?php echo $class;?>>
                                            <td><?php echo $post['email'];?></td>

                                            <td><?php echo $post['timestamp'];?></td>
                                		</tr>

                                	<?php endforeach; ?>
                                	</table>
                                <?php endif; ?>
                         <!-- end timecard reminders log -->


                                <!-- begin invoices post log -->
                                <?php if (!empty($this->data['InvoicesPostLog'])):?>

                                 <h3><?php __('Invoice Post Log');?></h3>
                                   	<table cellpadding = "1" cellspacing = "1" border='1' >
                                   	<tr>
                                   		<th><?php __('email'); ?></th>
                                   		<th><?php __('timestamp'); ?></th>
                                   	</tr>
                                        	<?php
                                        		$i = 0;
                                        		foreach ($this->data['InvoicesPostLog'] as $post):
                                        			$class = null;
                                        			if ($i++ % 2 == 0) {
                                        				$class = ' class="altrow"';
                                        			}
                                        		?>
                                        		<tr <?php echo $class;?>>
                                                    <td><?php echo $post['email'];?></td>

                                                    <td><?php echo $post['timestamp'];?></td>
                                        		</tr>

                                        	<?php endforeach; ?>
                                        	</table>
                                        <?php endif; ?>
                                 <!-- end invoices post log -->


                                        <!-- begin timecard receipt log -->
                                        <?php if (!empty($this->data['InvoicesTimecardReceiptLog'])):?>

                                         <h3><?php __('Timecard Receipt Log');?></h3>
                                           	<table cellpadding = "1" cellspacing = "1" border='1' >
                                           	<tr>
                                           		<th><?php __('email'); ?></th>
                                           		<th><?php __('timestamp'); ?></th>
                                           	</tr>
                                                	<?php
                                                		$i = 0;
                                                		foreach ($this->data['InvoicesTimecardReceiptLog'] as $post):
                                                			$class = null;
                                                			if ($i++ % 2 == 0) {
                                                				$class = ' class="altrow"';
                                                			}
                                                		?>
                                                		<tr <?php echo $class;?>>
                                                            <td><?php echo $post['email'];?></td>

                                                            <td><?php echo $post['timestamp'];?></td>
                                                		</tr>

                                                	<?php endforeach; ?>
                                                	</table>
                                                <?php endif; ?>
                                         <!-- end timecard receipt log -->