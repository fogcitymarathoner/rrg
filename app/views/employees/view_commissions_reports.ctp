<?php //debug($employee); ?>
<div class="employees view">

    <?php echo $this->element('employee/menu', array('employee'=>$employee['Employee'],'webroot'=>$this->webroot,));?>
    <br>
<h2><?php __($page_title);?></h2>
<div class="actions">
	<ul>
        <li><?php echo $html->link(__('Return to Employees', true), array('action'=>'index'));?></li>
        <li><?php echo $html->link(__('Printable', true), array('action'=>'view_commissions_reports_printable',$employee['Employee']['id'] ));?></li>
	</ul>
</div>

	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $employee['Employee']['firstname']; ?>
			<?php echo $employee['Employee']['mi']; ?>

			<?php echo $employee['Employee']['lastname']; ?>
			<?php echo $employee['Employee']['nickname']; ?>

			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Employees', true), array('action'=>'index')); ?> </li>
	</ul>
</div>

<div class="related">
    <?php echo $this->element('commissions/commissions_reports_summary_list', array('reports'=>$reports,
    'print'=> False
    ));?>
</div>