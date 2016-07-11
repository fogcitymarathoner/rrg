<?php

App::import('Component', 'Xml');
class ExpensesController extends AppController {

	var $name = 'Expenses';
	var $helpers = array('Html', 'Form');

    var $paginate = array(
                'limit' => 100,
                'contain' => array('Expense'),
                'order' => array('Expense.date'=>'DESC')
    );
    function index() {

        Configure::write('debug', 2);
        $this->Expense->recursive = 0;
        $this->Expense->ExpensesCategory->recursive = 0;
        $this->layout = "default_bootstrap";
        $user = $this->Auth->user();
        $profile = $this->Expense->Employee->Profile->find('all',array(
                'Profile.user_id'=>$user['User']['id'],
            )
        );
        $expense_cats_indexed = array();
        $expense_cats = $this->Expense->ExpensesCategory->find('all');

        $expenses = $this->Expense->find('all',
            array('conditions'=>
                array(
                    'date >='=> date('Y-m-d', strtotime('-120 days')),
                    'employee_id' => $profile[0]['Profile']['employee_id'] ),
                    'order'=>'date desc',
                    'limit' =>'0, 300'
                )
        );
        $count = 0;
        foreach($expenses as $expense)
        {
            foreach($expense_cats as $cat){
                if( $cat['ExpensesCategory']['id'] == $expense['Expense']['category_id']){
                    $name = $cat['ExpensesCategory']['id'];
                    break;
                }
            }
            $expenses[$count]['Expense']['category'] = $name;
            $count++;
        }

        $this->set('expenses', $expenses);
        $this->set('expenses_categories',$expense_cats);
    }
    function m_index() {
        $this->layout = "default_jqmobile";
        $this->Expense->recursive = 0;
        $user = $this->Auth->user();
        $profile = $this->Expense->Employee->Profile->find('all',array(
                'user_id'=>$user['User']['id'],

            )

        );
        $expense_cats = $this->Expense->ExpensesCategory->find('list');
        $expenses = $this->Expense->find('all',
            array('conditions'=>
            array('employee_id' =>
            $profile[0]['Profile']['employee_id'] ),
                'order'=>'date desc',
                'limit' =>'0, 30'
            )

        );

        $count = 0;
        foreach($expenses as $expense)
        {

            $expenses[$count]['Expense']['category']=$expense_cats[$expense['Expense']['category_id']];
            $count++;
        }

        $this->set('expenses', $expenses);
        $this->set('expenses_categories',$expense_cats);
    }

    function m_index_categories() {
        $this->layout = "default_jqmobile";
        $this->Expense->ExpensesCategory->recursive = 0;
        $this->set('expensesCategories', $this->Expense->ExpensesCategory->find('all',null));
    }

