<?php //debug($this->viewVars); ?>
<?php //debug($this->data); exit; ?>
<?php echo $javascript->link('clients_view_contract');?>
    <?php echo $this->element('contract_menu',array('contract'=>$clientsContract['ClientsContract'],'webroot'=>$this->webroot,'controller'=>$this->params['controller'])); ?>

<div class="invoices view">
<h2><?php  __('Mock Invoice');?></h2>
<?php 
echo $crumb->getHtml('Invoice '.$this->data['Invoice']['id'], 'reset' ) ;  
echo '<br /><br />' ; 
echo $this->data['Invoice']['urltoken'].'<br>';
echo 'view count: ';
echo $this->data['Invoice']['view_count'].'<br>';

?>

<a href="<?php echo $this->webroot?>employees/edit_mock_invoice/<?php echo $this->data['Invoice']['id']?>">|edit|</a><br>
</div>
<div class="clientsContracts view">
	<fieldset>
 		<legend><?php __("Manage Contract's Billable Items");?></legend>
 
<h3><?php echo $clientsContract['ClientsContract']['title']; ?></h3>
<?php echo $clientsContract['Employee']['firstname'].' '.$clientsContract['Employee']['lastname']; ?>
 		
<div class="related">
<?php
        echo
$this->element('contract_billable_items',
array("items" => $items,
        'next'=>$next,
        'clientsContract'=>$clientsContract,
        'mock_invoice_id'=>$this->data['Invoice']['id'],
        ));
?>

</fieldset>
	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('Add Contract Item', true), array('action'=>'add_contract_item', $clientsContract['ClientsContract']['id'],'next'=>'view_mock_invoice')); ?>
		</ul>
	</div>
</div>

<?php echo $this->element('employees/contractactions',array('employee'=>$employee,'webroot'=>$this->webroot));?>