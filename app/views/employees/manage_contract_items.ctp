<div class="clientsContracts view">
	<fieldset>
 		<legend><?php __("Manage Contract's Billable Items");?></legend>
 
<h3><?php echo $clientsContract['ClientsContract']['title']; ?></h3>
<?php echo $clientsContract['Employee']['firstname'].' '.$clientsContract['Employee']['lastname']; ?>
 		
<div class="related">
	<h3><?php __("Contract's Items");?></h3>
	<?php if (!empty($items)):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Description'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Cost'); ?></th>
		<th><?php __('Notes'); ?></th>
		<th><?php __('act/inact'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php 
		$i = 0;
		foreach ($items as $contractsItem):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $contractsItem['ContractsItem']['description'];?></td>
			<td align=right><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">
			<?php echo sprintf("%8.2f",$contractsItem['ContractsItem']['amt']);?>
			</div></td>
			<td align=right><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">
			<?php echo sprintf("%8.2f",$contractsItem['ContractsItem']['cost']);?>
			</div></td>
			<td><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">
			<?php echo $contractsItem['ContractsItem']['Notes'];?>
			</div></td>
			<td><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">
			<?php 
						if( $contractsItem['ContractsItem']['active']==1)
						{
							echo '<font color="BLACK" >';
							echo 'Active';	
							echo '</font>';		
						}
						else
						{
							echo '<font color="RED" >';
							echo 'Inactive';	
							echo '</font>';		
						}	
				?>
			</div></td>
			<td class="actions">
				<?php echo $html->link(__('Edit', true), array('action'=>'edit_contract_item', $contractsItem['ContractsItem']['id'])); ?>
				<?php echo $html->link(__('Add Commissions', true), array('action'=>'add_contract_comm_item', $contractsItem['ContractsItem']['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('action'=>'delete_contract_item', $contractsItem['ContractsItem']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $contractsItem['ContractsItem']['id'])); ?>
			</td>
		</tr>
		<tr>
		<td colspan=5>
		<table><tr <?php echo $class;?>>
	<td colspan="2"><?php echo __('Sales Person');?></th>
	<td colspan="2"><?php echo __('Percent');?></th>
	<td colspan="2"><?php echo __('Actions');?></th>
	</tr>
		<?php 
		foreach ($contractsItem['ContractsItemsCommissionsItem'] as $contractsItemsCommissionsItem):
		?>
			<tr<?php echo $class;?>>
				<td colspan="2">
					<?php echo $contractsItemsCommissionsItem['Employee']['firstname'].' '.
					$contractsItemsCommissionsItem['Employee']['lastname']; ?>
				</td>
				<td colspan="2" align=center>
					<?php echo $contractsItemsCommissionsItem['percent']; ?>
				</td>
				<td colspan="2" align=center>
					<?php echo $html->link(__('Delete', true), array('action'=>'delete_contract_comm_item', $contractsItemsCommissionsItem['id'])); ?>
					||
					<?php echo $html->link(__('Edit', true), array('action'=>'edit_contract_comm_item', $contractsItemsCommissionsItem['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table></td></tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</fieldset>
	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Contracts Item', true), array('action'=>'add_contract_item/'.$clientsContract['ClientsContract']['id']));?> </li>
		</ul>
	</div>
</div>
<?php echo $client->contract_actions($clientsContract); ?>