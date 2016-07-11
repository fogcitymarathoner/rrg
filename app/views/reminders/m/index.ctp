<?php echo $this->element('m/reminders/dialog_header',array());?>
<div data-role="content">
    <ul data-role="listview">
        <li>
            <div class="invoices index">
                <?php echo $javascript->link('reminders');?>
                <?php echo $this->element('m/reminders/index', array('reminders'=>$reminders,'webroot'=>$this->webroot,)); ?>
            </div>
        </li>
    </ul>
</div>