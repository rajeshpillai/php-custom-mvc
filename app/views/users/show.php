<div>
       <label>USERNAME</label>
       <?php echo $this->model->username?>
</div>
<div>
    <label>EMAIL</label>
    <?php echo htmlentities($this->model->email)?>
 </div>

<div>
    <?php foreach($this->model->Projects as $project):?>
         <div><?php echo $project->name ?></div>
    <?php endforeach; ?>
</div>