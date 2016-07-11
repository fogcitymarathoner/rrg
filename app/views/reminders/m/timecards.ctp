<?php echo $this->element('m/reminders/dialog_header',array());?>
<div data-role="content">
    <ul data-role="listview">
        <ul><li><div class="invoices index">

<?php
echo $javascript->link('reminders');
echo $this->element('m/reminders/timecards',array('timecards'=>$timecards,'webroot'=>$this->webroot));
?>
</div>

        </li>
        </ul>
</div>