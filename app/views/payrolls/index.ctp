<div class="payrolls index">
    <?php echo $this->element('payrolls_menu',array()); ?>
    <br>
        <h2><?php __($page_title);?></h2>
    </br>
<p>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Run New Payroll', true), array('action' => 'select_check_directdeposit')); ?></li>
	</ul>
</div>

<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding = "3" cellspacing = "3" border=1 >
<tr>
	<th><?php echo $paginator->sort('date');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('amount');?></th>
	<th><?php echo $paginator->sort('notes');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($payrolls as $payroll):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo date('m/d/Y',strtotime($payroll['Payroll']['date'])); ?>
		</td>
		<td>
			<?php echo $payroll['Payroll']['name']; ?>
		</td>
		<td align="right">
			<?php echo sprintf('%8.2f',round($payroll['Payroll']['amount'],2)); ?>
		</td>
		<td>
			<?php echo $payroll['Payroll']['notes']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $payroll['Payroll']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $payroll['Payroll']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $payroll['Payroll']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $payroll['Payroll']['id'])); ?>

            <?php echo $html->link(__('Input RefNum', true), array('action' => 'refapp', $payroll['Payroll']['id'])); ?>
            <?php echo $html->link(__('Document Manager', true), array('action' => 'paystub_document_manager', $payroll['Payroll']['id'])); ?>
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