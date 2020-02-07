<?php
include_once(MODEL_PATH.'user.php');

class UsersController extends AppController
{
    public $users;
    public $name = "Users";
    
    public $uses = array("User", "Project");
    
    function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            return $this->View(array('view'=>'register'));
        }
        
        $user = new User($_POST);
        $user->save();
        //$this->redirect_to('home');
    }
    
    
    function show($id) {
        $user = User::find($id);
        
        $all = User::find_by_username("rajesh");
        $allu = User::find_by_username_and_email("rajesh","pillai.rajesh@gmail.com");
       
        ActiveRecord::println($all);
        ActiveRecord::println($allu);
        return $this->View(array('view'=>'show','model'=>$user));
        
    }
    
    function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $user = Project::find($id);
            return $this->View(array('view'=>'edit', 'model'=>$user));
        }
        $user = User::instance($_POST);
        $user->save();
        
        if (empty($user->errors)) {
            $this->redirect_to('users/all');
        }
        else 
        {
            // show errors
            return $this->View(array('view'=>'edit', 'model' => $user));
        }
        
    }
    
    
    function all(){
        $users = $this->User->find_all(); 
        $projects = $this->Project->find_all();
        
        return $this->View(array('view'=>'all','model'=>$users));
    }
    
    function delete($id) {
        User::delete_by_id($id);
        $this->redirect_to('users/all');
    }
    
    function login()
    {
        return $this->View(array('view'=>'login'));
    }

    function dologin()
    {
        $result = User::login($_POST['username'], $_POST['password']);
        if ($result)
        {
            $this->redirect_to("home");
            
        }
        else
        {
            $this->redirect_to("users/login");
        }

    }
    
    function logoff()
    {
        $_SESSION['user'] = null;
        flash_notice('You have been logged out.');
        check_authentication();

    }
}
?>