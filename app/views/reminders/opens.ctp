
<div class="invoices index">
<?php echo $this->element('reminders/menu',array());?>
<?php
    echo $javascript->link('reminders');
    echo $this->element('reminders/opens',array('timecards'=>$opens,'webroot'=>$this->webroot));
?>
</div>
