<?php echo $javascript->link('clients_view_contract');?>
<div class="clientsContracts view">
    <?php echo $this->element('contract_menu',array('contract'=>$clientsContract['ClientsContract'],'webroot'=>$this->webroot,'controller'=>$this->params['controller'])); ?>
<br>		<h3><?php echo $clientsContract['Client']['name']; ?> - Contract</h3>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsContract['ClientsContract']['title']; ?>
			&nbsp;
		</dd>
	</dl>
<div class="related">
	<h3><?php __('Invoice Email Recipients');?></h3>
	<?php if (!empty($clientsContract['ClientsManager'])):?>

	 
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Name'); ?></th>
		<th><?php __('Email'); ?></th>
	</tr>
	<?php
		foreach ($clientsContract['ClientsManager'] as $manager): 
				$class = null; 
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
				?>
		<tr<?php echo $class;?>>
			<td><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">
				<?php echo $manager['firstname'].' '.$manager['lastname'];?>
			</div></td>
			<td><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">
				<?php echo $manager['email']?>
			</div></td>
		</tr>

		<?php endforeach;?>		
	</table>
<?php endif; ?>	<?php if (!empty($clientsContract['User'])):?>

	 
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Name'); ?></th>
		<th><?php __('Email'); ?></th>
	</tr>
	<?php
		foreach ($clientsContract['User'] as $user): 
				$class = null; 
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
				?>
		<tr<?php echo $class;?>>
			<td><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">
				<?php echo $user['firstname'].' '.$user['lastname'];?>
			</div></td>
			<td><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">
				<?php echo $user['email']?>
			</div></td>
		</tr>

		<?php endforeach;?>		
	</table>
<?php endif; ?>

	<?php echo $html->link(__('Manage Email Recipients', true), array('action'=>'manage_contract_emails/'.$clientsContract['ClientsContract']['id'])); ?>
</div>
</div>
<?php echo $this->element('client/contract_actions', array('contract'=>$clientsContract['ClientsContract'],'webroot'=>$this->webroot)); ?>

