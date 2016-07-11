<?php
//require_once("XML/Serializer.php");

require_once dirname(__FILE__) . '/../XML/Serializer.php';
App::import('Component', 'HashUtils');
class CommissionsReportsTag extends AppModel {

	var $name = 'CommissionsReportsTag';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Employee' => array(
			'className' => 'Employee',
			'foreignKey' => 'employee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	var $hasMany = array(
			'InvoicesItemsCommissionsItem' => array('className' => 'InvoicesItemsCommissionsItem',
								'foreignKey' => 'commissions_reports_tag_id',
								'dependent' => true,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			),
			'CommissionsPayment' => array('className' => 'CommissionsPayment',
								'foreignKey' => 'commissions_reports_tag_id',
								'dependent' => true,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			),
			'Note' => array('className' => 'Note',
								'foreignKey' => 'commissions_reports_tag_id',
								'dependent' => true,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			),
			'NotesPayment' => array('className' => 'NotesPayment',
								'foreignKey' => 'commissions_reports_tag_id',
								'dependent' => true,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			),
	);
    public function __construct()
    {
        $options = array(
            XML_SERIALIZER_OPTION_INDENT        => '    ',
            XML_SERIALIZER_OPTION_RETURN_RESULT => true
        );
        $this->serializer = &new XML_Serializer($options);

        $this->xml_home = Configure::read('xml_home');
        $this->comtagdir = $this->xml_home.'commissions_reports_tags/';

        $this->hu = new HashUtilsComponent;

        parent::__construct();
    }
    function shell_generate_tags()
   	{
        /* generate commissions employee-tag in db
        Is this necessary?
        */
   		foreach ($this->Employee->find('all',array('conditions'=>array('active'=>1))) as $employee )
   		{
               if($this->Employee->issalesforce($employee['Employee']['id']))
               {
                    echo "Generate the tags for ".$employee['Employee']['firstname'].' '.$employee['Employee']['lastname']."\n";
   			        $this->generate_tags_employee($employee);
               }

   		}
   	}

	// handles both commissions and notes
	function generate_tags_employee($employee)
	{
			$employeestart=mktime(0,0,0, date("m",strtotime($employee['Employee']['startdate'])),date("d",strtotime($employee['Employee']['startdate'])),date("Y",strtotime($employee['Employee']['startdate'])));
			if(!isset($employee['Employee']['enddate']) || !mktime(0,0,0, date("m",strtotime($employee['Employee']['enddate'])),date("d",strtotime($employee['Employee']['enddate'])),date("Y",strtotime($employee['Employee']['enddate']))))
			{
				$employeeend=mktime(0,0,0, 0,0,date("Y")+20);
			}
			else
			{
				$employeeend=mktime(0,0,0, date("m",strtotime($employee['Employee']['enddate'])),date("d",strtotime($employee['Employee']['enddate'])),date("Y",strtotime($employee['Employee']['enddate'])));
			}


            foreach($this->hu->since_epoch_list() as $report  )
			{
				$periodend = mktime(0,0,0, date("m",strtotime($report['CommissionsReport']['end'])),date("d",strtotime($report['CommissionsReport']['end'])),date("Y",strtotime($report['CommissionsReport']['end'])));
				$periodstart =mktime(0,0,0, date("m",strtotime($report['CommissionsReport']['start'])),date("d",strtotime($report['CommissionsReport']['start'])),date("Y",strtotime($report['CommissionsReport']['start'])));
				if(!$this->find('count',array('conditions'=>array('employee_id'=>$employee['Employee']['id'],
												'commissions_report_id'=>$report['CommissionsReport']['id']))))
				{
					if(
						(
						$employeestart						
						<=
						$periodend						
						
						)
						&&
						
						(
						$employeeend						
						>=
						$periodstart
						)
						
					)
					{

						$tag['CommissionsReportsTag']['commissions_report_id']=$report;


						$tag['CommissionsReportsTag']['employee_id']=$employee['Employee']['id'];
						$tag['CommissionsReportsTag']['name']=$employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];
						if(!$this->find('count',array('conditions'=>
											array('CommissionsReportsTag.employee_id'=>$employee['Employee']['id'],
											'commissions_report_id'=>$report['CommissionsReport']['id']))))
						{
							$this->create();
                            //debug($tag);
							$this->save($tag);
						}
					}
				}				
			}
	}
	function shell_tagID($employee,$report_id) {
        /*
         * creates commissions reports tag if one doesn't exist
         * returns an employees commissions report tag based on month tag id and employee_id
         */
		$report =  $this->find('first',array('conditions'=>array('employee_id'=>$employee,'commissions_report_id >='=>$report_id  )));

        if( !$report)
        {
            $data = array('CommissionsReportsTag' => array('employee_id'=>$employee, 'commissions_report_id'=>$report_id));

            $this->save($data);

            $report =  $this->find('first',array('conditions'=>array('employee_id'=>$employee,'commissions_report_id >='=>$report_id  )));
        }

		return ( $report['CommissionsReportsTag']['id']  );
	}
    // called by ajax, run quiet
    function cache_tag($id) {
        //$report = $this->read(null, $id);
        $report = array();
        /*
         * saves xml in both db and disk
         * deletes invoice commissions items!!!
         */
        $this->recursive = 1;
        $this->unbindModel(array('hasMany' => array('InvoicesItemsCommissionsItem',),),false);
        $tagdb = $this->read(null, $id);

        $report['tag']['CommissionsReportsTag']=$tagdb['CommissionsReportsTag'];
        $report['tag']['CommissionsReport']=$tagdb['CommissionsReport'];
        $report['tag']['Employee']=$tagdb['Employee'];

        $this->recursive = 2;
        $this->bindModel(array('hasMany' => array('InvoicesItemsCommissionsItem',),),false);
        $this->bindModel(array('belongsTo' => array('Employee',),),false);
        $items = $this->InvoicesItemsCommissionsItem->find('all',
            array('conditions'=>array('commissions_reports_tag_id'=>$id),
                'order'=>array('InvoicesItemsCommissionsItem.description ASC','InvoicesItemsCommissionsItem.date ASC')));
        $count = 0;
        foreach($items as $item)
        {
            $this->InvoicesItemsCommissionsItem->InvoicesItem->Invoice->recursive=2;
            $invoice = $this->InvoicesItemsCommissionsItem->InvoicesItem->Invoice->find('first',
                array('conditions'=>array('Invoice.id'=>$item['InvoicesItem']['invoice_id'])));
            //debug($invoice);exit;
            $items[$count]['InvoicesItemsCommissionsItem']['Invoice']=$invoice['Invoice'];
            $items[$count]['InvoicesItemsCommissionsItem']['Worker']=$invoice['ClientsContract']['Employee'];
            $count++;
        }
        $report['items']=$items;
        $this->CommissionsPayment->unbindModel(array('belongsTo' => array('Employee',),),false);
        $payments = $this->CommissionsPayment->find('all',
            array('conditions'=>array('CommissionsPayment.commissions_reports_tag_id'=>$id),
                'order'=>array('CommissionsPayment.date ASC')));


        $report['payments']=$payments;
        /*
         *
         */
        $fn = $this->comtagdir.str_pad((string)$id, 5, "0", STR_PAD_LEFT).'.xml';
        //
        $xml_doc = $this->serializer->serialize($report);
        $report['CommissionsReportsTag']['release'] = 1;
        $report['CommissionsReportsTag']['cleared'] = 1;
        $report['CommissionsReportsTag']['xml_doc'] = $xml_doc;
        $this->save($report);
        $f = fopen($fn,'w');
        fwrite($f, $xml_doc);
        fclose($f);
        // delete invoice comm items
        $this->InvoicesItemsCommissionsItem->deleteAll(
            array('InvoicesItemsCommissionsItem.commissions_reports_tag_id'=>$id));

    }

    function clear_commissions_tags_release()
    {
        $uncleared = $this->find('all',array('conditions'=>array('cleared'=>0)));
        foreach($uncleared as $tag)
        {
            $unclearedcount = 0;
            foreach($tag['InvoicesItemsCommissionsItem'] as $i)
            {
                if(!$i['cleared'])
                {
                    $unclearedcount++;
                }
            }
            if(!$unclearedcount)
            {
                $tag['CommissionsReportsTag']['cleared']=1;
                $this->save($tag);
            }
        }
    }
    public function get_hash_filename($id)
    {
        $rpt = $this->read(Null, $id);
        return  $this->hu->id_comperiod_hash($rpt['CommissionsReportsTag']['employee_id'], $rpt['CommissionsReportsTag']['commissions_report_id']);

    }
    public function get_employee_report_summaries($id)
    {
        $this->recursive = 0;
        return $this->find('all', array(
                'conditions'=>array('employee_id'=>$id),
                'fields'=>array(
                    'id',
                    'commissions_report_id',
                    'employee_id',
                    'name',
                    'comm_balance',
                    'note_balance',
                    'amount',
                    'cleared',
                    'release'),
                'order'=>array('commissions_report_id ASC')
            )
        );
    }
}
?>