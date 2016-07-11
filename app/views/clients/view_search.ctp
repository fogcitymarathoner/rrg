<div class="clientsSearches view">
<h2><?php  __('ClientsSearch');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsSearch['ClientsSearch']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Client'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($clientsSearch['Client']['name'], array('controller'=> 'clients', 'action'=>'view', $clientsSearch['Client']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsSearch['ClientsSearch']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Notes'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsSearch['ClientsSearch']['notes']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $clientsSearch['ClientsSearch']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('State'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($clientsSearch['State']['name'], array('controller'=> 'states', 'action'=>'view', $clientsSearch['State']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit ClientsSearch', true), array('action'=>'edit', $clientsSearch['ClientsSearch']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete ClientsSearch', true), array('action'=>'delete', $clientsSearch['ClientsSearch']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $clientsSearch['ClientsSearch']['id'])); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Resumes');?></h3>
	<?php if (!empty($clientsSearch['Resume'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Name'); ?></th>
		<th><?php __('Email'); ?></th>
		<th><?php __('Phone'); ?></th>
		<th><?php __('Resume'); ?></th>
		<th><?php __('Notes'); ?></th>
		<th><?php __('State Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($clientsSearch['Resume'] as $resume):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $resume['name'];?></td>
			<td><?php echo $resume['email'];?></td>
			<td><?php echo $resume['phone'];?></td>
			<td><?php echo $resume['resume'];?></td>
			<td><?php echo $resume['notes'];?></td>
			<td><?php echo $resume['state_id'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'resumes', 'action'=>'view', $resume['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'resumes', 'action'=>'edit', $resume['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'resumes', 'action'=>'delete', $resume['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $resume['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Resume', true), array('controller'=> 'resumes', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
