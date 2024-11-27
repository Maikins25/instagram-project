<script>
function profile(){
   
}
</script> 






<div class="center">
        <form class="form-horizontal" action="register.php">

            <h1 style="text-align:center'">Sign Up</h1>

            <div class="col-xs-12" ></div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="email">&nbsp;</label>
                
            </div>


            <div class="col-xs-12" style="height:20px;"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="email">Username:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="username" name="register_username" placeholder="Username" autofocus />
                </div>
            </div>
            <div class="col-xs-12" style="height:20px;"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="email">Email:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="email" name="register_email" placeholder="Email" autofocus />
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-3 control-label" for="password">Password:</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="password" name="register_password" placeholder="Password" />
                </div>
            </div>
           


            
                <br>
                <?php

                echo '<input  type="submit" id="signupButton" onclick="profile()" class="btn btn-primary btn-block" value="Sign Up" />'

                ?>
            


        
               <h6> Already have an account? <a class="btn btn-link" href="index.php?content=Login" role="button">Login</a> </h6>
            

            

        </form>
        
      
    </div>

    