    function m_view_expenseCategory($id = null) {
        $this->layout = "default_jqmobile";
        if (!$id) {
            $this->Session->setFlash(__('Invalid ExpensesCategory.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Expense->ExpensesCategory->recursive=0;
        $this->set('expensesCategory', $this->Expense->ExpensesCategory->read(null, $id));
        $this->set('expenses', $this->Expense->ExpensesCategory->Expense->find('all', array('conditions'=>array('category_id'=>$id),'order'=>array('date'=>'DESC',
        ), 'limit'=>'0, 30')));
    }
	function view_expense($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Expense.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('expense', $this->Expense->read(null, $id));
	}
    function m_view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Expense.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('expense', $this->Expense->read(null, $id));
        $this->layout = "default_jqmobile_partial";
    }
	function activeEmployees()
	{
		$i = 0;
		$employeesdb = $this->Expense->Employee->find('all',array('conditions'=>array('active'=>1)));
		$employees= array();
		foreach ($employeesdb as $employee): 
			$employees[$employee['Employee']['id']] = $employee['Employee']['firstname'].' '.$employee['Employee']['lastname'];
		endforeach;
		return $employees;
	}
	function add_expense() {
        $current_user =  $this->Auth->user();
		if (!empty($this->data)) {

            Configure::write('debug',0);

            /* set mods */
            $this->data['Expense']['created_user'] = $current_user['User']['id'];
            $this->data['Expense']['created_date']= date('Y-m-d H:i:s');

            $this->data['Expense']['modified_user'] = $current_user['User']['id'];
            $this->data['Expense']['modified_date']= date('Y-m-d H:i:s');
            if(isset($this->data['Expense']['date']) && $this->data['Expense']['date'] != Null)
            {

                if(substr_count($this->data['Expense']['date'],'/'))
                {
                    $dateA = explode('/',$this->data['Expense']['date']);
                    $this->data['Expense']['date'] =$dateA[2].'-'.$dateA[0].'-'.$dateA[1];
                }
                if(substr_count($this->data['Expense']['date'],'-'))
                {
                    $dateA = explode('-',$this->data['Expense']['date']);
                    $this->data['Expense']['date'] =$dateA[0].'-'.$dateA[1].'-'.$dateA[2];
                }
            }
			$this->Expense->create();
			if ($this->Expense->save($this->data)) { //debug($this->data);exit;
				$this->Session->setFlash(__('The Expense has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Expense could not be saved. Please, try again.', true));
			}
		}
		$expensesCategories = $this->Expense->ExpensesCategory->find('list');
		$employees = $this->activeEmployees();
        $current_user =  $this->Auth->user();
        $current_employee_profile = $this->Expense->Employee->Profile->find('all', array(
                                    'conditions' => array('user_id' => $current_user['User']['id'])
        ));
        //debug($current_employee_profile); exit;
        $current_employee = $current_employee_profile[0]['Profile']['employee_id'];
		$this->set(compact('expensesCategories','employees','current_employee'));
	}

    function m_add() {
        $current_user =  $this->Auth->user();
        if (!empty($this->data)) {


            $this->data['Expense']['modified_date'] = date('Y-m-d H:m:s');

            if(isset($this->params['form']['year'])&&isset($this->params['form']['month'])&&isset($this->params['form']['day']))
                $this->data['Expense']['date']=
                    $this->params['form']['year'].'-'.
                        str_pad ($this->params['form']['month'],2,'0',STR_PAD_LEFT) .'-'.
                        str_pad ($this->params['form']['day'],2,'0',STR_PAD_LEFT);

            $this->Expense->create();

            /* set mods */
            $this->data['Expense']['created_user'] = $current_user['User']['id'];
            $this->data['Expense']['created_date']= date('Y-m-d H:i:s');

            $this->data['Expense']['modified_user'] = $current_user['User']['id'];
            $this->data['Expense']['modified_date']= date('Y-m-d H:i:s');
            if ($this->Expense->save($this->data)) { //debug($this->data);exit;
                $this->Session->setFlash(__('The Expense has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Expense could not be saved. Please, try again.', true));
            }
        }

        $expensesCategories = $this->Expense->ExpensesCategory->find('list');
        $employees = $this->activeEmployees();
        $current_user =  $this->Auth->user();
        $current_employee_profile = $this->Expense->Employee->Profile->find('all', array(
            'conditions' => array('user_id' => $current_user['User']['id'])
        ));

        $this->layout = "default_jqmobile_partial";
        $current_employee = $current_employee_profile[0]['Profile']['employee_id'];
        $this->set(compact('expensesCategories','employees','current_employee'));
    }
    /*
     * Edit expense in category
     */

    function edit_exp($id = null) {
        $current_user =  $this->Auth->user();
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Expense', true));
            $this->redirect(array('controller'=>'expenses_categories','action'=>'view', 'id'=>$this->data['Expense']['category_id']));
        }
        if (!empty($this->data)) {

            /* set mods */
            $this->data['Expense']['modified_user'] = $current_user['User']['id'];
            $this->data['Expense']['modified_date']= date('Y-m-d H:i:s');
            if ($this->Expense->save($this->data)) {
                $this->Session->setFlash(__('The Expense has been saved', true));
                $this->redirect(array('controller'=>'expenses_categories','action'=>'view/'.$this->data['Expense']['category_id']));
            } else {
                $this->Session->setFlash(__('The Expense could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Expense->read(null, $id);
        }
        $expensesCategories = $this->Expense->ExpensesCategory->find('list');
        $current_user =  $this->Auth->user();
        $current_employee_profile = $this->Expense->Employee->Profile->find('all', array(
            'conditions' => array('user_id' => $current_user['User']['id'])
        ));
        $current_employee = $current_employee_profile[0]['Profile']['employee_id'];

        //$employees = $this->Expense->Employee->activeEmployees_cache();

        $xmlComp = new XmlComponent;
        $employees = $xmlComp->employee_dropdown() ;

        $this->set(compact('expensesCategories','employees','current_employee'));
    }
	function edit_expense($id = null) {

        $current_user =  $this->Auth->user();
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Expense', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {

            $expsave = array();
            $clsave['Expense'] = $exp['Expense'];

            /* set mods */
            $this->data['Expense']['modified_user'] = $current_user['User']['id'];
            $this->data['Expense']['modified_date']= date('Y-m-d H:i:s');

			if ($this->Expense->save($this->data)) {
				$this->Session->setFlash(__('The Expense has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Expense could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Expense->read(null, $id);
		}
		$expensesCategories = $this->Expense->ExpensesCategory->find('list');

        $current_employee_profile = $this->Expense->Employee->Profile->find('all', array(
                                    'conditions' => array('user_id' => $current_user['User']['id'])
        ));
        $current_employee = $current_employee_profile[0]['Profile']['employee_id'];

        $xmlComp = new XmlComponent;
        $employees = $xmlComp->employee_dropdown() ;
		$this->set(compact('expensesCategories','employees','current_employee'));
	}

    function m_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Expense', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            /* set mods */
            $this->data['Expense']['modified_user'] = $current_user['User']['id'];
            $this->data['Expense']['modified_date']= date('Y-m-d H:i:s');
            if ($this->Expense->save($this->data)) {
                $this->Session->setFlash(__('The Expense has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Expense could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Expense->read(null, $id);
        }
        $expensesCategories = $this->Expense->ExpensesCategory->find('list');

        $current_user =  $this->Auth->user();
        $current_employee_profile = $this->Expense->Employee->Profile->find('all', array(
            'conditions' => array('user_id' => $current_user['User']['id'])
        ));
        $current_employee = $current_employee_profile[0]['Profile']['employee_id'];
        $employees = $this->activeEmployees();
        $this->set(compact('expensesCategories','employees','current_employee'));
        $this->layout = "default_jqmobile_partial";
    }
    function select_category_year() {
        if (!empty($this->data)) {
            if ($this->data['Expense']['category_id'] and $this->data['Expense']['year']) {
                $this->redirect(array('action'=>'report_category_year','category'=>$this->data['Expense']['category_id'], 'year'=>$this->data['Expense']['year']));
            } else {
                $this->Session->setFlash(__('Please specify both expense and year.', true));
            }
        }
        $years = array('2002'=>'2002',
            '2003'=>'2003',
            '2004'=>'2004',
            '2005'=>'2005',
            '2006'=>'2006',
            '2007'=>'2007',
            '2008'=>'2008',
            '2009'=>'2009',
            '2010'=>'2010',
            '2011'=>'2011',
            '2012'=>'2012',
            '2013'=>'2013',
            '2014'=>'2014',
        );

        $expensesCategories = $this->Expense->ExpensesCategory->find('list');
        $this->set(compact('expensesCategories','years'));
    }
    function select_year() {

        Configure::write('debug', 0);
        if (!empty($this->data)) {
            if ($this->data['Expense']['year']) {
                $this->redirect(array('action'=>'report_year', 'year'=>$this->data['Expense']['year']));
            } else {
                $this->Session->setFlash(__('Please specify both expense and year.', true));
            }
        }
        $years = array('2002'=>'2002',
            '2003'=>'2003',
            '2004'=>'2004',
            '2005'=>'2005',
            '2006'=>'2006',
            '2007'=>'2007',
            '2008'=>'2008',
            '2009'=>'2009',
            '2010'=>'2010',
            '2011'=>'2011',
            '2012'=>'2012',
            '2013'=>'2013',
            '2014'=>'2014',
        );


        $this->set(compact('expensesCategories','years'));
    }
    function report_category_year() {
        $category=$this->params['named']['category'];
        $year=$this->params['named']['year'];
        $begindate = $year.'-01-01';
        $enddate = $year.'-12-31';
        $this->Expense->recursive = 0;
        $expenses = $this->Expense->find('all', array(
                'conditions'=>array(
                    'date BETWEEN ? AND ?' => array($begindate, $enddate),

                    'category_id'=>$category,

                ),
                'fields'=>array(
                    'Expense.id',
                    'Expense.description',
                    'Expense.date',
                    'Expense.amount',
                    'Expense.notes',
                    'Employee.firstname',
                    'Employee.lastname',
                ),
                'order'=>array('Expense.date ASC'),
            )
        );
        $annualtotal = 0;
        foreach ($expenses as $expense):
            $annualtotal += $expense['Expense']['amount'];
        endforeach;

        $this->Expense->ExpensesCategory->unbindModel(array('hasMany' => array('Expense'),),false);
        $expensecategory = $this->Expense->ExpensesCategory->find('all', array(
            'conditions'=>array(
                'id'=>$category)
        ));

        $this->set('expenses', $expenses);
        $this->set('expensecategory', $expensecategory);
        $this->set('year', $year);
        $this->set('annualtotal', $annualtotal);

        $this->layout='default_nomenu';

    }

    function report_year() {

        Configure::write('debug', 0);
        $year=$this->params['named']['year'];
        $begindate = $year.'-01-01';
        $enddate = $year.'-12-31';
        $user = $this->Auth->user();
        $profile = $this->Expense->Employee->Profile->find('all', array('conditions'=>array('user_id'=>$user['User']['id'])));

        $this->Expense->recursive = 0;
        $expenses = $this->Expense->find('all', array(
                'conditions'=>array(
                    'date BETWEEN ? AND ?' => array($begindate, $enddate),

                    'employee_id'=>$profile[0]['Profile']['employee_id'],

                ),
                'fields'=>array(
                    'Expense.id',
                    'Expense.description',
                    'Expense.date',
                    'sum(Expense.amount) as amount',
                    'Expense.notes',
                    'Employee.firstname',
                    'Employee.lastname',
                    'ExpensesCategory.name',
                ),
                'order'=>array('Expense.date ASC'),

                'group'=>array('ExpensesCategory.name'),
            )
        );
        $annualtotal = 0;
        foreach ($expenses as $expense):
            $annualtotal += $expense[0]['amount'];
        endforeach;

        $this->set('expenses', $expenses);
        $this->set('year', $year);
        $this->set('annualtotal', $annualtotal);

        if (isset($this->params['named']['print']))

            $this->layout='print';

    }

    function delete_expense($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Expense', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Expense->delete($id)) {
			$this->Session->setFlash(__('Expense deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


    function m_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Expense', true));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->Expense->delete($id)) {
            $this->Session->setFlash(__('Expense deleted', true));
            $this->redirect(array('prefix'=>'m','action'=>'index'));
        }
    }
	function search() {
	// Setup dropdowns in search action/view

		$expensesCategories = $this->Expense->ExpensesCategory->find('list');

		$this->set(compact('expensesCategories'));
	}


    function m_dup($id = null) {

        $current_user =  $this->Auth->user();
        if (!$id) {
            $this->Session->setFlash(__('Invalid ExpensesCategory.', true));
            $this->redirect(array('action'=>'index'));
        }
        $exp = $this->Expense->read(null,$id);
        unset($exp['Expense']['id']);

        /* set mods */
        $this->data['Expense']['created_user'] = $current_user['User']['id'];
        $this->data['Expense']['created_date']= date('Y-m-d H:i:s');

        $this->data['Expense']['modified_user'] = $current_user['User']['id'];
        $this->data['Expense']['modified_date']= date('Y-m-d H:i:s');
        $exp['Expense']['date']=date('Y-m-d');
        $this->Expense->create();
        $this->Expense->save($exp);
        $newexpID = $this->Expense->getLastInsertID();
        $this->redirect(array('prefix'=>'m','action'=>'edit',$newexpID));
    }
    function beforeFilter(){
        parent::beforeFilter();
        // Ajax security holes
        if(isset($this->Security) &&  in_array($this->action ,array(
            'edit_expense',
            'edit_exp',
            'add_expense',
        ))){
            Configure::write('debug',0);
            $this->Security->enabled = false;
            $this->Security->validatePost = false;
        }
    }
}
?>
