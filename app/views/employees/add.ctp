<div class="employees form">
<?php
		//$dob = date('m/d/Y',strtotime($this->data['Employee']['dob']));
		$startdate = date('m/d/Y');
		//$enddate = date('m/d/Y',strtotime($this->data['Employee']['enddate']));
		?>

<script type="text/javascript">

jQuery(document).ready(function () {
	$('input.dob').simpleDatepicker({startdate: 1938, enddate: 2032 });
});
</script>

<?php echo $form->create('Employee');?>
	<fieldset>
 		<legend><?php __('Add Employee');?></legend>
	<?php
		echo $form->input('firstname',array('label'=>'*First')).' '.$form->input('nickname',array('label'=>'Nickname')).' '.$form->input('lastname',array('label'=>'*Last'));
		echo $form->input('phone',array('size'=>50));
		echo $form->input('email',array('size'=>50));
		echo $form->input('notes',array('rows'=>6,'cols'=>50));
		echo $form->input('mi');
		echo $form->input('ssn_crypto',array('label'=>'SSN'));

		echo '<p>note: this DOB datepicker does not allow a proper autofill of default value</p>';
		echo $form->input('dob', array('class'=>'dob','type'=>'text','label'=>'dob: '));
		?>
  <p>
  <label for="start_date">Start Date</label> :
  <input type="text" class="w16em" id="start_date" name="data[Employee][startdate]" value="<?php echo $startdate; ?>" />
  </p>
        <script type="text/javascript">
        // <![CDATA[
          var opts = {
                  // Attach input with an id of "call_date" and give it a "m-sl-d-sl-Y" date format (e.g. 13/03/1990)
                  formElements:{"startdate":"m-sl-d-sl-Y"}
          };
          datePickerController.createDatePicker(opts);
        // ]]>
        </script>
  <p>
  <?php
		echo $form->input('street1');
		echo $form->input('street2');
		echo $form->input('city',array('label'=>'City')).', '. $form->input('state_id', array( 'value'=>5,'label'=>'State')).' '.$form->input('zip',array('label'=>'Zip'));
		echo $form->input('bankaccountnumber_crypto');
		echo $form->input('bankaccounttype');
		echo $form->input('bankname');
		echo $form->input('bankroutingnumber_crypto');
		echo $form->input('directdeposit');
		echo $form->input('allowancefederal');
		echo $form->input('allowancestate');
		echo $form->input('extradeductionfed');
		echo $form->input('extradeductionstate');
		echo $form->input('maritalstatusfed');
		echo $form->input('maritalstatusstate');
		echo $form->input('usworkstatus',array('options'=>$i9Options));
		echo $form->input('tcard');
		echo $form->input('w4');
		echo $form->input('de34');
		echo $form->input('i9');
		echo $form->input('medical');
		echo $form->input('indust');
		echo $form->input('info');
		echo $form->input('salesforce');
		echo $form->input('modified_user_id',array('type'=>'hidden', 'value'=>$currentUser));
		echo $form->input('created_user_id',array('type'=>'hidden', 'value'=>$currentUser));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Employees', true), array('action'=>'index'));?></li>
	</ul>
</div>
