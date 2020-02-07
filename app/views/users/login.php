
 <form action="<?php echo '/'.APP_ROOT.'/'; ?>users/dologin" method="post">

 <fieldset>
   <legend>Please Login</legend>
     <div>
       <label> username </label>
       <input name="username" size="40" type="text" />
     </div>

     <div>
        <label> password </label>
        <input name="password" size="40" type="password" />
     </div>

      <input type="submit" value="login" />

 </fieldset>

</form>
