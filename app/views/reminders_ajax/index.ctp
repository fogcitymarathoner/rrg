
<?php echo $javascript->link('center_waiting');?>
<?php echo $html->css('reminders');?>
<?php echo $this->element('waiting_area',array('webroot'=>$this->webroot));?>

<?php echo $this->element('reminder/edit_note_form',array());?>
<?php echo $this->element('reminder/edit_invoice_form',array());?>
<!-- this is the script written by the controller action -->
<script><?php echo $script;?></script>

<div class="reminder-tabs">
    <ul>
        <li><a href="#reminders-tabs-1">Timecard Reminders</a></li>
        <li><a href="#reminders-tabs-2">Timecards</a></li>
        <li><a href="#reminders-tabs-3">Reminders Waiting</a></li>
        <li><a href="#reminders-tabs-4">Opens Invoices</a></li>
        <li><a href="#reminders-tabs-5">Timecard Receipts Pending</a></li>
        <li><a href="#reminders-tabs-6">Timecard Receipts Sent</a></li>
        <li><a href="#reminders-tabs-7">VOIDED</a></li>
    </ul>
    <div id="reminders-tabs-1">
        <div id="reminders-main-header"><h2 class='tab-title'>Timecard Reminders</h2></div>
        <div id='reminders-index' class="tab-index"></div>
    </div>
    <div id="reminders-tabs-2" >
        <div id="reminders-main-header"><h2 class='tab-title'>Timecards</h2></div>
        <div id='timecards-index' class="tab-index"></div>
    </div>
    <div id="reminders-tabs-3" >
        <div id="reminders-main-header"><h2 class='tab-title'>Reminders Waiting</h2><p>Reminds with last day is in future.</p></div>
        <div id='reminders-waiting-index' class="tab-index"></div>
    </div>
    <div id="reminders-tabs-4">
        <div id="reminders-main-header"><h2 class='tab-title'>Opens Invoices</h2></div>
        <div id='opens-index'></div>
    </div>
    <div id="reminders-tabs-5">
        <div id="reminders-main-header"><h2 class='tab-title'>Timecard Receipts Pending</h2></div>
        <div id='receipts-pending-index'></div>
    </div>
    <div id="reminders-tabs-6">
        <div id="reminders-main-header"><h2 class='tab-title'>Timecard Receipts Sent</h2></div>
        <div id='receipts-sent-index'></div>
    </div>
    <div id="reminders-tabs-7">
        <div id="reminders-main-header"><h2 class='tab-title'>VOIDED</h2></div>
        <div id='voids-index' class="tab-index"></div>
    </div>