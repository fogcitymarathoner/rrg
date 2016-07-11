<?php echo $this->element('m/reminders/dialog_header',array());?>
<div data-role="content">
    <ul data-role="listview">
    <li><div class="invoices index">

        <div class="invoices index">

<?php 

echo $javascript->link('reminders');

            echo $this->element('m/reminders/opens',array('opens'=>$opens,'webroot'=>$this->webroot));
?>
</div>

        </li>
        </ul>