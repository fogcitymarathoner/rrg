<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 4/3/14
 * Time: 11:08 AM
 */

App::import('Model', 'commissions/employee');
App::import('Model', 'Employee');

App::import('Model', 'cache/employee');
App::import('Model', 'cache/invoice');
App::import('Model', 'cache/reminder');

App::import('Model', 'cache/client');


App::import('Model', 'cache/clients_check');
class SettingsController extends AppController {
    var $uses = array();
    var $name = 'Settings';
    var $paginate = array(
        'limit' => 10,
        'order' => 'date desc',
        'contain' => array('Post'),
    );


    public function __construct() {

        $this->empModel = new Employee;
        $this->empCommsModel = new EmployeeCommissions;
        $this->InvoiceCache = new Invoice;

        $this->reminderModel = new ReminderCache;

        $this->clientCacheModel = new ClientCache;


        $this->checksModel = new ClientsCheckCache;
        parent::__construct();
    }
    public function index($page=1) {
        $this->set('database', get_class_vars('DATABASE_CONFIG'));
        $this->set('xml_home', Configure::read('xml_home'));
    }


}