
<div class="clientsContracts view">
    <?php echo $this->element('contract_menu',array('contract'=>$clientsContract['ClientsContract'],'webroot'=>$this->webroot,'controller'=>$this->params['controller'])); ?>
<br>		<h3><?php echo $clientsContract['Client']['name']; ?> - Contract</h3>

    <?php echo $this->element('clients_auto_add_items',array());?>
	<div class="actions">
		<ul>
			<li>
			<?php echo $html->link(__('New Contracts Item', true), array('action'=>'add_contract_item', $clientsContract['ClientsContract']['id'],'next'=>$next)); ?>
			</li>
		</ul>
	</div>


	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsContract['ClientsContract']['title']; ?>
			&nbsp;
		</dd>
	</dl>

		</dd>
<div class="related">
<?php echo $this->element('contract_billable_items',array("items" => $items,'next'=>$next));?>
<?php echo $this->element('contract_billable_items_sorter',array("items" => $items,'next'=>$next));?>


</div>
</div>
<?php echo $this->element('client/contract_actions', array('contract'=>$clientsContract['ClientsContract'],'webroot'=>$this->webroot)); ?>
