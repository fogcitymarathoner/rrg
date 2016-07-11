<script xmlns="http://www.w3.org/1999/html">
    employees = jQuery.parseJSON('<?php echo $employees; ?>');
    clients = jQuery.parseJSON('<?php echo $clients; ?>');
    invoices = jQuery.parseJSON('<?php echo $invoicesJS; ?>');
</script>
        <?php echo $javascript->link('invoices');?>
        <?php echo $this->element('invoices/menu', array()); ?>
<div class="invoices form" style="display: block; float: left">

<?php echo $form->create('Invoice', array('action'=>'/search_bynum'));?>
	<fieldset>
 		<legend><?php __($page_title);?></legend>
	<?php
		echo $form->input('inv_num',array('size'=>5));
	?>
	</fieldset>
<?php echo $form->end('Submit'); ?>

<div class="invoices index">

	<h2>
<?php 
if(!empty($invoices))
{
__('Results');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>

<table cellpadding="1" cellspacing="1" border=1>

<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th>Client</th>
	<th><?php echo $paginator->sort('contract_id');?></th>
	<th><?php echo $paginator->sort('date');?></th>
	<th><?php echo $paginator->sort('begin');?></th>
	<th><?php echo $paginator->sort('end');?></th>
	<th><?php echo $paginator->sort('amount');?></th>
	<th><?php echo $paginator->sort('notes');?></th>
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
			<?php echo $invoice['Invoice']['id'];?>
		</td>
        <td>
            <div id="invoice-client-<?php echo $invoice['Invoice']['id']?>"></div>
        </td>
		<td>
			<?php echo $html->link($invoice['ClientsContract']['title'], array('controller'=> 'invoices', 'action'=>'view', $invoice['Invoice']['id'])); ?>
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
			<?php echo sprintf('%8.2f',round($invoice['Invoice']['amount'],2)); ?>
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
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>

<?php 
}
?>
