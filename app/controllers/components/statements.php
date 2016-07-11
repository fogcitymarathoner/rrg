<?php
/**

 * StatementsComponent - reads xml files from the cache client overnight routine
 *
 */

//require_once("XML/Unserializer.php");
require_once dirname(__FILE__) . '/../../XML/Unserializer.php';
App::import('Component', 'Datasources');
App::import('Component', 'Json');
class StatementsComponent extends Object {
    var $xml_home;
    var $transdir;
    var $serializer;

    public function __construct() {
        $this->xml_home = Configure::read('xml_home');
        $this->transdir = $this->xml_home.'transactions/';
        $this->serializer = &new XML_Unserializer();
        $this->dsComp = new DatasourcesComponent;
    }
    public function statement_fixture_generation_date($id)
    {
        if(filesize($this->dsComp->client_statement_file($id)))
        {
            $domSrc = file_get_contents($this->dsComp->client_statement_file($id));
            $dom = new DomDocument();
            $dom->loadXML( $domSrc );
            // load up generated date
            $date = $dom->getElementsByTagName('date_generated');
            $first_date = $date->item(0);
            //Return the links
            return $first_date->nodeValue;
        }
        else
        {
            print 'XML file is empty.';
        }
        return '';
    }
    public function client_fixture_file_exists($id){
        $statementdir = $this->xml_home.'clients/statements/';
        if(file_exists($statementdir.str_pad((string)$id, 5, "0", STR_PAD_LEFT).'.xml'))
        {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    private function get_transaction_statement_array($filename)
    {
        $payload = array();
        $payload['Invoice'] = array();
        $payload['Check'] = array();
        $fsize = filesize($filename);
        if($fsize)
        {
            $domSrc = file_get_contents($filename);
            $dom = new DomDocument('1.0');
            $dom->loadXML( $domSrc );
            // load up generated date
            $date = $dom->getElementsByTagName('date_generated');
            $dateO = $date->item(0);
            $payload['date_generated'] = $dateO->nodeValue;
            // load up invoices
            $invs = $dom->getElementsByTagName('invoice');
            foreach ($invs as $inv) {
                $payload['Invoice'][] = $inv->nodeValue;
            }
            // losd up checks
            $invs = $dom->getElementsByTagName('check');
            foreach ($invs as $inv) {
                $payload['Check'][] = $inv->nodeValue;
            }

            //Return the links
            return $payload;
        }
        else
        {
            print 'XML file is empty.';
        }
        return $payload;
    }
    /*
     * deconstructs fixtures into reports
     */
    private function statement($invoices, $order= SORT_ASC)
    {
        $statement = Array();
        if(isset($invoices['Check']))
        {
            foreach ($invoices['Check'] as $check)
            {
                $fixfile = $this->transdir.'checks/'.str_pad((string)$check, 5, "0", STR_PAD_LEFT).'.xml';
                if(file_exists ($fixfile))
                {
                    $f = fopen($fixfile,'r');
                    $fsize = filesize($fixfile);
                    $doc = fread($f,$fsize);
                    fclose($f);
                    $this->serializer->unserialize($doc);
                    $UnSerializedcheck = $this->serializer->getUnserializedData ( );

                    $statement [] = array(
                        $UnSerializedcheck['date'],
                        'check #'.$UnSerializedcheck['number'],
                        (-1)*$UnSerializedcheck['amount'],
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                    );
                } else {
                    print 'cannot open fixfile: '.$fixfile.' in private function Statement top';
                    exit;
                }
            }
        }
        if(isset($invoices['Invoice']))
        {
            foreach ($invoices['Invoice'] as $invoice)
            {
                $fixfile = $this->transdir.'invoices/'.str_pad((string)$invoice, 5, "0", STR_PAD_LEFT).'.xml';

                if ($invoice != 'Array') {
                    if (file_exists($fixfile)) {
                        $f = fopen($fixfile, 'r');
                        $fsize = filesize($fixfile);

                        $doc = fread($f, $fsize);
                        fclose($f);
                        $this->serializer->unserialize($doc);
                        $UnSerializedinvoices = $this->serializer->getUnserializedData();
                        $statement [] = array(
                            $UnSerializedinvoices['date'],
                            'invoice #' . $UnSerializedinvoices['id'],
                            $UnSerializedinvoices['amount'],
                            $UnSerializedinvoices['terms'],
                            $UnSerializedinvoices['cleared'],
                            $UnSerializedinvoices['duedate'],
                            $UnSerializedinvoices['cleared_date'],
                            $UnSerializedinvoices['voided'],
                            $UnSerializedinvoices['token'],
                            $UnSerializedinvoices['pdf_file_name'],
                            $UnSerializedinvoices['period_start'],
                            $UnSerializedinvoices['period_end'],
                            $UnSerializedinvoices['employee'],
                        );
                    } else {
                        print 'cannot open fixfile: ' . $fixfile . ' in private function Statement bottom';
                        exit;
                    }
                }
            }

        }
        if(!empty($statement))
        {
            foreach($statement as $c=>$key) {
                $sort_date[] = $key[0];
                $sort_description[] = $key[1];
                $sort_amount[] = $key[2];
                $sort_cleared[] = $key[3];
                $sort_voided[] = $key[4];
            }
            array_multisort($sort_date, $order, $statement);
        }
        return ($statement);
    }
    public function generate_statement($id){

        return $this->statement(
            $this->get_transaction_statement_array(
                $this->dsComp->client_statement_file($id)));
    }
    public function generate_opens_statement($id, $fixfile){

        return $this->statement(
            $this->get_transaction_statement_array(
                $fixfile));
    }
}
?>
