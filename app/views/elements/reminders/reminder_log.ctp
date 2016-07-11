<?php
if(count($log))
{
    echo '<ul>';
    foreach ($log as $entry)
    {
        echo '<li>'.$entry['InvoicesTimecardReminderLog']['email'].'</li>';
        echo '<li>'.date('d/m/Y',strtotime ($entry['InvoicesTimecardReminderLog']['timestamp'])).'</li>';
    }
    echo '</ul>';
} else
{
    echo  '<ul><li>NO EMPLOYEE REMINDERS EMAILED</li></ul>';
}