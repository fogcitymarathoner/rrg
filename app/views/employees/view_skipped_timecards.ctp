<div class="employees view">

    <?php echo $this->element('employee/menu', array('employee'=>$employee['Employee'],'webroot'=>$this->webroot,));?>
    <h2><?php __($page_title);?></h2>
    <div class="actions">
        <ul>
            <li><?php echo $html->link(__('Return to Employees', true), array('action'=>'index'));?></li>
            <li><?php echo $html->link(__('Employees', true), array('action'=>'index')); ?> </li>
        </ul>
    </div>
    <div class="related">
        <h3><?php __('Related Employees Skipped Timecards');?></h3>
        <?php echo $this->element('employee_skipped_timecards', array('paychecks'=>$employee['Payments'],));?>
    </div>

</div>