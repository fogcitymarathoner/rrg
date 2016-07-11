<div class="commissionsReports index">
<h2><?php __('NotesReports'); //debug($commissionsReports);exit;?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="1" cellspacing="1" border=1>
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('start');?></th>
	<th><?php echo $paginator->sort('end');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($commissionsReports as $commissionsReport):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $commissionsReport['CommissionsReport']['id']; ?>
		</td>
		<td>
			<?php echo date('m/d/Y',strtotime($commissionsReport['CommissionsReport']['start'])); ?>
		</td>
		<td>
			<?php echo date('m/d/Y',strtotime($commissionsReport['CommissionsReport']['end'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $commissionsReport['CommissionsReport']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $commissionsReport['CommissionsReport']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $commissionsReport['CommissionsReport']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $commissionsReport['CommissionsReport']['id'])); ?>
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
