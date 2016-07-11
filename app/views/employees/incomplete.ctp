<!-- This is where the employees collection object is initiated -->
<!-- This this layout is messed up.  JS will not turn off spinner. -->
<script xmlns="http://www.w3.org/1999/html">
    empsJSS = jQuery.parseJSON('<?php echo $employeesControl; ?>');
</script>
<?php echo $html->script('center_waiting');?>
<?php echo $html->css('urls');?>
<?php echo $this->element('urls',array());?>
<?php echo $html->css('employees_app');?>
<?php //echo $this->element('waiting_area',array('webroot'=>$this->webroot));?>
<style type="text/css">
    #navigation {
        height: 30px;
    }
    .emp-details-col-1 {
        float:left;
        width:240px;
        padding:10px;
        background:#bfb;
    }
    .emp-details-col-2-1 {
        float:left;
        width:460px;
        padding:10px;
        background:#ddf;
    }
    .emp-details-col-2-2 {
        float:left;
        width:220px;
        padding:10px;
        background:#dff;
    }
    .emp-col-1-details {
        height:360px;
    }
    .emp-col-2-details {
        height:360px;
    }
    .emp-col-3-details {
        height:360px;
    }
    #footer {
        clear:both;
        padding:10px;
        background:#ff9;
    }

        div#tablecontainer
        {
            width:890px;
            border-top:1px solid black;
        }

        div.tablecontainerrow
        {
            clear:both;
            overflow:hidden;
            border:1px solid black;
            border-top:none;
            height: 130px;
            width: 890px;
        }

        .emp-4-col-details {
            height:130px;
            width: 220px;
        }
        div#tablecontainer div div.column1
        {
            width: 220px;
            float:left;
            border:1px solid black;
        }

        div#tablecontainer div div.column2
        {
            width: 220px;
            float:left;
            border:1px solid black;
        }

        div#tablecontainer div div.column3
        {
            width: 220px;
            float:left;
            border:1px solid black;
        }

        div#tablecontainer div div.column4
        {
            width: 220px;
            float:left;
            border:1px solid black;
        }


h2.employees-page-title {
    padding-top: 15px;
}
</style>
<?php echo $this->element('employees/menu',array()); ?>

<div><h2 class='employees-page-title'><?php __('Incomplete Employees');?></h2></div>
<div><?php echo $paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)));?></div>
<div>sort by <?php echo $paginator->sort('firstname');?><?php echo $paginator->sort('lastname');?></div>



            <div class="employees index">
               <?php echo $this->element('employees/incomplete_details',array('employees'=>$employees,'webroot'=>$this->webroot));?>
             </div>


<div id='footer'>
    <div class="paging">
        <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
     | 	<?php echo $paginator->numbers();?>
        <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
    </div>

    <div id="employees_waiting_area">
    </div>
    <div id="employeeconfirmdialog" title="Are you sure you want to delete these contact?">
    </div>
</div>

<?php echo $this->element('employee/deactivate_enddate_form',array('activeOptions'=>$activeOptions,'enddate'=>date('m/d/Y')));?>
<?php // has to be after initization of progress bars ?>
<?php echo $javascript->link('employees');?>
