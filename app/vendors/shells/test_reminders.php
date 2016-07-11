<?php
// vendors/shells/demo.php
// Run in Cron Job
// Generates All the monthly report numbers from epoch
class TestRemindersShell extends Shell
{
    var $uses = array('Employee');

    function initialize()
    {
        // empty
    }

    function main()
    {

        Configure::write('debug', 2);

        App::import('Component', 'reminders');

        $this->reminders = new RemindersComponent;
        print_r( $this->reminders->reminders());
        print_r( $this->reminders->get_timecards());
    }
}