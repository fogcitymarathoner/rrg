<?php
    if ($employee['Employee']['active'] == 0)
    {
    ?>
        <button type="button" class='employee-status' id="deactive-employee-<?php echo $employee['Employee']['id']?>">Reactivate</button>
    <?php
    } else {
            ?>
        <button type="button" class='employee-status' id="deactive-employee-<?php echo $employee['Employee']['id']?>">Deactivate</button>
    <?php
    }