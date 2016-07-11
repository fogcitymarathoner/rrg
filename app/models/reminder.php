<?php
/*
App::import('Model', 'Employee');
App::import('Model', 'InvoicesItemsCommissionsItem');
*/

App::import('Component', 'Json');
App::import('Component', 'Commissions');
App::import('Component', 'Xml');
App::import('Component', 'HashUtils');
App::import('Component', 'Datasources');
App::import('Component', 'FixtureDirectories');
App::import('Component', 'InvoiceFunction');
App::import('Component', 'Json');
App::import('Component', 'FixtureDirectories');
App::import('Component', 'TokenHelper');

App::import('Model', 'Invoice');
App::import('Model', 'CommissionsReport');
App::import('Model', 'CommissionsReportsTag');
App::import('Model', 'Client');
class Reminder extends AppModel {

    var $name = 'Reminder';
    var $useTable = false;


    public function __construct() {

        $this->xmlComp = new XmlComponent;
        $this->dirComp = new FixtureDirectoriesComponent;

        $this->invoiceFunction = new InvoiceFunctionComponent;
        $this->hu = new HashUtilsComponent;
        $this->commsComp = new CommissionsComponent;
        $this->dsComp = new DatasourcesComponent;
        $this->xml_home = Configure::read('xml_home');
        $this->CommissionsReportsTag = new CommissionsReportsTag;
        $this->Invoice = new Invoice;

        $this->dirComp = new FixtureDirectoriesComponent;
        $this->jsonComp = new JsonComponent;
        $this->xml_home = Configure::read('xml_home');

        $this->Tk = new TokenHelperComponent;

        $this->ClientsContract = new ClientsContract;

        $this->CommissionsReport = new CommissionsReport;
        $this->Client = new Client;
        parent::__construct();


    }


}
