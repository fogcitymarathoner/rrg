<div class="employees form">
<?php //debug($this->data);exit; ?>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Employees', true), array('action'=>'index'));?></li>
	</ul>
</div>
<script type="text/javascript">

jQuery(document).ready(function () {


        $( ".datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange:'1938:2020'
});

});
</script>
<?php echo $form->create('Employee');?>
    <fieldset>
        <legend><?php __('Add Letter');?></legend>

        <?php
        echo $form->input('EmployeesLetter.employee_id',array('type'=>'hidden','value'=>$this->data['Employee']['id']));
?>

<?php echo $form->input('EmployeesLetter.date', array('class'=>'datepicker','type'=>'text',
        'label'=>False, 'size'=>9, 'autocomplete'=>'off', 'value'=>date('m/d/y'))); ?>
<br>

        <?php
                echo $form->input('EmployeesLetter.title');
                ?>
        <?php
                echo $form->input('EmployeesLetter.salutation');
                ?>
        <?php
                echo $form->input('EmployeesLetter.para1',array('rows'=>10,'cols'=>80));
                ?>
<?php
        echo $form->input('EmployeesLetter.para2',array('rows'=>10,'cols'=>80));
?>
<?php
        echo $form->input('EmployeesLetter.para3',array('rows'=>10,'cols'=>80));
?>
<?php
        echo $form->input('EmployeesLetter.para4',array('rows'=>10,'cols'=>80));
?>
<?php
        echo $form->input('EmployeesLetter.para5',array('rows'=>10,'cols'=>80));
?>

    </fieldset>
<?php echo $form->end('Submit');?>
