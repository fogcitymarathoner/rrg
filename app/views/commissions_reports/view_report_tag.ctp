<?php 


$commissions_total = 0 ;
echo $javascript->link('commissions_reports_view'); ?>
<div class="commissionsReportsTags view">
<h2><?php  __('CommissionsReportsTag');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['firstname'].' '.$employee['lastname']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Period'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $period; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Amount'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tag['amount']; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cleared'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tag['cleared']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Released'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tag['release']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to CommissionsReport', true), array('action' => 'view/'.$tag['commissions_report_id'])); ?> </li>
	</ul>
</div>
<?php 

$commissionsItems = $items;
?>
<?php 
//debug($commissionsReport);
//debug($items);exit;
if (!empty($commissionsItems))
{ ?>

<div class="invoicesItemsCommissionsItems index">
<h2><?php __('Commissions');?></h2>

<table cellpadding="1" cellspacing="1">
<tr>
	<th>date</th>
	<th>worker</th>
	<th>percent</th>
	<th>description</th>
	<th>cleared</th>
	<th>voided</th>
	<th>amount</th>
</tr>
<?php
$i = 0;
$commissions_total = 0;
foreach ($commissionsItems as $invoicesItemsCommissionsItem)
{//debug($invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']);exit;
if($invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']['amount']>0)
{
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}//debug($invoicesItemsCommissionsItem);exit;
?>

	<tr<?php echo $class;?>>
		<td colspan=1>
			<?php 
				echo date('m/d/Y',strtotime($invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']['Invoice']['date']));
			?>
		</td>
		<td colspan=1>
			<?php echo $invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']['Worker']['firstname'].' '.$invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']['Worker']['lastname']; ?>
		</td>
		<td>
			<?php 
				echo $invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem'] ['percent'];
			?>
		</td>
		<td>
			<?php
				echo substr($invoicesItemsCommissionsItem['InvoicesItem']['description'],0,20);
			?>
		</td>
		<td>
			<?php echo $invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']['cleared']; ?>
		</td>
		<td><?php //debug($invoicesItemsCommissionsItem);exit;?>
			<?php echo '<form name=xx autocomplete="off" class="user_data_form">';?>
<?php

if ($invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']['voided'] == 0)
{ 
echo '<input type="radio" name="commissions_void_'.$invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']['id'].'" onClick="commissions_void(\'Up\','.$invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']['id'].',\''.$this->webroot.'\')" value="Voided"> Voided
<br><input type="radio" name="commissions_void_'.$invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']['id'].'" onClick="commissions_void(\'Down\','.$invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']['id'].',\''.$this->webroot.'\')" 
value="Unvoided" checked> Unvoided';
} else {
echo '<input type="radio" name="commissions_void_'.$invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']['id'].'" onClick="commissions_void(\'Up\','.$invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']['id'].',\''.$this->webroot.'\')" 
value="Willing" checked> Voided
<br><input type="radio" name="commissions_void_'.$invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']['id'].'" onClick="commissions_void(\'Down\','.$invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']['id'].',\''.$this->webroot.'\')" 
value="Unvoided"> Unvoided';
}
echo '</form>';
?>
		</td>
		<td align="right">
			<?php echo sprintf('%8.2f',round($invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']['amount'])); 
			$commissions_total += $invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']['amount'];
			?>
		</td>
	</tr>
	<?php //debug($invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']);
	if (isset($invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']['Worker']))
	{
	?>
	<tr<?php echo $class; ?>>
		<td colspan=1>
		</td>
		<td colspan=1>
			<?php echo '#'.$invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']['Invoice']['id'].'$'.$invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']['Invoice']['amount']; ?>
		</td>
		<td colspan=1>
			<?php  ?>
		</td>
		<td colspan=1>
			<?php echo date('m/d/Y',strtotime($invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']['Invoice']['period_start'])).'-';
			echo date('m/d/Y',strtotime($invoicesItemsCommissionsItem['InvoicesItemsCommissionsItem']['Invoice']['period_end']));
			 ?>
		</td>
		<td colspan=1>
			<?php 
			 ?>
		</td>
		<td>
		</td>
	</tr>



<?php } ?>
<?php } ?>
<?php } ?>
<?php } ?>
	<tr<?php echo $class; ?>>
		<td colspan=1>
		</td>
		<td colspan=1>		</td>
		<td colspan=1>
		</td>
		<td colspan=1>		</td>
		<td colspan=1>
		</td>
		<td>
		</td>
		<td align="right">
			<?php echo sprintf('%8.2f',round($commissions_total)); ?>
		</td>
	</tr>
	</table>
	
<?php 
/// payments
$commissionsItems = $payments;
?>
<?php 
//debug($commissionsReport);
//debug($items);exit;
if (!empty($commissionsItems))
{ ?>

<div class="invoicesItemsCommissionsItems index">
<h2><?php __('Commissions Payments');?></h2>

<table cellpadding="1" cellspacing="1">
<tr>
	<th>number</th>
	<th>date</th>
	<th>description</th>
	<th>amount</th>
</tr>
<?php
$i = 0;
$payments_total = 0;
foreach ($commissionsItems as $invoicesItemsCommissionsItem)
{//debug($invoicesItemsCommissionsItem['CommissionsPayment']);exit;
if($invoicesItemsCommissionsItem['CommissionsPayment']['amount']>0)
{
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}//debug($invoicesItemsCommissionsItem);//exit;
?>

	<tr<?php echo $class;?>>
		<td>
			<?php 
				echo $invoicesItemsCommissionsItem['CommissionsPayment']['check_number'];
			?>
		</td>
		<td>
			<?php 
				echo date('m/d/Y',strtotime($invoicesItemsCommissionsItem['CommissionsPayment']['date']));
			?>
		</td>
		<td>
			<?php 
				echo $invoicesItemsCommissionsItem['CommissionsPayment']['description'];
			?>
		</td>
		<td align=right>
			<?php 
				echo sprintf('%8.2f',round($invoicesItemsCommissionsItem['CommissionsPayment']['amount']));
				$payments_total += $invoicesItemsCommissionsItem['CommissionsPayment']['amount'];
			?>
		</td>

	</tr>
<?php } ?>
<?php } ?>

	<tr<?php echo $class; ?>>
		<td colspan=1>
		</td>
		<td colspan=1>		</td>
		<td colspan=1>
		</td>
		<td align="right">
			<?php echo sprintf('%8.2f',round($payments_total)); ?>
		</td>
	</tr>
	</table>
<?php } ?>
