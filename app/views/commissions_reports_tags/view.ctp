<div class="commissionsReportsTags view">
<h2><?php  __('CommissionsReportsTag');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $commissionsReportsTag['CommissionsReportsTag']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Commissions Report Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $commissionsReportsTag['CommissionsReportsTag']['commissions_report_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $commissionsReportsTag['CommissionsReportsTag']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Longname'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $commissionsReportsTag['CommissionsReportsTag']['longname']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit CommissionsReportsTag', true), array('action' => 'edit', $commissionsReportsTag['CommissionsReportsTag']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete CommissionsReportsTag', true), array('action' => 'delete', $commissionsReportsTag['CommissionsReportsTag']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $commissionsReportsTag['CommissionsReportsTag']['id'])); ?> </li>
		<li><?php echo $html->link(__('List CommissionsReportsTags', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New CommissionsReportsTag', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
