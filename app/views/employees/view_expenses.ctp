<?php //debug($employee); ?>
<div class="employees view">

    <?php echo $this->element('employee/menu', array('employee'=>$employee['Employee'],'webroot'=>$this->webroot,));?>
    <br>
<h2><?php
__($page_title);?></h2>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Return to Employees', true), array('action'=>'index'));?></li>

        <li><?php echo $html->link(__('Year Category Report', true), array('controller'=> 'expenses', 'action'=>'select_category_year')); ?> </li>
      	<li><?php echo $html->link(__('New Expense', true), array( 'action'=>'add_expense',$employee['Employee']['id'])); ?> </li>

	</ul>
</div>

    <?php echo $this->element('expenses_index', array(
    							'expenses'=>$employee['Expenses'],
    							'webroot'=>$this->webroot,
    							));
    ?>

</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Employees', true), array('action'=>'index')); ?> </li>
	</ul>
</div>
