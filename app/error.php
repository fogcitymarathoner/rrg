<?php

class AppError extends ErrorHandler {

        function error404($params) {
                $this->controller->layout = "default";
                parent::error404($params);
        }
        function missingController($params) {
                $this->controller->layout = "default";
                parent::error404($params);
        }
        function missingAction($params) {
                $this->controller->layout = "default";
                parent::error404($params);
        }
}

?>

