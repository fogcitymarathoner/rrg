<?php
/**
 * ChartableBehavior 
 *
 * A generic behavior that's function is to make any model "chartable". In most cases this behavior should be 
 * used in a dynamic way, IE adding the behavior in a controller action instead of having it "always on". 
 * For more info, read here : https://trac.cakephp.org/ticket/4010
 * 
 * The default setup for the behavior will create a graph with the Model::displayField as labels and assume
 * that the model has a field called "count" that it will use in the y-axis.
 * 
 * Example with configuration :
 * 
 * 		// We have a model User with fields 'browser' and 'marketshare' and wish to show this as a piechart:
 * 		$this->User->Behaviors->attach( 'Chartable' , array( 'numberField' => 'marketshare' , 'labelField' => 'browser' , 'type' => 'pie' ) );
 * 		$this->set('data', $this->User->find('all') );
 *
 * @copyright    Copyright (c) 2008, Alexander Morland
 * @version      1.2
 * @created      15/04/2008
 * @modifiedby   LastChangedBy: alkemann 
 * @lastmodified Date: 2008-04-21  
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 *
 */
class ChartableBehavior extends ModelBehavior 
{
    var $numberField = '';
    var $labelField = '';
    var $type = '';

    /**
     * Constructor that will set up the configurations
     *
     * @param Object $model referance to model, sent automatically
     * @param array $config Array with these options : 'numberField', 'labelField', 'type'
     */
	function setup(&$model, $config = array()) {
        $this->type =  ( isset($config['type']) ) ? $config['type'] : 'chart';
        $this->numberField = ( isset($config['numberField']) ) ? $config['numberField'] : 'count';
        $this->labelField = ( isset($config['labelField']) ) ? $config['labelField'] : $model->displayField;
	}
    
	/**
	 * As no assocations will be used by a chartable model, we set recursion to -1 for all finds.
	 *
	 * @param Object $model
	 * @param mixed $query
	 * @return mixed
	 * @todo Maybe add functionality for using belongsTo associated model fields 
	 */
	function beforeFind(&$model, $query) {
        $model->recursive = -1;
        return $query;
    }
    
    /**
     * The function here is to structure the found model data from a cake find into the data
     * structure that ise used by the OpenFlashChart vendor.
     *
     * @param Object $model
     * @param array $results
     * @param boolean $primary
     * @return array
     */
    function afterFind(&$model, $results, $primary = false) {
    
        $ret = array() ;
        if ($this->type == 'pie') {
            foreach ( $results as $id => $row ) {
                $ret[ $row [$model->alias][$this->labelField] ] = array(
                    'value' => $row[$model->alias][$this->numberField],
                );            
            }
        } else {
            foreach ( $results as $id => $row ) {
                 $ret['numbers'][$id] = $row [$model->alias][$this->numberField];
                 $ret['labels'][$id] = $row [$model->alias][$this->labelField];
            }    
        }
        return $ret;
    }    
      
}
?>