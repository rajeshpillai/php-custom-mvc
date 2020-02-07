<?php

require_once('config/constants.php');
require_once('config/includes.php');

require_once('config/routes.php');
//require_once('config/route_table.php');


/**
 * Dispatcher converts Requests into controller actions.  It uses the dispatched Request
 * to locate and load the correct controller.  If found, the requested action is called on
 * the controller.
 */
class Dispatcher
{
    public $routes =  array();

    static function dispatch($url)
    {
       if (null === $url) {
            throw new InvalidArgumentException("Please pass a URL");
        }

	// Remove application root name from URL
	$url = str_replace(DS.APP_ROOT.DS, '', $url);

    $url = str_replace(CONTROLLER_POSTFIX, '', $url);
	
	$isMatch = false;

    foreach(Routes::$routes as $urls => $route)
	{
            // debug: looking for match
            //echo 'Matching '.$url.' in route table '.htmlspecialchars($route['url']).'<br/>';

            if (preg_match($route['url'], $url, $matches))
            {
                    //$params = array_merge($params, $matches);
                    $isMatch = true;
                    //echo "Match found<br/>";
                    break;
            }
	}
       
    $routes = $matches;
        
	if (!$isMatch)
	{
            echo "No match found<br/>";
            exit;
	}
	
	if (count($matches) == 1)
        {
            $route['controller'] = $route['controller'];
            $route['action'] = $route['action'];
        }
        else {
            $route['controller'] = $matches['controller'];

            if (array_key_exists('action', $matches))
                $route['action'] = $matches['action'];
            else
                $route['action'] = $route['action'];
        }

        require_once(APP_FOLDER. '/controllers/'.$route['controller'].'controller.php');

        $controller_name = $route['controller'].'controller';
        $action = $route['action'];

        $controller = new $controller_name($route, $controller_name, $action);
        
        $para = array_key_exists("id", $matches) ? $matches['id'] : null;

        $controller->$action($para);
    }
}
?>
