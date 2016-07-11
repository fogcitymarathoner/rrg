<?php //debug($employee); ?>
<div class="employees view">

<h2><?php 
__($page_title);?></h2>

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

<div class="related">
    <?php echo $this->element('commissions/commissions_reports_summary_list', array('reports'=>$reports,
    'print'=> True
    ));?>
</div>