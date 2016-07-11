<div class="commissionsReports index">
<h2><?php __('CommissionsReports'); //debug($commissionsReports);exit;?></h2>

<table cellpadding="1" cellspacing="1" border=1>

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
			<?php echo $commissionsReport['id']; ?>
		</td>
		<td>
			<?php echo date('m/d/Y',strtotime($commissionsReport['start'])); ?>
		</td>
		<td>
			<?php echo date('m/d/Y',strtotime($commissionsReport['end'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $commissionsReport['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $commissionsReport['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $commissionsReport['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $commissionsReport['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
