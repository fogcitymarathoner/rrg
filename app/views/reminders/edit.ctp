<div class="invoices index"> <?php //debug($this->data);//debug($invoicesItems);exit; ?>

<h2><?php 
__('Edit Invoice - '.$this->data['ClientsContract']['title']);?></h2>
<p>
<?php echo $html->link(__('Regenerate Invoice', true), array('action'=>'rebuild_invoice_items', $this->data['Invoice']['id']), null, null); ?>

<?php echo $html->link(__('Preview', true), array('action'=>'previewpdf', $this->data['Invoice']['id'])); ?>
<table cellpadding="0" cellspacing="0">
<tr>
	<th>Description</th>
	<th>Amount</th>
	<th>Cost</th>
	<th>Quantity</th>
	<th>Subtotal</th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
$total = 0;
foreach ($invoicesItems as $item):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $item['InvoicesItem']['description'].'|'; ?>
		</td>
		<td align=right>
			<?php echo $item['InvoicesItem']['amount'].'|'; ?>
		</td>
		<td align=right>
			<?php echo $item['InvoicesItem']['cost'].'|'; ?>
		</td>
		<td align=center>
			<?php echo $item['InvoicesItem']['quantity'].'|'; ?>
		</td>
		<td align=right>
			<?php echo sprintf('%8.2f',round($item['InvoicesItem']['amount']*$item['InvoicesItem']['quantity'],2)); 
			   $total += $item['InvoicesItem']['amount']*$item['InvoicesItem']['quantity'];
			?>
		</td>
		<td>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit_item', $item['InvoicesItem']['id'])); 
			echo $html->link(__('Delete', true), array('action'=>'delete_item', $item['InvoicesItem']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $item['InvoicesItem']['id']));
			?>
		</td>
	</tr>
	<tr<?php echo $class;?>>
		<td>
			
		</td>
		<td align=right>
			
		</td>
		<td align=right>
			
		</td>
		<td align=center>
			
		</td>
		<td align=right>
			<?php echo sprintf('%8.2f',round($total,2)); ?>
		</td>
		<td>
		</td>
	
	</tr>
	
<?php endforeach; ?>
</table>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Reminders', true), array('action'=>'index/')); ?> </li>
	</ul>
</div>
