<?php
class Routes
{
    public static $routes = array(

            // /controller/id/action
            array('url' => '/^(?P<controller>[a-zA-Z]\w+)\/(?P<id>\d+)\/(?P<action>[a-zA-Z]\w*)$/',
                              'name'=>'default1',
                              'controller'=>'master',
                              'action'=>'index'),

            // /controller/action/id
            array('url' => '/^(?P<controller>[a-zA-Z]\w+)\/(?P<action>[a-zA-Z]\w+)\/(?P<id>\d+)$/',
                              'name'=>'default3',
                              'controller'=>'master',
                              'action'=>'index'),


            // /controller/action
            array('url' => '/^(?P<controller>[a-zA-Z]\w+)\/(?P<action>[a-zA-Z]\w+)$/',
                              'name'=>'default2',
                              'controller'=>'master',
                              'action'=>'index'),


            // /controller
            array('url' => '/^(?P<controller>[a-zA-Z]\w+)/',
                              'name'=>'default2',
                              'action'=>'index'),

            array('url' => '/\s*/', 'name'=>'default', 'controller'=>'home','action'=>'index')

    );
}
?>
