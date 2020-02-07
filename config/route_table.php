<?php
class RouteTable
{
    public static $routes = array(

            // /controller/id/action
            array('url' => 'controller/action/id',
                              'name'=>'default',
                              'controller'=>'home',
                              'action'=>'index'),

            array('url' => '{controller}\/{id}\/{action}/',
                      'name'=>'default1',
                      'controller'=>'home',
                      'action'=>'index')


    );
}
?>
