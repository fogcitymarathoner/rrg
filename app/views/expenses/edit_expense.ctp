<div class="expenses form">
<?php echo $form->create('Expense',array('action'=>'edit_expense'));?>
	<fieldset>
 		<legend><?php __('Edit Expense');?></legend>

<?php
		$date = date('m/d/Y',strtotime($this->data['Expense']['date']));
		?>
	<?php
		echo $form->input('id',array( 'type'=>'hidden'));
		echo $form->input('amount');
		echo $form->input('category_id', array('label'=>'Category', 'options'=>$expensesCategories), null, array(), '-- Select an Expense Category --');
?>

 		<p>
        <label for="date">Date</label> :
        <input type="text" class="w16em" id="date" name="data[Expense][date]" value="<?php echo $date; ?>" />
        </p>

              <script type="text/javascript">
              // <![CDATA[
                var opts = {
                        // Attach input with an id of "call_date" and give it a "m-sl-d-sl-Y" date format (e.g. 13/03/1990)
                        formElements:{"date":"m-sl-d-sl-Y"}
                };
                datePickerController.createDatePicker(opts);
              // ]]>
              </script>
<?php
		echo $form->input('description',array('size'=>100));
		echo $form->input('notes',array('size'=>100));
        echo $form->input('employee_id',array('label'=>'Employee', 'options'=>$employees, 'default'=>$current_employee), null, array(), '-- Select an Employee --');
		
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Expense.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Expense.id'))); ?></li>
		<li><?php echo $html->link(__('List Expenses', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Expenses Categories', true), array('controller'=> 'expenses_categories', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Expenses Category', true), array('controller'=> 'expenses_categories', 'action'=>'add')); ?> </li>
	</ul>
</div>
