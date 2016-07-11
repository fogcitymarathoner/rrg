<div class="payrolls form">
<?php echo $form->create('Payroll');?>
	<fieldset>
 		<legend><?php __('Add Payroll');?></legend>

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
		echo $form->input('name');
		echo $form->input('notes');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Payrolls', true), array('action' => 'index'));?></li>
	</ul>
</div>
