<?php //debug($this->viewVars); ?>
<?php //debug($this->data); ?>
<div class="invoices view">
<h2><?php  __($page_title);?></h2>
<?php echo $crumb->getHtml('Invoice '.$this->data['Invoice']['id'], 'reset' ) ;  
echo '<br /><br />' ; ?>
<div class="actions">
	<ul>
		<li>
			<?php echo $html->image('icons/pencil.png', array('width' => 20, 'height' => 20,
			'url'=>'edit/'.$this->data['Invoice']['id'], 'title'=>"Edit Invoice"
			)); ?>		
		</li>
	</ul> 
</div>
<div class="related">
	<h3><?php __('Line Items');?></h3>
	<?php if (!empty($this->data['InvoicesItem'])):?>
	<table cellpadding = "3" cellspacing = "3" border=1>
	<tr>
		<th><?php __('Description'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Quantity'); ?></th>
		<th><?php __('Cost'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($this->data['InvoicesItem'] as $this->datasItem):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>

    <?php /// kludge!  skipping comm items debug($this->datasItem)?>
    <?php if(isset($this->datasItem['invoice_id']))
          {
            ?>
		<tr<?php echo $class;?>>
    <?php //debug($this->datasItem)?>
			<td><?php echo $this->datasItem['description'];?></td>
			<td><?php echo number_format($this->datasItem['amount'],2);?></td>
			<td><?php echo $this->datasItem['quantity'];?></td>
			<td><?php echo $this->datasItem['cost'];?></td>
			<td class="actions">
				<?php //echo $html->link(__('Edit', true), array('controller'=> 'invoices_items', 'action'=>'edit', $this->datasItem['id'])); ?>
			<?php //echo $html->image('icons/redx.png', array('width' => 20, 'height' => 20,
			//'url'=>
			//'/invoices_items/delete/'.$this->datasItem['id'].'/return:invoices+slash+view+slash+'.$this->data['Invoice']['id']
			//, 'title'=>"Delete this Line Item"
			//)); ?>
			<?php //echo $html->image('icons/pencil.png', array('width' => 20, 'height' => 20,
			//'url'=>
			//'/invoices_items/edit/'.$this->datasItem['id'], 'title'=>"Edit this Line Item"
			///)); ?>
				<?php //echo $html->link(__('Delete', true), array('controller'=> 'invoices_items', 
				//'action'=>'delete', 
				//'return'=>'invoices+slash+view+slash+'.$this->data['Invoice']['id'], 
				//$this->datasItem['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->datasItem['id'])); ?>
			</td>
		</tr>
    <?php } ?>
	<?php endforeach; ?>
    <?php if(isset($this->datasItem['invoice_id']))
            {
            ?>
			<tr<?php echo $class;?>>
			<td></td>
			<td><?php echo sprintf('%8.2f',round($this->data['Invoice']['amount'],2));?></td>
			<td><?php echo $this->datasItem['quantity'];?></td>
			<td><?php echo sprintf('%8.2f',round($this->data['Invoice']['wagetotal'],2));?></td>
			<td></td>
		</tr>
        <?php } ?>
	</table>
    <h3>External Link</h3>
    <p><?php echo $invoiceurltoken?></p>
<?php endif; ?>
	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Invoices Item', true),
			array('controller'=> 'invoices_items', 'action'=>'add','invoice_id'=>$this->data['Invoice']['id']));?> </li>
		</ul>
	</div>
</div>

	<dl><?php $i = 0; $class = ' class="altrow"';?>		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->data['Invoice']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Client'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contract['Client']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Clients Contract'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($contract['ClientsContract']['title'], array('controller'=> 'clients', 'action'=>'view_contract', $contract['ClientsContract']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo date('m/d/Y',strtotime($this->data['Invoice']['date'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Po'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->data['Invoice']['po']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Employerexpenserate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->data['Invoice']['employerexpenserate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Terms'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->data['Invoice']['terms']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Timecard'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->data['Invoice']['timecard']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Posted'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->data['Invoice']['posted']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cleared'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->data['Invoice']['cleared']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('PRCleared'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->data['Invoice']['prcleared']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Timecard Receipt Sent'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->data['Invoice']['timecard_receipt_sent']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Voided'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->data['Invoice']['voided']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Notes'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->data['Invoice']['notes']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Invoice Message'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->data['Invoice']['message']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Period Start'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo date('m/d/Y',strtotime($this->data['Invoice']['period_start'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Period End'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo date('m/d/Y',strtotime($this->data['Invoice']['period_end'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Amount'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo sprintf('%8.2f',round($this->data['Invoice']['amount'],2)); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Balance'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo sprintf('%8.2f',round($this->data['Invoice']['balance'],2)); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('wagetotal'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo sprintf('%8.2f',round($this->data['Invoice']['wagetotal'],2)); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="related">
	<h3><?php __('Payments');?></h3>
	<?php if (!empty($this->data['InvoicesPayment'])):?>
	<table cellpadding = "3" cellspacing = "3" border=1>
	<tr>
		<th><?php __('Date'); ?></th>
		<th><?php __('Reference'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Notes'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($this->data['InvoicesPayment'] as $this->datasPayment):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			} 
		?>
		<tr<?php echo $class;?>>
			<td><?php echo date('m/d/Y',strtotime($this->datasPayment['ClientsCheck']['date']));?></td>
			<td><?php echo $this->datasPayment['ClientsCheck']['number'];?></td>
			<td><?php echo number_format($this->datasPayment['amount'],2);?></td>
			<td><?php echo $this->datasPayment['notes'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'invoices_payments', 'action'=>'view', $this->datasPayment['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	<tr<?php echo $class;?>>
		<td></td>
		<td></td>
		<td><?php echo $this->data['Invoice']['totalpayment'];?></td>
		<td></td>
		<td></td>
	</tr>
	</table>
<?php endif; ?>
</div>
<div class="related">
	<h3><?php __('Employees Payments');?></h3>
	<?php if (!empty($this->data['EmployeesPayment'])):?>
	<table cellpadding = "3" cellspacing = "3" border=1>
	<tr>
		<th><?php __('Date'); ?></th>
		<th><?php __('Reference'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Notes'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($this->data['EmployeesPayment'] as $employeesPayment):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo date('m/d/Y',strtotime($employeesPayment['date']));?></td>
			<td><?php echo $employeesPayment['ref'];?></td>
			<td><?php echo number_format($employeesPayment['amount'],2);?></td>
			<td><?php echo $employeesPayment['notes'];?></td>
			<td class="actions">
				<?php echo $html->link(__('Edit', true), array('action'=>'edit_employee_payment', $employeesPayment['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('action'=>'delete_employee_payment', $employeesPayment['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $employeesPayment['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	<tr<?php echo $class;?>>
		<td></td>
		<td></td>
		<td><?php echo $this->data['Invoice']['employeeTotalPay'];?></td>
		<td></td>
		<td></td>
	</tr>
	</table>
<?php endif; ?>
</div>

<div class="related">
	<h3><?php __('Timecard Reminders Log');?></h3>
	<?php if (!empty($this->data['InvoicesTimecardReminderLog'])):?>
	<table cellpadding = "3" cellspacing = "3" border=1>
	<tr>
		<th><?php __('Email'); ?></th>
		<th><?php __('Timestamp'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($this->data['InvoicesTimecardReminderLog'] as $logarticle):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $logarticle['email'];?></td>
			<td><?php echo $logarticle['timestamp'];?></td>
		</tr>
	<?php endforeach; ?>
	</table>
	<?php endif; ?>

</div>
<div class="related">
	<h3><?php __('Invoice Post Log');?></h3>
	<?php if (!empty($this->data['InvoicesPostLog'])):?>
	<table cellpadding = "3" cellspacing = "3" border=1>
	<tr>
		<th><?php __('Email'); ?></th>
		<th><?php __('Timestamp'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($this->data['InvoicesPostLog'] as $logarticle):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $logarticle['email'];?></td>
			<td><?php echo $logarticle['timestamp'];?></td>
		</tr>
	<?php endforeach; ?>
	</table>
	<?php endif; ?>

</div>
<div class="related">
	<h3><?php __('Timecard Receipt Log');?></h3>
	<?php if (!empty($this->data['InvoicesTimecardReceiptLog'])):?>
	<table cellpadding = "3" cellspacing = "3" border=1>
	<tr>
		<th><?php __('Email'); ?></th>
		<th><?php __('Timestamp'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($this->data['InvoicesTimecardReceiptLog'] as $logarticle):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $logarticle['email'];?></td>
			<td><?php echo $logarticle['timestamp'];?></td>
		</tr>
	<?php endforeach; ?>
	</table>
	<?php endif; ?>

</div>
        <table>
        <?php

                echo $form->create('Invoices',array('action'=>'fix_commissions_items'));

                //echo $form->input('Invoice.id', array('label' => 'invoice id','value'=>$this->data['Invoice']['id'] ,'id'=>"invoice_id",'name'=>"invoice_id"));

                $j=1;
                foreach($this->data['InvoicesItem'] as $item)
                {
                    if(!empty($item['InvoicesItemsCommissionsItem']))
                    {
                        $i =1;
                        foreach($item['InvoicesItemsCommissionsItem'] as $citem)
                        {
                        //debug($citem);

                        $class = null;
                        if ($i++ % 2 == 0) {
                        $class = ' class="altrow"';
                        }
                        echo '<tr '.$class.'><td>';
                        echo $citem['description'].' - '.$employees[$citem['employee_id']];
                        echo $form->input('Item.id', array('label' => 'id','value'=>$citem['id'] ,'id'=>"data[".$j."][id]",'name'=>"data[".$j."][id]"));

                        echo $form->input('Item.invoice_id', array('type'=>'text','label' => 'invoice_id','value'=>$this->data['Invoice']['id'] ,'id'=>"data[".$j."][invoice_id]",'name'=>"data[".$j."][invoice_id]"));
                        echo $form->input('Item.percent', array('label' => 'percent','value'=>$citem['percent'] ,'id'=>"data[".$j."][percent]",'name'=>"data[".$j."][percent]"));
                        echo $form->input('Item.quantity', array('label' => 'rel_item_quantity','value'=>$citem['rel_item_quantity'] ,'id'=>"data[".$j."][rel_item_quantity]",'name'=>"data[".$j."][rel_item_quantity]"));


                        $j++;
                        echo '</td></tr>';
                    }
                    }
                    $i++;
                }
                echo '<tr><td>';
                echo $form->end('Fix Items');
                echo '</td></tr>';
                ?>
        </table>