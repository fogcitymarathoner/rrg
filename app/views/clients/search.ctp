<div class="clients form">
<?php echo $form->create('Client', array('action'=>'/search'));?>
	<fieldset>
 		<legend><?php __('Search');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->input('city');
		echo $form->input('state_id', array('empty'=>'-- Active Inactive --'));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>

<div class="clients index">
<h2><?php __('Clients');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('city');?></th>
	<th><?php echo $paginator->sort('state_id');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($clients as $client):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $client['Client']['name']; ?>
		</td>
		<td>
			<?php echo $client['Client']['city']; ?>
		</td>
		<td>
			<?php echo $html->link($client['State']['name'], array('controller'=> 'states', 'action'=>'view', $client['State']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $client['Client']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $client['Client']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $client['Client']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $client['Client']['id'])); ?>
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
