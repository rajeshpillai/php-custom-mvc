
 <form action="<?php echo '/'.APP_ROOT.'/'; ?>users/register" method="post">

 <fieldset>
   <legend>Please register</legend>
     <div>
       <label> username </label>
       <input name="username" size="50" type="text" />
     </div>

     <div>
        <label> password </label>
        <input name="password" size="50" type="password" />
     </div>
    <div>
        <label> email </label>
        <input name="email"  type="text" />
     </div>
     <input type="submit" value="register" />

 </fieldset>

</form>
