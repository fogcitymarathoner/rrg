<?php
class ExpensesCategoriesController extends AppController {

	var $name = 'ExpensesCategories';
	var $helpers = array('Html', 'Form');

        var $paginate = array(
                'limit' => 10,
                'contain' => array('ExpensesCategory')
                );

	function index() {
		$this->ExpensesCategory->recursive = 0;
		$this->set('expensesCategories', $this->paginate());
	}


	function view($id = null) {
        $this->layout = "default_bootstrap";
		if (!$id) {
			$this->Session->setFlash(__('Invalid ExpensesCategory.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->ExpensesCategory->recursive=0;
		$this->set('expensesCategory', $this->ExpensesCategory->read(null, $id));
		$this->set('expenses', $this->ExpensesCategory->Expense->find('all', array('conditions'=>array('category_id'=>$id),'order'=>array('date'=>'DESC',
                                                ), 'limit'=>'0, 1000')));

        $this->set('expensesCategories', $this->paginate());
	}

	function view_exp($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Expense.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('expense', $this->ExpensesCategory->Expense->read(null, $id));
	}
	function add() {
		if (!empty($this->data)) {
			$this->ExpensesCategory->create();
			if ($this->ExpensesCategory->save($this->data)) {
				$this->Session->setFlash(__('The ExpensesCategory has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ExpensesCategory could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ExpensesCategory', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->ExpensesCategory->save($this->data)) {
				$this->Session->setFlash(__('The ExpensesCategory has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ExpensesCategory could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ExpensesCategory->read(null, $id);
		}
	}

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for ExpensesCategory', true));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->ExpensesCategory->delete($id)) {
            $this->Session->setFlash(__('ExpensesCategory deleted', true));
            $this->redirect(array('action'=>'index'));
        }
    }
    function delete_exp($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Expenses', true));
            $this->redirect(array('action'=>'index'));
        }
        $exp = $this->ExpensesCategory->Expense->read(null, $id);
        if ($this->ExpensesCategory->Expense->delete($id)) {
            $this->Session->setFlash(__('Expenses deleted', true));
            $this->redirect(array('action'=>'view/'.$exp['Expense']['category_id']));
        }
    }
    function add_exp() {// $id is cat_id
        if (!empty($this->data)) {
            $this->data['Expense']['modified_date'] = date('Y-m-d H:m:s');

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
            $this->ExpensesCategory->Expense->create();
            if ($this->ExpensesCategory->Expense->save($this->data)) {
                $this->Session->setFlash(__('The Expense has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Expense could not be saved. Please, try again.', true));
            }
        }
        $expensesCategories = $this->ExpensesCategory->Expense->ExpensesCategory->find('list');
        $employees = $this->activeEmployees();
        $current_user =  $this->Auth->user();
        $current_employee_profile = $this->ExpensesCategory->Expense->Employee->Profile->find('all', array(
            'conditions' => array('user_id' => $current_user['User']['id'])
        ));
        $current_employee = $current_employee_profile[0]['Profile']['employee_id'];
        $this->data['Expense']['category_id']=$id;
        $this->set(compact('expensesCategories','employees','current_employee'));
    }
    function dup_exp($id = null) {//$id is exp_id
        if (!$id) {
            $this->Session->setFlash(__('Invalid ExpensesCategory.', true));
            $this->redirect(array('action'=>'index'));
        }
        $exp = $this->ExpensesCategory->Expense->read(null,$id);
        unset($exp['Expense']['id']);
        $exp['Expense']['date']=date('Y-m-d');
        $this->ExpensesCategory->Expense->create();
        $this->ExpensesCategory->Expense->save($exp);
        $newexpID = $this->ExpensesCategory->Expense->getLastInsertID();
        $this->redirect(array('controller'=>'expenses','action'=>'edit_exp',$newexpID));
    }
}
?>
