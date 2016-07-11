<?php if ($employee['Employee']['medical'] == 0){ ?>
    <button type="button" class='employee-status' id="medical-employee-<?php echo $employee['Employee']['id']?>">No Medical Given</button>
<?php } ?>