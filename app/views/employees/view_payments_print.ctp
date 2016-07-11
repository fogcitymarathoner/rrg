<div class="employees view">
    <h2><?php __($page_title);?></h2>
</div>
<div class="related">
    <?php echo $this->element('employee/paychecks', array('paychecks'=>$employee['Paychecks'],'printable'=>1)); ?>
    <?php echo $this->element('employee/payment_history_insurance', array('paychecks'=>$employee['Payments'],));?>
</div>
