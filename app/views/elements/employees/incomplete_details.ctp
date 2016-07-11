
    <div class='emp-details-col-1'>
        <?php
        $k = 0;
        foreach ($employees as $employee):
            $class = 'employee-details';
            if ($k++ % 2 == 0) {
                $class = 'altrow employee-details';
            }?>
            <div id="employee-details-<?php echo $employee['Employee']['id'];?>" class="<?php echo $class;?> emp-col-1-details">
                <?php echo $this->element('employee/web_address_label', array('employee'=>$employee,'webroot'=>$webroot)); ?>
                <div id="employee-reminders-'.$employee['Employee']['id'].'"><?php echo $this->element('employees/reminderbuttons',array( 'employee'=>$employee,'webroot'=>$webroot)); ?></div>
                <div id="employee-emails-'.$employee['Employee']['id'].'">
                    <?php if (!empty($employee['EmployeesEmail'])):?>
                        <?php echo $this->element('employee/emails',array( 'employee'=>$employee,'webroot'=>$webroot)); ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class='emp-details-col-2'>
        <div class='emp-details-col-2-1'>
            <?php
            $k = 0;
            foreach ($employees as $employee):
                $class = 'employee-details';
                if ($k++ % 2 == 0) {
                    $class = 'altrow employee-details';
                }?>
                <div id="employee-completeness-<?php echo $employee['Employee']['id']?>" class='<?php echo $class;?> emp-col-2-details'>
                    <p>Completeness</p>
                    <div id="pbar-<?php echo $employee['Employee']['id']?>"></div>
                        <script>
                            $(document).ready(function($) {
                                $("#pbar-<?php echo $employee['Employee']['id']; ?>").progressbar({
                                    value: 45
                                }).css({marginLeft:'100px'}).prev('p').css({float:'left',
                                            lineHeight:'34px'});
                            });
                        </script>
                    <div id="emp-completeness-value-<?php echo $employee['Employee']['id']?>"><p>COMPLETE</p></div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class='emp-details-col-2-2'>
            <?php
            $k = 0;
            foreach ($employees as $employee):
                $class = 'employee-details';
                if ($k++ % 2 == 0) {
                    $class = 'altrow employee-details';
                }?>
                <div id="employee-details-<?php echo $employee['Employee']['id'];?>" class="<?php echo $class;?>  emp-col-3-details">
                    <div id="employee-remaining-work-<?php echo $employee['Employee']['id']?>">
                        <?php echo $this->element('employees/remaining_work',array('employee'=>$employee));?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>