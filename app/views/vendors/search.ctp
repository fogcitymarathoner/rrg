<div class="vendors form">
<?//=debug($this, $showHTML = false, $showFrom = true)?>
<?php echo $form->create('Vendor', array('action'=>'/search'));?>
	<fieldset>
 		<legend><?php __('Search - Vendors');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('purpose');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="vendors index">
<h2><?php __('Vendors - Search Results');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0" border=1>
<tr>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('purpose');?></th>
</tr>
<?php
$i = 0;
foreach ($vendors as $vendor):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link(__($vendor['Vendor']['name'], true), array('action'=>'view', $vendor['Vendor']['id'])); ?>
		</td>
		<td>
			<?php echo $vendor['Vendor']['purpose']; ?>
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
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Vendor', true), array('action'=>'add')); ?></li>
	</ul>
</div>


