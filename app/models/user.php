<?php

class User extends ActiveRecord
{
    public static $className = "User";
    public static $tableName = "users";
    
    public $username;
    public $password;
    public $email;
    public $id;
    public $created_on;
    
    // Has many
    static $hasMany = array(
      'Projects' => array('className'=>'Project',
                      'foreignKey'=>'user_id')  
    );
       
}
?>
