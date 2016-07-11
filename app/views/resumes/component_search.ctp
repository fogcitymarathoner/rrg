<div class="songs index">

<?php echo $html->link(__('Non-Component search', true), array('action'=>'index')); ?>
<?php 
//echo debug($this->data);
echo $form->create('Resume', array('action'=>'/component_search'));?>
	<fieldset>
 		<legend><?php __('Search songs - Component');?></legend>
	<?php
		echo $form->input('name',array('label'=>'Name'));
		echo $form->input('resume',array('label'=>'Resume'));
		echo $form->input('email',array('label'=>'eMail'));
		echo $form->input('phone',array('label'=>'Phone'));
		echo $form->input('notes',array('label'=>'Notes'));
	?>
	</fieldset>
<?php echo $form->end('Search');?>
</div>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo 'Name';?></th>
	<th><?php echo 'Phone';?></th>
	<th><?php echo 'Notes';?></th>
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
			<?php echo $html->link(__($resume['Resume']['name'], true), array('action'=>'view', $resume['Resume']['id'])); ?>
		</td>
		<td>
			<?php echo $resume['Resume']['phone']; ?>
		</td>
		<td>
			<?php echo $resume['Resume']['notes']; ?>
		</td>
		<td class="actions">
<?php
echo '<form name=xx autocomplete="off" class="user_data_form">';
if ($resume['Resume']['active'] == 0)
{ 
echo '<input type="radio" name="resume_activeinactive_'.$resume['Resume']['id'].'" onClick="resume_activeinactive(\'Up\','.$resume['Resume']['id'].',\''.$this->webroot.'\')" value="Active"> Active
<input type="radio" name="contract_activeinactive_'.$resume['Resume']['id'].'" onClick="resume_activeinactive(\'Down\','.$resume['Resume']['id'].',\''.$this->webroot.'\')" 
value="Inactive" checked> Inactive';
} else {
echo '<input type="radio" name="resume_activeinactive_'.$resume['Resume']['id'].'" onClick="resume_activeinactive(\'Up\','.$resume['Resume']['id'].',\''.$this->webroot.'\')" 
value="Willing" checked> Active
<input type="radio" name="resume_activeinactive_'.$resume['Resume']['id'].'" onClick="resume_activeinactive(\'Down\','.$resume['Resume']['id'].',\''.$this->webroot.'\')"
value="Inactive"> Inactive';
}
echo  '</form>';
?>			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $resume['Resume']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $resume['Resume']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Resume', true), array('action'=>'add')); ?></li>
	</ul>
</div>
