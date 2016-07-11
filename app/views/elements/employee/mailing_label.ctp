<div class='emp-label'>
    <a href="<?php echo $webroot?>employees/view/<?php echo $employee['Employee']['id']?>">
        <?php echo trim ($employee['Employee']['firstname']).' '.trim ($employee['Employee']['lastname']);?>
    </a>
</div>
<div class='emp-label'><?php echo $this->element('employee/address',array('employee'=>$employee));?></div>