<?php echo $javascript->link('jquery.tablednd_0_5'); ?>
<script type="text/javascript">
function order_checks(data) {
    // The JQuery plugin tableDnD provides a serialize() function which provides the re-ordered 
    // data in a list. We pass that list as an object called "data" to a Django view 
    // to save the re-ordered data into the database.

            //alert(data);
    //alert(data);
	$.post("<?php echo $this->webroot;?>invoices_payments/reorder_payments", data, "json");
    return False;
};

function update_rows()
{
    $("tr:even").addClass("altrow");
    $("tr:odd").removeClass("altrow");
}
$(document).ready(function() {
    // Initialise the task table for drag/drop re-ordering
    $("#checktable").tableDnD();
    
    $('#checktable').tableDnD({
        onDrop: function(table, row) {
            update_rows();
            order_checks($.tableDnD.serialize());
        }
    });
    
});
</script>
<div class="clientsChecks view">
<h2><?php  __($page_title);?></h2>  
<table cellpadding = "0" cellspacing = "0">
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsCheck['ClientsCheck']['number']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsCheck['ClientsCheck']['date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Amount'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo sprintf('%8.2f',round($clientsCheck['ClientsCheck']['amount'],2)); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Notes'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsCheck['ClientsCheck']['notes']; ?>
			&nbsp;
		</dd>
	</dl>
</table>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to client', true), array('action' => 'view_checks', $clientsCheck['ClientsCheck']['client_id'])); ?> </li>
		<li>
			<?php echo $html->link(__('Edit Check', true), array('action' => 'edit_check/'.$clientsCheck['ClientsCheck']['id'])); ?> 
		</li>
		<li><?php echo $html->link(__('Delete Check', true), array('action' => 'delete_check', $clientsCheck['ClientsCheck']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $clientsCheck['ClientsCheck']['id'])); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Payments');
	?></h3>
	<?php if (!empty($clientsCheck['InvoicesPayment'])):?>
	<table cellpadding = "1" cellspacing = "1" id="checktable"  border=1>
	<tr>
		<th><?php __('Invoice No.'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Notes'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($clientsCheck['InvoicesPayment'] as $invoicesPayment):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?> id="<?php echo $invoicesPayment['id'];?>">
			<td><a href="<?php echo $this->webroot?>invoices/view/<?php echo $invoicesPayment['invoice_id'];?>"><?php echo $invoicesPayment['invoice_id'];?></a></td>
			<td align="right"><?php echo sprintf('%8.2f',round($invoicesPayment['amount'],2));?></td>
			<td><?php echo $invoicesPayment['Invoice']['notes'];?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
