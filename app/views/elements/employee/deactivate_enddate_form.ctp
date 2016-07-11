
<div id='deactivate-enddate-form'>
<div id='active'>
    <div id='active-label'>
        ACTIVE
    </div>
    <div id='period-end-label'>
        End Date
    </div>
    <div id='period-end'>
        <?php echo $form->input('enddate', array('type'=>'text','class'=>'datepicker', 'label'=>False, 'size'=>9, 'autocomplete'=>'off','id'=>'employee-enddate','value'=>$enddate)); ?>
    </div>


</div>
</div>
<div id='reactivate-form'>
    <div id='reactivate-label'>
        INACTIVE
    </div>
</div>
