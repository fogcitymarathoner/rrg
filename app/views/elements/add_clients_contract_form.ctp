	<fieldset>
 		<legend><?php __('Fill in details for contract - '.$employee['Employee']['firstname'].' '.$employee['Employee']['lastname'].'/'.$clientdata['Client']['name']);?></legend>
	<?php
		echo $form->input('employee_id',array('name'=>'data[ClientsContract][employee_id]','type'=>'hidden','value'=>$ClientsContract['employee_id']));
		echo $form->input('client_id',array('name'=>'data[ClientsContract][client_id]','type'=>'hidden','value'=>$ClientsContract['client_id']));
		echo "Professional IT Services";
		echo $form->input('title',array('name'=>'data[ClientsContract][title]','size'=>70,));
		echo "Reports to ... , Thanks ...";
		echo $form->input('invoicemessage',array('name'=>'data[ClientsContract][invoicemessage]','type'=>'textarea','value'=>'Thank you for your business!'));
$dateexplode = explode('-',date('Y-m-d'));
$javadate = $dateexplode[1].'/'.$dateexplode[2].'/'.$dateexplode[0]; //debug($javadate);
?>
<p><label for="contract_startdate">Start Date</label> : <input type="text" class="w16em" id="start_date" name="data[ClientsContract][startdate]" value="<?php echo $javadate; ?>" /></p>
      <script type="text/javascript">
      // <![CDATA[       
        var opts = {     
                // Attach input with an id of "call_date" and give it a "m-sl-d-sl-Y" date format (e.g. 13/03/1990)                        
                formElements:{"start_date":"m-sl-d-sl-Y"}                  
        };        
        datePickerController.createDatePicker(opts);
      // ]]>
      </script>
<?php		

		echo $form->input('terms',array('name'=>'data[ClientsContract][terms]','value'=>$ClientsContract['terms']));
		echo $form->input('po',array('name'=>'data[ClientsContract][po]',));
		echo $form->input('potracking',array('name'=>'data[ClientsContract][potracking]','value'=>0,'options'=>$trueFalseOptions));
		echo $form->input('employerexp',array('name'=>'data[ClientsContract][employerexp]','value'=>'.1'));
		echo $form->input('notes',array('name'=>'data[ClientsContract][notes]','type'=>'textarea'));
		echo $form->input('reports_to',array('name'=>'data[ClientsContract][reports_to]'));

		echo $form->input('period_id',array('name'=>'data[ClientsContract][period_id]',));

		echo $form->input('modified_user_id',array('name'=>'data[ClientsContract][modified_user_id]','type'=>'hidden', 'value'=>$currentUser));
		echo $form->input('created_user_id',array('name'=>'data[ClientsContract][created_user_id]','type'=>'hidden', 'value'=>$currentUser));
	?>
	</fieldset>