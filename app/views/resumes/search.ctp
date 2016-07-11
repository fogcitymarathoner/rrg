<div class="resumes form">
<?php echo $form->create('Resume', array('action'=>'/search'));?>
	<fieldset>
 		<legend><?php __('Search - Resumes');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->input('email');
		echo $form->input('phone'); ?>
<div class="input text">
<label for="ResumeResume">Resume</label>
<input name="data[Resume][resume]" type="text" maxlength="50" value="" id="ResumeResume" />
</div>

	<?php	#echo $form->input('resume',array('rows'=>1));
		#echo $form->input('resume');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="resumes index">
<h2><?php __('Resumes - Search Results');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('phone');?></th>
	<th><?php echo $paginator->sort('notes');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($resumes as $resume):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $resume['Resume']['name']; ?>
		</td>
		<td>
			<?php echo $resume['Resume']['phone']; ?>
		</td>
		<td>
			<?php echo $resume['Resume']['notes']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $resume['Resume']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $resume['Resume']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $resume['Resume']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $resume['Resume']['id'])); ?>
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
		<li><?php echo $html->link(__('New Resume', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List States', true), array('controller'=> 'states', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New State', true), array('controller'=> 'states', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Clients Searches', true), array('controller'=> 'clients_searches', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Clients Search', true), array('controller'=> 'clients_searches', 'action'=>'add')); ?> </li>
	</ul>
</div>
