<div class="clientseditinvoice form">

	<fieldset>
<?php echo $form->create('Employees',array('controller'=>'employees' , 'action'=>'edit_invoice/'.$this->data['Invoice']['id'],'name'=>'invoice_form'));?>
	<fieldset>
 		<legend><?php __($page_title);?></legend>
<?php	
		$dateexplode = explode('-',$this->data['Invoice']['date']);
		$javadate = $dateexplode[1].'/'.$dateexplode[2].'/'.$dateexplode[0]; 
		?>
<p>
<label for="invoice_date">Date</label> : 
<input type="text" class="w16em"  readonly=true id="date" name="data[Invoice][date]" value="<?php echo $javadate; ?>" />
</p>
      <script type="text/javascript">
      // <![CDATA[       
        var opts = {     
                // Attach input with an id of "call_date" and give it a "m-sl-d-sl-Y" date format (e.g. 13/03/1990)                        
                formElements:{"date":"m-sl-d-sl-Y"}                  
        };        
        //datePickerController.createDatePicker(opts);
      // ]]>
      </script>
       <?php
		echo $form->input('Invoice.id',
				array('type'=>'hidden'));
		echo $form->input('Invoice.contract_id',
				array('type'=>'hidden'));
		echo $form->input('Invoice.next',
				array('type'=>'hidden','value'=>$next));
		echo $form->input('Invoice.notes',array('AUTOCOMPLETE'=>'OFF','size'=>100));
		?>

<?php	
		$dateexplode = explode('-',$this->data['Invoice']['period_start']);
		$javadate = $dateexplode[1].'/'.$dateexplode[2].'/'.$dateexplode[0]; 
		?>
<p>		
<p>
<label for="invoice_date">Period Start</label> : 
<input type="text" class="w16em" readonly=true id="period_start" name="data[Invoice][period_start]" value="<?php echo $javadate; ?>" />
</p>

<?php	
		$dateexplode = explode('-',$this->data['Invoice']['period_end']);
		$javadate = $dateexplode[1].'/'.$dateexplode[2].'/'.$dateexplode[0]; 
		?>
<p>
<label for="invoice_date">Period End</label> : 
<input type="text" class="w16em"  readonly=true id="period_end" name="data[Invoice][period_end]" value="<?php echo $javadate; ?>" />
</p>

      <script type="text/javascript">
      // <![CDATA[       
        var opts = {     
                // Attach input with an id of "call_date" and give it a "m-sl-d-sl-Y" date format (e.g. 13/03/1990)                        
                formElements:{"period_start":"m-sl-d-sl-Y"}                  
        };        
        //datePickerController.createDatePicker(opts);
      // ]]>
      </script>
      
      <script type="text/javascript">
      // <![CDATA[       
        var opts = {     
                // Attach input with an id of "call_date" and give it a "m-sl-d-sl-Y" date format (e.g. 13/03/1990)                        
                formElements:{"period_end":"m-sl-d-sl-Y"}                  
        };        
        //datePickerController.createDatePicker(opts);
      // ]]>
      </script>
      <?php

		echo $form->input('Invoice.modified_user_id',array('type'=>'hidden', 'value'=>$currentUser));
		?> 
		  
	<?php	echo $form->end('Submit');?>
			
	</fieldset>

</div>
<div class="actions">
	<ul>
	



		<li><?php echo $html->link(__('Return to employee', true), array('controller'=>'employees','action'=>$next,$employee['Employee']['id'])); ?> </li>
	</ul>
</div>
<?php //debug($this->data) 
?>
