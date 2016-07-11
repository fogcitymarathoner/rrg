<?php echo $javascript->link('clients_view_contract');?>
	<h3><?php __('Billable Items');?></h3>
	<?php if (!empty($items)):?>


<?php echo $this->element('waiting_area',array('webroot'=>$this->webroot));?>

<div id="comms-waiting-area">
</div>
<table cellpadding = "3" cellspacing = "3" border=1>
	<tr>
		<th><?php __('Description'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Cost'); ?></th>
		<th><?php __('Notes'); ?></th>
		<th><?php __('Active/Inactive'); ?></th>
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
			<?php echo $contractsItem['ContractsItem']['notes'];?>
			</div></td>
			<td><div style="border: solid 0 #060; border-left-width:2px; padding-left:0.5ex">
			<?php 
	
				echo '<form name=xx autocomplete="off" class="user_data_form">';
if ($contractsItem['ContractsItem']['active'] == 0)
{ 
echo  '<input type="radio" name="contract_item_activeinactive_'.$contractsItem['ContractsItem']['id'].'" onClick="contract_item_activeinactive(\'Up\','.$contractsItem['ContractsItem']['id'].',\''.$this->webroot.'\')" value="Active"> Active
<br><input type="radio" name="contract_item_activeinactive_'.$contractsItem['ContractsItem']['id'].'" onClick="contract_item_activeinactive(\'Down\','.$contractsItem['ContractsItem']['id'].',\''.$this->webroot.'\')" 
value="Inactive" checked> Inactive';
} else {
echo  '<input type="radio" name="contract_item_activeinactive_'.$contractsItem['ContractsItem']['id'].'" onClick="contract_item_activeinactive(\'Up\','.$contractsItem['ContractsItem']['id'].',\''.$this->webroot.'\')" 
value="Willing" checked> Active
<br><input type="radio" name="contract_item_activeinactive_'.$contractsItem['ContractsItem']['id'].'" onClick="contract_item_activeinactive(\'Down\','.$contractsItem['ContractsItem']['id'].',\''.$this->webroot.'\')"
value="Inactive"> Inactive';
}
echo  '</form>';
?>
			</div></td>
			<td class="actions">
				<?php echo $html->link(__('Edit', true), array('action'=>'edit_contract_item', $contractsItem['ContractsItem']['id'], $contractsItem['ContractsItem']['contract_id'],$next)); ?>
				<?php echo $html->link(__('Add Commission Item', true), array('action'=>'add_contract_comm_item', $contractsItem['ContractsItem']['id'],$next)); ?>
				<?php echo $html->link(__('Delete', true), array('action'=>'delete_contract_item', $contractsItem['ContractsItem']['id'],$clientsContract['ClientsContract']['id'],$next), null, sprintf(__('Are you sure you want to delete # %s?', true), $contractsItem['ContractsItem']['id'])); ?>
				<br>
                <?php echo $html->link(__('UP', true), array('action'=>'upItem', $contractsItem['ContractsItem']['id'], $clientsContract['ClientsContract']['id'],$next)); ?>
                <?php echo $html->link(__('DOWN', true), array('action'=>'downItem', $contractsItem['ContractsItem']['id'], $clientsContract['ClientsContract']['id'],$next)); ?>

			</td>
		</tr>
		<tr>
		<td colspan=5>
		<table><tr <?php echo $class;?>>
	<td colspan="2"><?php echo __('Sales Person');?></th>
	<td colspan="2"><?php echo __('Percent');?></th>
	</tr>
		<?php echo '<form class="percentfrm" autocomplete="off" action="'.$this->webroot.'clients/change_rates" />'; ?>
		<?php
		$i=0;
		foreach ($contractsItem['ContractsItemsCommissionsItem'] as $contractsItemsCommissionsItem):
		?>
			<tr<?php echo $class;?>>
				<td colspan="2">
					<?php echo $contractsItemsCommissionsItem['Employee']['firstname'].' '.
					$contractsItemsCommissionsItem['Employee']['lastname']; ?>
				</td>
				<td colspan="2" align=center>
					<?php //echo $contractsItemsCommissionsItem['percent']; ?>
					<?php //echo $contractsItemsCommissionsItem['id']; ?>

                      Percent: <input type='texts'  name="data[<?php echo $i?>][percent]" value="<?php echo $contractsItemsCommissionsItem['percent']; ?>" />
                      <input name="data[<?php echo $i?>][id]" type='hidden'  value=<?php echo $contractsItemsCommissionsItem['id']?> />


				</td>
				<td colspan="2" align=center>
			<?php echo $html->link(__('Edit', true), 
				array('action'=>'edit_contract_comm_item', $contractsItemsCommissionsItem['id'],
                    $clientsContract['ClientsContract']['id'],
                    $next)); ?>
			<?php echo $html->link(__('Delete', true), 
				array('action'=>'delete_contract_comm_item', $contractsItemsCommissionsItem['id'],
                    $clientsContract['ClientsContract']['id'],$next),
				   null, sprintf(__('Are you sure you want to delete # %s?', true), $contractsItem['ContractsItem']['id'])); ?>

				</td>
			</tr>
		<?php
		$i++;
		 endforeach; ?>
		<tr><td></td><td><input type="submit" value="Submit" class="percentfrm" /></td></tr>
			<?php echo  '</form>'; ?>
		</table></td></tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

<style type="text/css">
div#changeratesurl {
    display: none;
}
</style>
	 <div id='changeratesurl' ><?php echo     $this->webroot;?>clients/change_rates</div>
<script type="text/javascript">
    $(document).ready(function() {
        //Load all elements
        $(".percentfrm").click(function(e){
       // alert(this.form);
        e.preventDefault();

        $url = $('#changeratesurl').html();
        //alert($url);
        $data =$(this.form).serialize();


       $('#comms_waiting_area').addClass( 'waiting div400x100' );
       $.post($url, $data,
           function(data) {
               $('#comms_waiting_area').removeClass( 'waiting div400x100' );
           },
       'json'
       );
    });


    $('div#modal-overlay').hide(  );
    $('div#reminders-waiting-area').hide(  );
    $('#comms-waiting-area').removeClass( 'waiting div400x100' );
});
</script>