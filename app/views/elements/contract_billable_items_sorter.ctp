<?php echo $javascript->link('jquery.tablednd_0_5'); ?>
<script type="text/javascript">
function order_checks(data) {
    // The JQuery plugin tableDnD provides a serialize() function which provides the re-ordered 
    // data in a list. We pass that list as an object called "data" to a Django view 
    // to save the re-ordered data into the database.

            //alert(data);
    //alert(data);
	$.post("<?php echo $this->webroot;?>contracts_items/reorder_items", data, "json");
    return False;
};

$(document).ready(function() {
    // Initialise the task table for drag/drop re-ordering
    $("#itemtable").tableDnD();
    
    $('#itemtable').tableDnD({
        onDrop: function(table, row) {
            order_checks($.tableDnD.serialize());
        }
    });
    
});
</script>
	<h3><?php __('Billable Items Sorter');?></h3>
	<?php if (!empty($items)):?>
	<table cellpadding = "1" cellspacing = "1" border='1'  id="itemtable" >
	<tr>
		<th><?php __('Description'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Cost'); ?></th>
		<th><?php __('Notes'); ?></th>
	</tr>
	<?php 
		$i = 0;
		foreach ($items as $contractsItem):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?> id='<?php echo $contractsItem['ContractsItem']['id'];?>'>
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
		</tr>
	<?php endforeach; ?>
	</table>
	
<?php endif; ?>

