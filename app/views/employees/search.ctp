<div class="employees form">

    <?php echo $this->element('employees/menu',array()); ?>
    <br>
<h2><?php __('Search Employees');?></h2>
<?php echo $form->create('Employee', array('action'=>'/search'));?>
	<fieldset>
	<?php
		echo $form->input('firstname');
		echo $form->input('lastname');
		echo $form->input('nickname');
		echo $form->input('state_id', array('empty'=>'-- select a state --'));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>

<div class="employees index">
<p>
<?php
//echo $paginator->counter(array(
//'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
//));
?></p>
<table cellpadding = "3" cellspacing = "3" border=1 >
<tr>
	<th><?php echo 'firstname';?></th>
	<th><?php echo 'lastname';?></th>
	<th><?php echo 'phone';?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
if(!empty($employees))
{
$i = 0;
foreach ($employees as $employee):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $employee['Employee']['firstname']; ?>
		</td>
		<td>
			<?php echo $employee['Employee']['lastname']; ?>
		</td>
		<td>
			<?php echo $employee['Employee']['phone']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $employee['Employee']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $employee['Employee']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $employee['Employee']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $employee['Employee']['id'])); ?>
		</td>
	</tr>
	<tr<?php echo $class;?>>
		<td colspan=3>
			<?php //debug($employee['State']);
				echo $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'].'<br>'; 
				echo $employee['Employee']['street1'].'<br>'; 
				if($employee['Employee']['street2'])
					echo $employee['Employee']['street2'].'<br>'; 
				echo $employee['Employee']['city'].', '; 
				echo $employee['State']['post_ab'].' '; 
				echo $employee['Employee']['zip']; 
			?>
		</td>
		<td class="actions"></td>
	</tr>
		<?php
		foreach ($employee['EmployeesEmail'] as $employeesEmail):
		?>
		<tr<?php echo $class;?>>
			<td><a href="mailto:<?php echo $employeesEmail['email'];?>"><?php echo $employeesEmail['email'];?></a></td>
		</tr>
	<?php endforeach; ?>
	
<?php endforeach; ?>
</table>
<?php
}
?>
</div>
<div class="paging">
	<?php //echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php //echo $paginator->numbers();?>
	<?php //echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
