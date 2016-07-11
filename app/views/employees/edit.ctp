<div class="employees form">
<?php //debug($this->data);exit; ?>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Employees', true), array('action'=>'index'));?></li>
	</ul>
</div>
<?php
		$dob = date('m/d/Y',strtotime($this->data['Employee']['dob']));
		$startdate = date('m/d/Y',strtotime($this->data['Employee']['startdate']));
        if ($this->data['Employee']['enddate'] != '0000-00-00')
        {
		    $enddate = date('m/d/Y',strtotime($this->data['Employee']['enddate']));
        } else {
            $enddate = '00/00/0000';
        }

        //debug($this->data['Employee']['enddate']);debug($enddate);exit;
		?>
<script type="text/javascript">

jQuery(document).ready(function () {


    $( ".datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange:'1938:2020'
    });

});
</script>

        <style>
            .two-col-container {
                width: 1000px;
            }
            .left-col{
                width: 495px;
                position:relative;
                float: left;
                top:0;
                right:0;
            }
            .right-col{
                width: 495px;
                position:relative;
                float: right;
                top:0;
            }
            #contact-info {
                height: 190px;
                border:thin solid black;
                position: relative;
                background-color: #b5f8c9;
                top: 28px;
            }
            #name-headercontainer {
                position:relative;
                height: 10px;
                border:thin solid black;
            }
            #name-container {
                height: 50px;
                position:relative;
                top: 20px;
                border:thin solid black;
                background-color: #ffcaca;
            }
            .name-header {
                position:relative;
                float: left;
                right:0;
                width:120px;
                font-weight:bold;
                z-index: 1;
                margin-left: 5px;
                top:20px;
            }
            .name-header-nick {
                position:relative;
                float: left;
                right:0;
                width:115px;
                font-weight:bold;
                z-index: 1;
                margin-left: 5px;
                top:20px;
            }
            .name {
                position:absolute;
                top:10px;;
                float: left;
                right:0;
                width:120px;
            }
            .first {
                left: 0px;
                top: 20px;
                margin-left: 5px;
            }
            .middle {
                left: 120px;
                top: 20px;
                margin-left: 5px;
            }
            .last {
                left: 240px;
                top: 20px;
                margin-left: 5px;
            }
            .nick {
                left: 360px;
                top: 20px;
                margin-left: 5px;
            }
            .name input{
                width:120px;
                font-size: xx-small;
            }

            #address-headercontainer {
                height: 10px;
                border:thin solid black;
            }
            #address-container {
                height: 50px;
                border:thin solid black;
            }
            .address-header {
                position:relative;
                float: left;
                top:0;
                right:0;
                width:120px;
                margin-left: 5px;
                font-weight:bold;
            }

            .street {
                position:relative;
                top:0;
                right:0;
                bottom: 10px;
                width:200px;
            }

            .address {
                position:relative;
                float: left;
                top:0;
                right:0;
                width:120px;
            }
            .address input{

                width:120px;
                font-size: xx-small;
            }

            .city-state-zip {
                position:relative;
                float: left;
                top:0;
                right:0;
                width:120px;
                font-weight:bold;
            }

            .zip-input {
                position:relative;
                float: left;
                top:0;
                left: 7px;
                width:120px;
                font-weight:bold;
            }
            .state-input {
                position:relative;
                float: left;
                top:0;
                left: 5px;
                width:120px;
                font-weight:bold;
            }
            .city {
                position:relative;
                float: left;
                top:0;
                right:0;
                width:170px;
                font-weight:bold;
                z-index: 99;
            }
            .city input {
                width: 170px;
            }
            .i9-container {
                height: 60px;
                top: 20px;
                position:relative;
                background-color: #ace4f4;
                border:thin solid black;
            }
            .i9-container p{
                font-size: xx-small;
            }
            .i9-header {
                position:relative;
                float: left;
                right:0;
                width:120px;
                font-weight:bold;
                z-index: 1;
                margin-left: 5px;
                top:2px;
                width: 50px;
            }
            #i9-headercontainer {
                position:relative;
                width: 15px;
                height: 10px;
                border:thin solid black;
            }
            #ssn {
                float: left;
                position:relative;
                left: 18px;
                top: 2px;
                width: 220px;
                height: 25px;
            }
            #ssn-peak {
                position:relative;
                float: left;
                top: -20px;
                left: 110px;
            }
            #ssn-note {
                position:relative;
                float: left;
                top: -20px;
                left: 120px;
            }
            #dob{
                position:relative;
                float: left;
                top: 30px;
                left: -265px;
            }
            #dob p{
                margin-top: 5px;
            }
            #dob-label{
                position:relative;
                float: left;
                left: -270px;
                top: 25px;
                font-weight:bold;
            }
            #us-work{
                position:relative;
                float: left;
                left: 175px;
            }
            #us-work-label
            {
                position:relative;
                float: left;
                left: 166px;
                top: 3px;
                font-weight:bold;
            }
            #w4 {
                height: 165px;
                top: 36px;
                position:relative;
                background-color: #bcbd7d;
                border:thin solid black;
            }
            #w4-fed {
                width: 249px;
                height: 135px;
                top: 5px;
                position:relative;
                background-color: #bcbd7d;
                border:thin solid black;
            }
            #w4-state {
                width: 230px;
                height: 135px;
                top: -132px;
                left: 255px;
                position:relative;
                background-color: #bcbd7d;
                border:thin solid black;
            }
            #period {
                height: 31px;
                top: 36px;
                position:relative;
                background-color: #ffffc9;
                border:thin solid black;
            }
            #period-start
            {
                position:relative;
                float: left;
                right: -25px;
                top: 5px;
                z-index: 99;
            }
            #period-start-label
            {
                position:relative;
                float: left;
                right: -11px;
                top: 5px;
                font-weight:bold;
                z-index: 99;
            }
            #period-end
            {
                position:relative;
                float: left;
                left: 59px;
                top: 5px;
            }
            #period-end-label
            {
                position:relative;
                float: left;
                left: 40px;
                top: 5px;
                font-weight:bold;
            }
            #active {
                height: 33px;
                top: 44px;
                position:relative;
                background-color: #1cc461;
                border:thin solid black;
            }
            #active-label
            {
                position:relative;
                float: left;
                left: 5px;
                top: 5px;
                font-weight:bold;
            }
            #active-input
            {
                position:relative;
                float: left;
                left: 30px;
                top: 5px;
                font-weight:bold;
            }
            #reactivate {
                height: 120px;
                top: 47px;
                position:relative;
                background-color: #1cacc4;
                border:thin solid black;
            }
	#deactivate-enddate-form{
		position: relative;
		top: 12px;
	}
            #dd {
                height: 120px;
                top: 60px;
                position:relative;
                background-color: #1cacc4;
                border:thin solid black;
            }
            #notes {
                height: 120px;
                top: 60px;
                position:relative;
                background-color: #dd7c7b;
                border:thin solid black;
            }
            #password {
                height: 25px;
                top: 45px;
                position:relative;
                background-color: #c41cb4;
                border:thin solid black;
            }
            #buttons {
                height: 75px;
                top: 70px;
                position:relative;
                background-color: #dadd7b;
                border:thin solid black;
            }
            #buttons-col-1{

                position:relative;
                width: 165px;
                top: 5px;
            }
            #buttons-col-2{

                position:relative;
                width: 165px;
                bottom: 60px;
                left: 120px;
            }
            #buttons-col-3{

                position:relative;
                width: 165px;
                bottom: 123px;
                left: 255px;
            }
            #submit {
                height: 120px;
                width: 1000px;
                top: 800px;
                position:absolute;
                background-color: #dd7c7b;
                border:thin solid black;
            }
            .dob input{
                z-index: 9999999;

            }
        </style>
