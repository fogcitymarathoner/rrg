<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 5/25/14
 * Time: 11:02 AM
 */

class DatasourcesComponent
{

    var $xml_home;
    var $transdir;
    var $inv_comm_item_dir;

    public function __construct() {
        $this->xml_home = Configure::read('xml_home');
        $this->transdir = $this->xml_home.'transactions/';
        $this->invoicedir = $this->transdir.'invoices/';
        $this->inv_comm_item_dir = $this->transdir.'invoices/invoice_items/commissions_items/';
    }
    public function inv_comm_item_filename($id)
    {
        return $this->inv_comm_item_dir.str_pad((string)$id, 5, "0", STR_PAD_LEFT).'.xml';
    }
    public function comm_payment_filename($id)
    {
        return $this->transdir.'commissions_payments/'.str_pad((string)$id, 5, "0", STR_PAD_LEFT).'.xml';
    }
    public function invoice_filename($id)
    {
        return $this->invoicedir.str_pad((string)$id, 5, "0", STR_PAD_LEFT).'.xml';
    }

    public function inv_comm_item_files()
    {
        /*
         * returns a list of archived commissions items
         */
        return (scandir ($this->inv_comm_item_dir));
    }

    public function client_open_invoices_file($id)
    {
        $openinvoicedir = $this->xml_home.'clients/open_invoices/';
        return ($openinvoicedir.str_pad((string)$id, 5, "0", STR_PAD_LEFT).'.xml');
    }

    public function client_statement_file($id){
        return $this->xml_home.'clients/statements/'.str_pad((string)$id, 5, "0", STR_PAD_LEFT).'.xml';
    }
}