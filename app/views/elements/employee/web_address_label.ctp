  <script>
  $(function() {
    $( ".emp-label-tabs" ).tabs();
  });
  </script>
<div class="emp-label-tabs" style="height:360px">
  <ul>
    <li><a href="#emp-label-tabs-1-<?php echo $employee['Employee']['id']?>">address</a></li>
    <li><a href="#emp-label-tabs-2-<?php echo $employee['Employee']['id']?>">email</a></li>
  </ul>
  <div id="emp-label-tabs-1-<?php echo $employee['Employee']['id']?>">

        <?php echo $this->element('employee/mailing_label', array('employee'=>$employee, 'webroot'=>$this->webroot)); ?>
        <div id="employee-deactivate-'<?php echo $employee['Employee']['id']; ?>'"
             class='emp-label'>
            <?php echo $this->element('employees/buttons/activeinactive',array('employee'=>$employee,'webroot'=>$webroot)); ?>
        </div>
  </div>
  <div id="emp-label-tabs-2-<?php echo $employee['Employee']['id']?>">
    <div class='emp-label'><?php echo $this->element('employee/emails',array('employee'=>$employee,'webroot'=>$this->webroot));?></div>
  </div>
</div>
