<div class="clientsContracts view">
<h2><?php  __("Contract"); ?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsContract['ClientsContract']['title']; ?>
			&nbsp;
		</dd>
	</dl>
<div class="related">
	<h3><?php __('Related Invoices');?></h3>
	<?php if (!empty($invoices)):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Num.'); ?></th>
		<th><?php __('Date'); ?></th>
		<th><?php __('Hours'); ?></th>
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
			<td><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">
				<?php echo sprintf("%2.2f",    $invoice['Invoice']['hours']);?>
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
		<tr><td></td><td></td>
		<td>
		<div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">
				<?php echo sprintf("%8.2f",    $hours);?>
		</div>
		</td>
		<td>
		<div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">
				<?php echo sprintf("%8.2f",    $totalrevenue);?>
		</div>
		</td>
		<td><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">
				<?php echo sprintf("%8.2f",    $totalpayroll); ?>
		</div></td>
		<td><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">.				
		</div></td></tr>
		
	</table>
<?php endif; ?>
</div>
</div>
<?php echo $client->contract_actions($clientsContract); ?>
