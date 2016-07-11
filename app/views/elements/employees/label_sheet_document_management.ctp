<!-- This is where the employees collection object is initiated -->
<script xmlns="http://www.w3.org/1999/html">
    empsJSS = jQuery.parseJSON('<?php echo $employeesControl; ?>');
</script>
<?php echo $html->script('center_waiting');?>
<?php echo $html->css('urls');?>
<?php echo $this->element('urls',array());?>
<?php echo $html->css('employees_app');?>
<?php echo $this->element('employees/menu',array()); ?>
<div><h2 class='employees-page-title'><?php __('Active Employee Document Management');?></h2></div>
<div><?php echo $paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)));?></div>
<div>sort by <?php echo $paginator->sort('firstname');?><?php echo $paginator->sort('lastname');?></div>
        <div id="tablecontainer">
          <?php echo $this->element('employees/web_label_sheet_document_management',array('employees'=>$employees,'webroot'=>$this->webroot));?>
        </div>
<div id='footer'>
    <div class="paging">
        <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
     | 	<?php echo $paginator->numbers();?>
        <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
    </div>
    <div id="employees_waiting_area"></div>
    <div id="employeeconfirmdialog" title="Are you sure you want to delete these contact?">
    </div>
</div>
<?php echo $this->element('employee/deactivate_enddate_form',array('activeOptions'=>$activeOptions,'enddate'=>date('m/d/Y')));?>
<?php // has to be after initization of progress bars ?>
<?php echo $javascript->link('employees');?>


