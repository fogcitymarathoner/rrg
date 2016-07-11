<div class="expenses form">
<?php echo $form->create('Expense', array('action' => 'select_year'));?>
	<fieldset>
 		<legend><?php __('Select Category and Year of expense report');?></legend>
	<?php
            echo $form->input('year',
                array( 'type' => 'select',
                    'empty' => '-- Select a year --',
                    'multiple' => false,
                    'options' => $years,
                    'label' => 'Year'));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to expense list', true), array('action'=>'index'));?></li>
	</ul>
</div>
