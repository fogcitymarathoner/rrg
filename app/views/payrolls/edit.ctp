<div class="payrolls form">
<?php echo $form->create('Payroll');?>

<?php
		$date = date('m/d/Y',strtotime($this->data['Payroll']['date']));
		?>
	<fieldset>
 		<legend><?php __('Edit Payroll');?></legend>
 		<p>
        <label for="date">Date</label> :
        <input type="text" class="w16em" id="date" name="data[Payroll][date]" value="<?php echo $date; ?>" />
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

		echo $form->input('amount');
		echo $form->input('name',array('size'=>100));
		echo $form->input('notes');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Payroll.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Payroll.id'))); ?></li>
		<li><?php echo $html->link(__('List Payrolls', true), array('action' => 'index'));?></li>
	</ul>
</div>
