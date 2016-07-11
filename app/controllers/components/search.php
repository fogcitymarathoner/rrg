<?php 
/**
 * Search component
 * Based on Nick Chankov's Filter component: http://nik.chankov.net/2008/03/01/filtering-component-for-your-tables/
 * This moves it to a component so it can be attached to a Model specifically (since we typically search per
 * model), plus takes it a step further to factor in associations, albeit limited.
 * This takes it a step further for associations, albeit limited.
 *
 * @author  Brenton Bartel
 */

class SearchComponent extends Object {
    /**
     * fields which will replace the regular syntax in where i.e. field = 'value'
     */
    var $fieldFormatting    = array(
                    "text" => array('LIKE', "%%s%%"),
                    "string" => array('LIKE', "%s%%"),
                    "date" => array('LIKE', "'%s'")
                    );

    /**
     * Function which will change controller->data array.
     * Most often used to take in controller & form data and return a useable 'conditions' array.
     * Currently only tested for the calling controller (where controller == model)
     *
     * @param object $controller the class of the controller which call this component
     * @access public
     */
    function process ($controller) {
        // clean up and do session stuff
        $this->_prepareSearch($controller);

        $controller_model = $controller->{Inflector::singularize($controller->name)};
        $associated = $controller_model->getAssociated();

        $ret_val = array();

        if (isset($controller->data)) {

            // Loop for models
            foreach ($controller->data as $model_name => $form_values) {
                // See if we're dealing with the current controller's model, 

                $column_defs = false;

                // First, see if it's associated
                if (array_key_exists($model_name, $associated)) {
                    $column_defs = $controller_model->{$model_name}->getColumnTypes();
                }
                // See if we're dealing with one that's set (ex: if UserController has $this->User)
                // There could be a circumstance where the controller has employed `var $uses` to instantiate a model
                // that is not a direct link to the controller (ex: UserController has $this->Interest), which is
                // why we want to check if $model_name is associated with our current controller model first
                // (ex: $this->User->InterestsUser).
                elseif (isset($controller->{$model_name})) {
                    $column_defs = $controller->{$model_name}->getColumnTypes();
                }

                // So now that we have the column definitions (ex: data type) ...
                if (is_array($column_defs)) {
                    foreach ($form_values as $k => $v) {
                        if ($v != '') {
                            // Check if there are some fieldFormatting set
                            if (array_key_exists($column_defs[$k], $this->fieldFormatting)) {
                                $col = $this->fieldFormatting[$column_defs[$k]];

                                // fail-safe if an array was defined properly or not
                                if (is_array($col)) {
                                    $ret_val[$model_name .'.'. $k .' '. $col[0]] = sprintf($col[1], $v);
                                }
                                else {
                                    $ret_val[$model_name .'.'. $k] = sprintf($col, $v);
                                }
                            }
                            else {
                                $ret_val[$model_name .'.'. $k] = $v;
                            }
                        }
                    }
                    // unsetting the empty forms ... why? (not sure)
                    if (count($form_values) == 0) {
                        unset($controller->data[$model_name]);
                    }
                }
            }
        }

        return $ret_val;
    }

    /**
     * function which will take care of the storing the search data and loading after this from the Session
     */
    function _prepareSearch (&$controller) {

        if (isset($controller->data)) {
            foreach ($controller->data as $model => $fields) {
                foreach ($fields as $key => $field) {
                    // No point in having anything if nothing's entered
                    if ($field == '') {
                        unset($controller->data[$model][$key]);
                    }
                }
            }

            // store for future.
            $controller->Session->write($controller->name.'.'.$controller->params['action'], $controller->data);
        }

        $search = $controller->Session->read($controller->name.'.'.$controller->params['action']);
        $controller->data = $search;
    }

}
?>
