<?php
include_once(MODEL_PATH.'project.php');

class ProjectsController extends AppController
{
    public $name = "Projects";
    
    public $projects;
    
    function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $project = Project::instance();
            return $this->View(array('view'=>'add', 'model'=>$project));
        }
        
        //$project = new Project($_POST);
        $project = Project::create($_POST);
        
        if (empty($project->errors)) {
            $this->redirect_to('projects/all');
        }
        else 
        {
            return $this->View(array('view'=>'add', 'model' => $project));
        }
    }
    
    function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $project = Project::find($id);
            return $this->View(array('view'=>'edit', 'model'=>$project));
        }
        $project = Project::instance($_POST);
        $project->save();
        //ActiveRecord::println($project);
        //ActiveRecord::println($project->errors["user_id"]);
        
        if (empty($project->errors)) {
            //$this->redirect_to('projects/all');
        }
        else 
        {
            // show errors
            return $this->View(array('view'=>'edit', 'model' => $project));
        }
        
    }
    
    function show($id) {
        $project = Project::find($id);
        return $this->View(array('view'=>'show','model'=>$project));
    }
    
    function delete($id) {
        Project::delete_by_id($id);
        $this->redirect_to('projects/all');
    }
    
    function index() {
        $this->redirect_to('projects/all');
    }
    function all(){
        $projects = $this->Project->find_all();
        return $this->View(array('view'=>'all','model'=>$projects));
    }
    
}
?>