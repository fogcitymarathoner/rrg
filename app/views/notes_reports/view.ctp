<?php 
echo $javascript->link('notes_reports_view'); //debug($commissionsReport);exit;
?>
<?php echo $html->link(__('Return to NotesReports', true), array('action' => 'index'));?>

<div class="commissionsReports view">
<h2><?php  __('NotesReport');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Period'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
		From:
			<?php echo date('m/d/Y',strtotime($commissionsReport['CommissionsReport']['start'])); ?>
			&nbsp;
		To:
			<?php echo date('m/d/Y',strtotime($commissionsReport['CommissionsReport']['end'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>

<?php if(!empty($commissionsReport['CommissionsReportsTag']))
{                         //if report tags not empty ?>

<table cellpadding="1" cellspacing="1">
<tr>
	<th><?php echo 'name';?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($commissionsReport['CommissionsReportsTag'] as $commissionsReportsTag):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	} //debug($commissionsReportsTag);debug($commissionsReportsTag['Employee']['salesforce']);
	if(isset($commissionsReportsTag['Employee']['id']))
	{
	if($commissionsReportsTag['Employee']['salesforce'])
	{
?>
	<tr<?php echo $class;?>>
		<td>
			<?php 
			//debug($commissionsReportsTag);//exit;
			echo $commissionsReportsTag['Employee']['firstname'].' '.$commissionsReportsTag['Employee']['lastname']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view_report_tag', $commissionsReportsTag['id'])); ?>
		</td>
	</tr>
<?php }
}
endforeach; ?>
</table>

<?php }; //if report tags not empty ?>
