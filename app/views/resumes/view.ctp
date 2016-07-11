<div class="resumes view">
<h2><?php  __('Resume');?></h2>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Resume', true), array('action'=>'edit', $resume['Resume']['id'])); ?> </li>
	</ul>
	<ul>
		<li><?php echo $html->link(__('Return to Resume List', true), array('action'=>'index')); ?> </li>
	</ul>
</div>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Candidate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $resume['Resume']['name']; ?>
			&nbsp;
			<?php echo $resume['Resume']['email']; ?>
			&nbsp;
			<?php echo $resume['Resume']['phone']; ?>
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Notes'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $resume['Resume']['notes']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Resume'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $resume['Resume']['resume']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="related">
	<h3><?php __('Matched With');?></h3>
	<?php if (!empty($resume['ClientsSearch'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Description'); ?></th>
		<th><?php __('Notes'); ?></th>
		<th><?php __('Title'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($resume['ClientsSearch'] as $clientsSearch):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $clientsSearch['description'];?></td>
			<td><?php echo $clientsSearch['notes'];?></td>
			<td><?php echo $clientsSearch['title'];?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>