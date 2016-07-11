<fieldset>
 		<legend><?php __('Edit Contract General Info');?></legend>
Enter Title, Message, email list, then add billable items from below.
	<?php
		//debug($this->data);exit;
		//$employee = $contract['Employee'];
		echo 'Employee: '.$employee['firstname'].' '.$employee['lastname'];
		echo '<br>Client: '.$this->data['Client']['name'];
		echo $form->input('title',array('name'=>'data[ClientsContract][title]','value'=>$contract['title'],'type'=>'textarea','cols'=>100));
		echo $form->input('invoicemessage',array('name'=>'data[ClientsContract][invoicemessage]','value'=>$contract['invoicemessage'],'type'=>'textarea','cols'=>100));
$dateexplode = explode('-',$contract['startdate']);
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
if ($contract['enddate'])
{
$dateexplode = explode('-',$contract['enddate']);
$javadate = $dateexplode[1].'/'.$dateexplode[2].'/'.$dateexplode[0]; //debug($javadate);
} else {
$javadate = '00/00/0000';
}
?>
<p><label for="contract_enddate">End Date</label> : <input type="text" class="w16em" id="end_date" name="data[ClientsContract][enddate]" value="<?php echo $javadate; ?>" /></p>
      <script type="text/javascript">
      // <![CDATA[       
        var opts = {     
                // Attach input with an id of "call_date" and give it a "m-sl-d-sl-Y" date format (e.g. 13/03/1990)                        
                formElements:{"end_date":"m-sl-d-sl-Y"}                  
        };        
        datePickerController.createDatePicker(opts);
      // ]]>
      </script>
<?php		
		echo $form->input('terms',array('name'=>'data[ClientsContract][terms]','value'=>$contract['terms']));
		echo $form->input('po',array('name'=>'data[ClientsContract][po]','value'=>$contract['po']));
		echo $form->input('potracking',array('name'=>'data[ClientsContract][potracking]','value'=>$contract['potracking'],'options'=>$trueFalseOptions));
		echo $form->input('employerexp',array('name'=>'data[ClientsContract][employerexp]','value'=>$contract['employerexp']));
		echo $form->input('notes',array('name'=>'data[ClientsContract][notes]','value'=>$contract['notes'],'type'=>'textarea','cols'=>100));
		echo $form->input('reports_to',array('name'=>'data[ClientsContract][reports_to]','value'=>$contract['reports_to'],));
		echo $form->input('active',array('name'=>'data[ClientsContract][active]','value'=>$contract['active'],'options'=>$activeOptions));
		echo $form->input('addendum_executed',array('name'=>'data[ClientsContract][addendum_executed]','value'=>$contract['addendum_executed'],'options'=>$addendumOptions));
		echo $form->input('period_id',array('name'=>'data[ClientsContract][period_id]',));
		echo $form->input('modified_user_id',array('name'=>'data[ClientsContract][modified_user_id]','type'=>'hidden', 'value'=>$currentUser));
		echo $form->input('id',array('name'=>'data[ClientsContract][id]','type'=>'hidden', 'value'=>$contract['id']));
		echo $form->input('client_id',array('name'=>'data[ClientsContract][client_id]','type'=>'hidden', 'value'=>$contract['client_id']));
	?>
	</fieldset>


