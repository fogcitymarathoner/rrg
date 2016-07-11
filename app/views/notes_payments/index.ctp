<div class="notesPayments index">
<h2><?php __('NotesPayments');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('employee_id');?></th>
	<th><?php echo $paginator->sort('check_number');?></th>
	<th><?php echo $paginator->sort('amount');?></th>
	<th><?php echo $paginator->sort('notes');?></th>
	<th><?php echo $paginator->sort('created_date');?></th>
	<th><?php echo $paginator->sort('modified_date');?></th>
	<th><?php echo $paginator->sort('created_user_id');?></th>
	<th><?php echo $paginator->sort('modified_user_id');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($notesPayments as $notesPayment):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $notesPayment['NotesPayment']['id']; ?>
		</td>
		<td>
			<?php echo $notesPayment['NotesPayment']['employee_id']; ?>
		</td>
		<td>
			<?php echo $notesPayment['NotesPayment']['check_number']; ?>
		</td>
		<td>
			<?php echo $notesPayment['NotesPayment']['amount']; ?>
		</td>
		<td>
			<?php echo $notesPayment['NotesPayment']['notes']; ?>
		</td>
		<td>
			<?php echo $notesPayment['NotesPayment']['created_date']; ?>
		</td>
		<td>
			<?php echo $notesPayment['NotesPayment']['modified_date']; ?>
		</td>
		<td>
			<?php echo $notesPayment['NotesPayment']['created_user_id']; ?>
		</td>
		<td>
			<?php echo $notesPayment['NotesPayment']['modified_user_id']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $notesPayment['NotesPayment']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $notesPayment['NotesPayment']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $notesPayment['NotesPayment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $notesPayment['NotesPayment']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New NotesPayment', true), array('action' => 'add')); ?></li>
	</ul>
</div>