<div class='two-col-container'>

<?php echo $form->create('Employee');?>

<?php
        echo $form->input('id',array('type'=>'hidden'));
        ?>
<h2><?php __($page_title);?></h2>
    <div class='left-col'>

        <div id='name-header-container'>
            <div class='name-header'>
                First Name
            </div>
            <div class='name-header'>
                Middle Initial
            </div>
            <div class='name-header'>
                Last Name
            </div>
            <div class='name-header-nick'>
                Nickname
            </div>
        </div>
        <div id='name-container'>
            <div class='name first'>
                <?php echo $form->input('firstname', array('label'=>false));?>
            </div>
            <div class='name middle'>
                <?php echo $form->input('mi', array('label'=>false));?>
            </div>
            <div class='name last'>
                <?php echo $form->input('lastname', array('label'=>false));?>
            </div>
            <div class='name nick'>
                <?php echo $form->input('nickname', array('label'=>false));?>
            </div>
        </div>
        <div id='contact-info'>

            <div id='name-header-container'>
                <div class='address-header'>
                    Address
                </div>
            </div>
            <div class='street'>
                <?php echo $form->input('street1', array('label'=>false, 'size'=>50));?></div>
            <div class='street'><?php echo $form->input('street2', array('label'=>false, 'size'=>50));?></div>
            <div class='city'>
                <?php echo $form->input('city', array('label'=>false, 'size'=>25));?>
            </div>
            <div class='state-input'>
                <?php echo $form->input('state_id', array('label'=>false));?>
            </div>
            <div class='zip-input'>
                <?php echo $form->input('zip', array('label'=>false, 'size'=>10));?>
            </div>

            <div class='address-header'>
                Phone
            </div>
            <div class='street'>
                <?php
                        echo $form->input('phone', array('size'=>50, 'label'=>false)); //debug($empemails[0]['EmployeesEmail']['email']);
                        ?>
            </div>
            <div class='address-header'>
                Email
            </div>
            <div class='street'>
                <?php
                        if(isset($empemails[0]))
                        {
                        echo $form->input('email',array('size'=>50 , 'label'=>false,'value'=>$empemails[0]['EmployeesEmail']['email']));
                        } else {
                        echo $form->input('email',array('size'=>50,));
                        }
                        ?>

            </div>
        </div>
        <div id='w4'>
            <div id='w4-fed'>
                <?php
                    echo $form->input('allowancefederal',array('value'=>$this->data['Employee']['allowancefederal']));
                    echo $form->input('extradeductionfed',array('value'=>$this->data['Employee']['extradeductionfed']));
                    echo $form->input('maritalstatusfed',array('value'=>$this->data['Employee']['maritalstatusfed']));
                ?>
            </div>
            <div id='w4-state'>
                 <?php
                    echo $form->input('allowancestate',array('value'=>$this->data['Employee']['allowancestate']));
                    echo $form->input('extradeductionstate',array('value'=>$this->data['Employee']['extradeductionstate']));
                    echo $form->input('maritalstatusstate',array('value'=>$this->data['Employee']['maritalstatusstate']));
                 ?>
            </div>
        </div>
        <div id='password'>

            <?php
                    echo $form->input('password');
                    ?>
        </div>
        <div id='notes'>

            <?php
                    echo $form->input('notes',array('rows'=>6,'cols'=>50));
                    ?>
        </div>
    </div>
    <div class='right-col'>
