<?php
// vendors/shells/demo.php
//
// Run in cron job
// generates employee/commissions report tags for every employee every month
class CacheRemindersShell extends Shell {
	#var $uses = array('Employee');
	
    function initialize() {
        // empty
    }

    function main() {

        App::import('Model', 'cache/reminder');
        $reminderModel = new ReminderCache;

        $reminderModel->cache_reminders();

        exit;
    }

    function help() {
        $this->out('Here comes the help message');
    }
}
