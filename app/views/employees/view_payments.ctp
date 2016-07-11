<div class="employees view">
    <?php echo $this->element('employee/menu', array('employee'=>$employee['Employee'],'webroot'=>$this->webroot,));?>
    <br>
    <h2><?php __($page_title);?></h2>
    <div class="actions">
        <ul>
            <li><?php echo $html->link(__('Print View', true), array('action'=>'view_payments_print',$employee['Employee']['id'])); ?></li>
        </ul>
    </div>
</div>
<div class="related">
	<h3><?php __('Related Employees Payments');?></h3> <?php //debug($employee);exit?>
	<?php echo $this->element('employee/paychecks', array('paychecks'=>$employee['Paychecks'],'printable'=>0)); ?>
</div>
