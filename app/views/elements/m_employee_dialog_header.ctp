<?php $name = $employee['firstname'].' '.$employee['lastname'];?>
<div data-role="header">
    <h3>
        <?php
                if($type == 'view')
                {
                   echo $name;
                } elseif ($type == 'i9' || $type == 'w4' || $type == 'status' || $type == 'dates')
                {
                echo 'Edit '.$type.' info for <br>'.$name;
                }
                elseif ($type == 'edit' )
                {
                echo 'Edit name address info for <br>'.$name;
                }
        ?>
    </h3>
    <div id='buttons'>
        <a href="<?php echo $this->webroot?>m/employees/"  rel='external' data-role="button" data-inline="true" data-icon="left_arrow">Back to Employees</a>
        <a href="<?php echo $this->webroot?>m/employees/edit/<?php echo $employee['id']?>"   data-role="button" data-inline="true" data-icon="pencil_16x16">Name/Address</a>
        <a href="<?php echo $this->webroot?>m/employees/edit/<?php echo $employee['id'].'/w4'?>"   data-role="button" data-inline="true" data-icon="pencil_16x16">W4</a>
        <a href="<?php echo $this->webroot?>m/employees/edit/<?php echo $employee['id'].'/i9'?>"   data-role="button" data-inline="true" data-icon="pencil_16x16">I9</a>
        <a href="<?php echo $this->webroot?>m/employees/edit/<?php echo $employee['id'].'/status'?>"   data-role="button" data-inline="true" data-icon="pencil_16x16">Status</a>
        <a href="<?php echo $this->webroot?>m/employees/edit/<?php echo $employee['id'].'/banking'?>"   data-role="button" data-inline="true" data-icon="pencil_16x16">banking</a>
        <a href="<?php echo $this->webroot?>m/employees/edit/<?php echo $employee['id'].'/terminate'?>"   data-role="button" data-inline="true" data-icon="pencil_16x16">Terminate</a>
        <a href="<?php echo $this->webroot?>m/employees/edit/<?php echo $employee['id'].'/dates'?>"   data-role="button" data-inline="true" data-icon="pencil_16x16">dates</a>
    </div>
</div>
