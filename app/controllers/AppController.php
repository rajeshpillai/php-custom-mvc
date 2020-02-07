<?php

/**
 * Description of AppController
 *
 * @author rajesh pillai
 */
include_once 'libs/controller.php';

class AppController extends Controller {

    function __construct($route = null) {
        parent::__construct($route);

        $controllerClass =  $this->getControllerClassName() ;

        // Create model instance for each registered model in the controller

        if (isset($this->uses)) {
            
            foreach ($this->uses as $use) {
                $this->$use = new $use();
            }
        }
        else {  // Default model based on Controller name
            $sing = Inflect::singularize($controllerClass);
            $this->$sing = new $sing();
            $this->model = $this->$sing;
        }
    }

    private function getControllerClassName()
    {
        //todo:
        $tokens = explode("Controller",get_called_class());
        echo $tokens[0] . "<br/>";
        return $tokens[0];
    }
}

?>
