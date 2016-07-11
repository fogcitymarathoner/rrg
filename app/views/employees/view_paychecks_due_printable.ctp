<?php //debug($employee); ?>
<div class="employees view">

<h2><?php 
__($page_title);?></h2>

</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Employees', true), array('action'=>'index')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Employees Paychecks Due'); ?></h3> 
	<?php echo $this->element('employee/paychecks', array('paychecks'=>$employee['Paychecks'],'printable'=>1)); ?>
</div>
