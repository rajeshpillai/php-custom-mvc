<?php

abstract class Controller
{
    protected $_controller;
    protected $_action;
        
    private $route;

    public $model;
    public $view;  // viewname the controller uses
    private $layout;
    private $viewVars = array();

    public $autoRender = false;
    public $name = "";

    function __construct($route = null, $controller = null, $action = null)
    {
        $this->route = $route;
        $this->_controller = $controller;
        $this->_action = $action;
    }

  

    //function View($view_name=null, $layout=null, $model=null)
    function view($params)
    {
        if (!is_array($params))
        {
            throw new InvalidArgumentException("Expected array", 101);
        }

        $this->layout = array_key_exists("layout", $params)? $params["layout"] : "master";
        $this->view = array_key_exists("view", $params)? $params["view"] : "index";
        $this->model = array_key_exists("model", $params)? $params["model"] : null;

        
        if (array_key_exists("isPartial", $params))
        {
            include(VIEW_PATH.$this->route['controller'].DS.$this->route['action'].'.php');
            return;
        }

        if(file_exists(VIEW_PATH.'layouts'.DS.$this->route['controller'].'.php'))
	{
            // includes controller layout
            include(VIEW_PATH.'layouts'.DS.$this->route['controller'].'.php');
	}
	else
	{
            // include default layout
            include(VIEW_PATH.'layouts'.DS.'master.php');
	}
    }

    public function set($key, $value)
    {
        $this->viewVars[$key]=$value;
    }

     /**
      * redirects to addess
      * @param string $address
      * @return redirects
      */
     public function redirect_to($address)
     {
        header('location:'.WEBSITE.APP_ROOT.'/'.$address);
        exit;
     }


     /**
      * creates warning msg used for errors.
      * @param string $msg
      * @return bool
      */
     function flash_warning($msg)
     {
        if(!$msg) { return false; }

        $_SESSION['flash']['warning'] = $msg;
        return true;
     }


      /**
      * creates notice msg used for success
      * @param string $msg
      * @return bool
      */
     function flash_notice($msg)
     {
        if(!$msg) { return false; }

        $_SESSION['flash']['notice'] = $msg;
        return true;
     }


     /**if(!$msg) { return false; }
           $_SESSION['flash']['notice'] = $msg;
                return true;
      * checks for user session
            * sends user to login page if session cannot be found
      * @return true or redirect
      */
      function check_authentication()
      {
        if($_SESSION['user'])
        {
            return true;
        }
        else
        {
            redirect_to('/users/login');
        }
      }
}
?>
