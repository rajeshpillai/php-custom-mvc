<?php

class Project extends ActiveRecord
{
    public static $className = "Project";
    public static $tableName = "projects";
    public static $primaryKey = "id";
    
    static $labels = array(
        'id' => 'Id',
        'name' => 'Project Name',
        'user_id' => 'User Name',
        'desc' => 'Descriptiion'
    );
    
    static $belongs_to = array(
      'user' => array('className'=>'User',
                      'foreignKey'=>'user_id')  
    );
    
    
    static $rules = array (
        'name' => array (
            'alpha_required' => array(
                'rule'=> 'alphanumeric',
                'message'=>'name should be alphanumeric.'
             ),
            'req' => array (
                'rule'=>'required',
                'message'=>'name is required'
            )
         ),
        'user_id' => array (
            'number_required' => array(
                'rule' => 'required',
                'message' => 'A project should be assocated with a user.'
            )
        ),
        'user_id' =>  array (
            "rule" => "greater",
            "value" => 0,
            "message" => "The user_id should be greater than 0."
        ),
        
    );
    
    static $rules1 = array (
        "name" => "required",
        "name" => "alphanumeric",
        "user_id" => "required"
    );
    
    static $rules2 = array (
        "name" => array (
            "rule" => "required",
            "message" => "name is a required field"
         ),
        "desc" => array (
            "rule" => "required",
            "message" => "desc is a required field"
         ),
        
        "user_id" => "required"
    );
            
}
?>
