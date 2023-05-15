<div class="text">
    <h2>Welcome to Instagraham</h2>
</div>

<div class="center">
    <p>
        Sign up to instagraham to see what your friends are up to!
    </p>
</div>




<div class="center">
        <form class="form-horizontal" action="register.php">
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
                <label class="col-sm-3 control-label" for="email">email</label>
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

                echo '<input  type="submit" id="signupButton" class="btn btn-primary btn-block" value="Sign Up" />'

                ?>
            


        
               <h6> Already Have an account? <a class="btn btn-link" href="index.php?content=Login" role="button">Login</a> </h6>
            

            

        </form>
      
    </div>

    