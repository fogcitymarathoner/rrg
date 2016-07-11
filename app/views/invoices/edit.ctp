
<div class="clientseditinvoice form">
    <?php echo $this->element('invoice/edit_form', array('data'=>$this->data)) ?>
</div>
<div class="actions">
	<ul>
        <li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Invoice.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Invoice.id'))); ?></li>
        <li><?php echo $html->link(__('List Invoices', true), array('action'=>'index'));?></li>
        <li><?php echo $html->link(__('List Clients Contracts', true), array('controller'=> 'clients_contracts', 'action'=>'index')); ?> </li>
        <li><?php echo $html->link(__('New Clients Contract', true), array('controller'=> 'clients_contracts', 'action'=>'add')); ?> </li>
        <li><?php echo $html->link(__('List Invoices Items', true), array('controller'=> 'invoices_items', 'action'=>'index')); ?> </li>
        <li><?php echo $html->link(__('New Invoices Item', true), array('controller'=> 'invoices_items', 'action'=>'add')); ?> </li>
        <li><?php echo $html->link(__('List Invoices Payments', true), array('controller'=> 'invoices_payments', 'action'=>'index')); ?> </li>
        <li><?php echo $html->link(__('New Invoices Payment', true), array('controller'=> 'invoices_payments', 'action'=>'add')); ?> </li>		<li><?php echo $html->link(__('Return to Client', true), array('controller'=>'clients','action'=>'view', $this->data['Client']['Client']['id'])); ?> </li>
	</ul>
</div>
