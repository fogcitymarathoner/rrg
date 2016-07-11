<?php //debug($employee['Note']);exit; ?>
<div class="employees view">

    <?php echo $this->element('employee/menu', array('employee'=>$employee['Employee'],'webroot'=>$this->webroot,));?>
    <br>
<h2><?php 
__($page_title);?></h2>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Employees', true), array('action'=>'index'));?></li>
	</ul>
</div>

	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['firstname']; ?>
			<?php echo $employee['Employee']['mi']; ?>

			<?php echo $employee['Employee']['lastname']; ?>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Employees', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Note/Commissions Payment', true), array('action'=>'add_note/'.$employee['Employee']['id']));?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Employees Notes');?></h3>
	<?php if (!empty($notes)):?>
	<table cellpadding = "3" cellspacing = "3" border=1 >
	<tr>
		<th><?php __('Date'); ?></th>
		<th><?php __('Amount'); ?></th>
		<th><?php __('Notes'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($notes as $note): //debug($note['Note']['amount']);
			//if(isset($note['notes_reports_tag_id']))
			if(1==1)
			{ //debug($note);
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				} //debug($note);
			?>
			<tr<?php echo $class;?>>
				<td><?php echo date('m/d/Y',strtotime($note['Note']['date']));?></td>
				
				<td align=right ><?php echo number_format  ($note['Note']['amount'],2);?></td>
				<td><?php echo $note['Note']['notes'];?></td>
				<td class="actions">
					<?php echo $html->link(__('Edit', true), array('action'=>'edit_note', $note['Note']['id'])); ?>
					<?php echo $html->link(__('Delete', true), array('action'=>'delete_note', $note['Note']['id'],$employee['Employee']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $note['Note']['id'])); ?>
				</td>
			</tr>
	<?php } ?>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Note/Commissions Payment', true), array('action'=>'add_note/'.$employee['Employee']['id']));?> </li>
		</ul>
	</div>