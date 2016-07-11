<?php
class ContractsItemsController extends AppController {

	var $name = 'ContractsItems';
	/* called from radio buttons in client view */	
	function soap_activeinactive($id,$updown)
	{
        $this->layout = Null;
        $this->data['ContractsItem']['id']=$id;
        $this->data['ContractsItem']['active']=$updown;
         if ($this->ContractsItem->save($this->data)) {
             $this->render('/elements/empty_soap_return');;
         } else {
             ;
         }
	}


	function reorder_items()
	{
		$debug = 0;
		if ($debug==1)
		{ 
			$handle = fopen("/tmp/log.txt", "w+");
			$x =  print_r ($this->params['form']['itemtable'],TRUE);
			fwrite($handle,'line 25');
			fwrite($handle,$x) ;
		}
		$i = 0;
		$this->data['ContractsItems'] = array();
		foreach( $this->params['form']['itemtable'] as $item):
			if ($debug==1)
			{
				//write($handle,$z) ;
				fwrite($handle,'line 34');
				fwrite($handle,$item) ;
			}
			$this->data['ContractsItem'][$i]['id'] = $item;
			$this->data['ContractsItem'][$i]['ordering'] = ($i+1)*10;
			$i++;
		endforeach;
		if ($debug==1)
		{
			fwrite($handle,'line 43');
			$x =  print_r ($this->data,TRUE);
			fwrite($handle,$x) ;
		}
		$saveitem = array();
		foreach( $this->data['ContractsItem'] as $item):
			$saveitem['ContractsItem'] = $item;
			if ($debug==1)
			{
				$z = print_r ($saveitem,TRUE);
				fwrite($handle,'line 47');
				fwrite($handle,$z) ;
			}
			if ($saveitem['ContractsItem']['id'] != NULL)
				$this->ContractsItem->save($saveitem);
				if ($debug==1)
				{
					//write($handle,$z) ;
					fwrite($handle,'SAVED line 55');
					fwrite($handle,$z) ;
				}
		endforeach;
		if ($debug==1)
		{
			$y =print_r ($this->data,TRUE);
		
			fwrite($handle,'line 55');
			fwrite($handle,$x) ;
			fwrite($handle,$y) ;
			fwrite($handle,var_dump($this->params)) ;
			fclose($handle); //exit;
		}
	}

    function beforeFilter(){
        parent::beforeFilter();
        $this->page_title = 'Clients Page';
        if(isset($this->Security) && $this->RequestHandler->isAjax() && in_array($this->action ,array(
            'soap_activeinactive',
            'reorder_items',
        ))){
            Configure::write('debug', 2);
            $this->Security->enabled = false;
        }

        // Ajax security holes
        if(isset($this->Security) &&  in_array($this->action ,array(
        ))){
            Configure::write('debug',0);
            $this->Security->enabled = false;
        }
    }


}
?>