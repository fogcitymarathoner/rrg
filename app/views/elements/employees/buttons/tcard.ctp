<?php
if ($employee['Employee']['tcard'] == 0)
{ ?>
    <button type="button" class='employee-status' id="timecard-employee-<?php echo $employee['Employee']['id']?>">Timecard Not Given</button>
<?php } ?>