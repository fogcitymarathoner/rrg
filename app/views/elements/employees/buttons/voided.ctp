<?php

    $strike = 0;
    if(!$employee['Employee']['dob'])
        $strike++;
    if(!$employee['Employee']['startdate'])
        $strike++;
    if(!$employee['Employee']['street1'])
        $strike++;
    if(!$employee['Employee']['city'])
        $strike++;
    if(!$employee['Employee']['usworkstatus'])
        $strike++;
    if(!$employee['Employee']['tcard'])
        $strike++;
    if(!$employee['Employee']['w4'])
        $strike++;
    if(!$employee['Employee']['de34'])
        $strike++;
    if(!$employee['Employee']['i9'])
        $strike++;
    if(!$employee['Employee']['indust'])
        $strike++;
    if(!$employee['Employee']['info'])
        $strike++;
    if(!$employee['Employee']['zip'])
        $strike++;

    $strike_max = 12;
    $strike_weight = $strike_max - $strike;
if ($employee['Employee']['voided'] == 0 && $strike > 1)
{ ?>
    <button type="button" class='employee-status' id="voided-employee-<?php echo $employee['Employee']['id']?>">Void this new employee</button>
<?php } ?>