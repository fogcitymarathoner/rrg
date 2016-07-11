<div class="clientsContracts view">

    <?php echo $this->element('contract_menu',array('contract'=>$clientsContract['ClientsContract'],'webroot'=>$this->webroot,'controller'=>'employees')); ?>
<br>
<h2><?php  __("Contract"); ?></h2>
<?php echo $this->element('view_employees_contract', array(
							'ClientsContract'=>$this->data,
							)); 
?>
		</dd><div class="related">
	<h3><?php __('Billable Items');?></h3>
	<?php if (!empty($items)):?>
	<table cellpadding = "1" cellspacing = "1" " border ="1">
	<tr>
		<th><?php __('Description'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Cost'); ?></th>
		<th><?php __('Notes'); ?></th>
		<th><?php __('act/inact'); ?></th>
		<th><?php __('Actions'); ?></th>
	</tr>
	<?php 
		$i = 0;
		foreach ($items as $contractsItem):
			$class = null; //debug($contractsItem);exit;
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
			<?php echo $contractsItem['ContractsItem']['notes'];?>
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
			
			<td><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">
			<a href="'.$this->webroot.'/employees/upInvoiceItem/<?php echo $contractsItem['ContractsItem']['id'];?>">UP</a> |
			<a href="'.$this->webroot.'/employees/downInvoiceItem/<?php echo $contractsItem['ContractsItem']['id'];?>">DOWN</a>
			</div></td>
		</tr>
		<tr>
		<td colspan=5>
		<table><tr <?php echo $class;?>>
	<td colspan="2"><?php echo __('Sales Person');?></th>
	<td colspan="2"><?php echo __('Percent');?></th>
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
			</tr>
		<?php endforeach; ?>
		</table></td></tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
<div class="related">
	<h3><?php __('Related Invoices');?></h3>
	<?php if (!empty($invoices)):?>
	<table cellpadding = "1" cellspacing = "1" border ="1">
	<tr>
		<th><?php __('Num.'); ?></th>
		<th><?php __('Date'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Payroll'); ?></th>
		<th><?php __('Begin'); ?></th>
		<th><?php __('End'); ?></th>
	</tr>
	<?php
		$i = 0;
		$totalrevenue = 0;
		$totalpayroll = 0;
		foreach ($invoices as $invoice): 
			if ($invoice['Invoice']['amount'] > 0)
			{
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
				
		$totalrevenue += $invoice['Invoice']['amount'];
		$totalpayroll += $invoice['Invoice']['directLaborCost'];
		?>
		<tr<?php echo $class;?>>
			<td><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">
				<?php echo $invoice['Invoice']['id'];?>
			</div></td>
			<td><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">
				<?php echo date('m/d/Y',strtotime($invoice['Invoice']['date']));?>
			</div></td>
			<td align=right ><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">
				<?php echo sprintf("%8.2f",    $invoice['Invoice']['amount']);?>
			</div></td>
			<td align=right ><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">
				<?php echo sprintf("%8.2f",    $invoice['Invoice']['directLaborCost']);?>
			</div></td>
			<td><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">
				<?php echo date('m/d/Y',strtotime($invoice['Invoice']['period_start']));?>
			</div></td>
			<td><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex;">
				<?php echo date('m/d/Y',strtotime($invoice['Invoice']['period_end']));?>
			</div></td>
		</tr>
	<?php 
			}
		endforeach; 
		?>
		<tr><td></td><td></td><td><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">
				<?php echo sprintf("%8.2f",    $totalrevenue);?>
		</div></td><td><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">
				<?php echo sprintf("%8.2f",    $totalpayroll); ?>
		</div></td>
		<td><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">.				
		</div></td></tr>
		
	</table>
<?php endif; ?>
</div>
		
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
	    $i = 0;
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
</div>

<?php echo $this->element('employees/contractactions',array('employee'=>$employee,'webroot'=>$this->webroot));?>
        </div>