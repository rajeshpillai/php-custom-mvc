<h2>All Users</h2>

<div>
<a href="register">Add new User</a>
</div>
<table border="1">    
<?php foreach($this->model as $user):?>
    <tr>
        <td><a href="show/<?php echo $user->id?>"><?php echo $user->username ?></a></td>
        <td><a href="edit/<?php echo $user->id?>">edit</a></td>
        <td><a href="delete/<?php echo $user->id?>">delete</a></td>
    </tr>
    
<?php endforeach; ?>
</table>



<div>
<a href="register">Add new User</a>
</div>
