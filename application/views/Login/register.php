<center>
 <form name = "login" method="post" action="./auth/register" enctype= "multipart/form-data" >
    <div class="form-group">
	<label for="field-username">Username</label>
	<input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
    </div>
    <div class="form-group">
	<label for="field-password">Password</label>
	<input type="password" class="form-control" id="password" name="password" placeholder="******" required>
    </div>
     <div class="form-group">
         <label for="field-image">Profile Image</label>
         <input type="file" id="images" name="images" max-size=32154 required>
     </div>
    <button type="submit" class="btn btn-default">Register</button>
</form>
    <a href="./login">Back</a>
</center>