<?php
// vendors/shells/demo.php
// Run in Cron Job
// Generates All the monthly report numbers from epoch
class GenerateRemindersShell extends Shell {
	var $uses = array('Employee');
	
    function initialize() {
        // empty
    }

    function main() {


        App::import('Model', 'cache/reminder');

        $ReminderCache = new ReminderCache;

        $ReminderCache->generate_reminders();
    	exit;
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
