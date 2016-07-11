<?php //debug($employee); ?>
<div class="employees view">

<?php echo $this->element('employee/menu', array('employee'=>$employee['Employee'],'webroot'=>$this->webroot,));?>
    <br>
<h2><?php 
__($page_title);?></h2>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Employees', true), array('action'=>'index'));?></li>
        <li><?php echo $html->link(__('Printable', true), array('action'=>'view_paychecks_due_printable',$employee['Employee']['id'] ));?></li>

    </ul>
</div>

</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Employees', true), array('action'=>'index')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Employees Paychecks Due'); ?></h3> 
	<?php echo $this->element('employee/paychecks', array('paychecks'=>$employee['Paychecks'],'printable'=>0)); ?>
</div>