<div class='i9-container'>

    <div id='i9-header-container'>
        <div class='i9-header'>
            I9 SSN
        </div>
    </div>

    <div id='ssn'>
         <?php echo $form->input('ssn_crypto',array('label'=>False,'size'=>11,'value'=>$this->data['Employee']['ssn_crypto']));
                 ?>

        <div id='ssn-peak'>
        <p><?php echo $this->data['Employee']['ssn_crypto_display']; ?></p>
        </div>

        <div id='ssn-note'>

            <p><?php echo 'include hyphens';?></p>
        </div>
    </div>
    <div id='dob-label'>
        DOB
    </div>
        <div id='dob'>
            <?php echo $form->input('dob', array('class'=>'datepicker','type'=>'text','label'=>False, 'size'=>9, 'autocomplete'=>'off', 'value'=>$dob)); ?>
        </div>
    <div id='us-work-label'>
        US Work Status
    </div>
<div id='us-work'>
    <?php echo $form->input('usworkstatus',array('options'=>$i9Options,'label'=>False));?>
</div>
</div>
<div id='period'>
        <div id='period-start-label'>
            Start Date
            <?php echo $form->input('active',array('options'=>$activeOptions));?>
        </div>
    <div id='period-start'>

        <?php echo $form->input('startdate', array('class'=>'datepicker','type'=>'text','label'=>False, 'size'=>9, 'autocomplete'=>'off', 'value'=>$startdate)); ?>
    </div>
</div>
<div id='reactivate'>
        <?php 
		echo $form->input('active',array('options'=>$activeOptions));
 ?>
        <?php echo $this->element('employee/deactivate_enddate_form',array('activeOptions'=>$activeOptions,'enddate'=>$enddate));?>
</div>
        <div id='dd'>
            <?php echo $form->input('directdeposit');?>
            <?php
                    echo $form->input('bankname');
                    echo $form->input('bankaccounttype');
                    echo $form->input('bankaccountnumber_crypto');
                    echo $form->input('bankroutingnumber_crypto');
                    ?>
        </div>

        <div id='buttons'>
            <div id='buttons-col-1'>

                <?php
                        echo $form->input('tcard');
                        echo $form->input('w4');
                        echo $form->input('de34');
                        ?>
            </div>
                <div id='buttons-col-2'>
                    <?php
                            echo $form->input('i9');
                            echo $form->input('medical');
                            echo $form->input('indust');
                            ?>
                </div>
                    <div id='buttons-col-3'>
                        <?php
                                echo $form->input('info');
                                echo $form->input('salesforce');
                                echo $form->input('voided');
                                ?>
                    </div>
            <?php
                    echo $form->input('modified_user_id',array('type'=>'hidden', 'value'=>$currentUser));
                    echo $form->input('username',array('type'=>'hidden'));
                    ?>
        </div>
</div>

</div>



</div>
<div id='submit'>

<?php echo $form->end('Submit');?>

<div class="actions">
    <ul>
        <li><?php echo $html->link(__('New Employees Email Address', true), array('action'=>'add_email/'.$this->data['Employee']['id']));?> </li>
    </ul>
</div>

<div class="related">
    <h3><?php __('Employees Email Addresses');?></h3>
    <?php if (!empty($this->data['EmployeesEmail'])):?>
    <table cellpadding = "0" cellspacing = "0">
        <tr>
            <th><?php __('email'); ?></th>
            <th class="actions"><?php __('Actions');?></th>
        </tr>
        <?php
                $i = 0;
                foreach ($this->data['EmployeesEmail'] as $employeesEmail):
                $class = null;
                if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
                }
                ?>
        <tr<?php echo $class;?>>
        <td><?php echo $employeesEmail['email'];?></td>
        <td class="actions">
            <?php echo $html->link(__('Edit', true), array('action'=>'edit_email', $employeesEmail['id'])); ?>
            <?php echo $html->link(__('Delete', true), array('action'=>'delete_email', $employeesEmail['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $employeesEmail['id'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>

</div>
