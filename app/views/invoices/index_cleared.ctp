
<?php echo $this->element('invoices/menu', array()); ?>
			<div class="invoices index">
<h2>
<?php 
__($page_title);
$total = 0;
?></h2>
<table cellpadding="1" cellspacing="1" border=1>
<tr>
	<th>id</th>
	<th>date</th>
	<th>begin</th>
	<th>end</th>
	<th>amount</th>
	<th>notes</th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($invoices as $invoice):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $invoice['Invoice']['id'];  ?>
		</td>
		<td>
			<?php echo date('m/d/Y',strtotime($invoice['Invoice']['date'])).'|'; ?>
		</td>
		<td>
			<?php echo date('m/d/Y',strtotime($invoice['Invoice']['period_start'])).'-'; ?>
		</td>
		<td>
			<?php echo date('m/d/Y',strtotime($invoice['Invoice']['period_end'])); ?>
		</td>
		<td align="right">
			<?php echo sprintf('%8.2f',round($invoice['Invoice']['amount'],2)); 
			$total += $invoice['Invoice']['amount'];
			?>
		</td>
		<td>
			<?php echo $invoice['Invoice']['notes']; ?>
		</td>
		<td>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit',$invoice['Invoice']['id']));?>
			<?php echo $html->link(__('View', true), array('action'=>'view',$invoice['Invoice']['id']));?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php 
echo 'total: '.sprintf('%8.2f',round($total,2));
?>
</div>