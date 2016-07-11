<?php
$columnCount = 4;
$rowCount = count($employees)/4;
$empout = 0;
for ( $counter2 = 0; $counter2 < $rowCount; $counter2 += 1) { ?>
    <div class="tablecontainerrow" style="height: 360px">
    <?php
        for ( $counter3 = 0; $counter3 < $columnCount; $counter3 += 1) {
            if ($empout<count($employees))
            {?>
                <div class="column<?php echo $counter3+1?>">
                    <div class="emp-4-col-details ">
                        <?php echo $this->element('employee/web_address_label', array('employee'=>$employees[$empout],'webroot'=>$webroot)); ?>
                        <?php  $empout++;  ?>
                    </div>
                </div>
                <?php
            }
        }?>
    </div>
<?php }?>
