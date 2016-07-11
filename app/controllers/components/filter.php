<?php

/**

 * Filter component
 * Benefits:
 * 1. Keep the filter criteria in the Session
 * 2. Give ability to customize the search wrapper of the field types

 **

 * @author  Nik Chankov

 * @website http://nik.chankov.net

 * @version 1.0.0

 *

 */


class FilterComponent extends Object {
    /**
     * fields which will replace the regular syntax in where i.e. field = 'value'
     */
    var $fieldFormatting    = array(
                    "string"=>"LIKE %s%%",
                    "date"=>"'%s'"
                    );
    /**
     * Function which will change controller->data array
     *
     * @param object $controller the class of the controller which call this component
     * @access public
     */
function process($controller){
        $this->_prepareFilter($controller);
        $ret = array();
        if(isset($controller->data)){
            //Loop for models
            foreach($controller->data as $key=>$value){
                if(isset($controller->{$key})){
                    $columns = $controller->{$key}->getColumnTypes();
                    foreach($value as $k=>$v){
                        if($v != ''){
                            //Check if there are some fieldFormatting set
                            if(isset($this->fieldFormatting[$columns[$k]])){
                                $ret[$key.'.'.$k .' LIKE '] = sprintf($this->fieldFormatting[$columns[$k]], $v);
                            } else {
                                $ret[$key.'.'.$k .' LIKE '] = $v;
                            }
                        }
                    }
                    //unsetting the empty forms
                    if(count($value) == 0){
                        unset($controller->data[$key]);
                    }
                }
            }
        }
        return $ret;
    }
   
    /**
     * function which will take care of the storing the filter data and loading after this from the Session
     */
    function _prepareFilter(&$controller){
        if(isset($controller->data)){
            foreach($controller->data as $model=>$fields){
                foreach($fields as $key=>$field){
                    if($field == ''){
                        unset($controller->data[$model][$key]);
                    }
                }
            }
            $controller->Session->write($controller->name.'.'.$controller->params['action'], $controller->data);
        }
        $filter = $controller->Session->read($controller->name.'.'.$controller->params['action']);
        $controller->data = $filter;
    }

}

?>