<script>
function profile(){
   
}
</script> 






<div class="wrapper">
        <form class="loginForm" method="POST" action="register.php">
            <h1 class="font">Sign Up</h1>

            <?php

                if(isset($register)){
                    $signedUp = $register;
                }else{
                    $signedUp = "none";
                }

                if($signedUp == "success"){
                    echo'<h1 style="
                    margin-top=40px;
                    font-size:15px;
                    color:green;
                    ">Successfully signed up</h1>';
                }else if($signedUp == "failed"){
                    echo'<h1 style="
                    margin-top=20px;
                    font-size:15px;
                    color:red;
                    ">Sign up failed</h1>';
                }

            ?>
            
        


            <div class="input-box">
                <input type="text" name="register_username" placeholder="Username"  required />
                <i class='bx bxs-user'></i>
            </div>
     


            <div class="input-box">               
                <input type="password"  id="register_password" name="register_password" placeholder="Password" required />
                <i class='bx bxs-lock-alt'></i>
            </div>
            
            <div class="input-box">
                <input type="text" name="register_email" placeholder="Email" required />
                <i class='bx bxs-envelope' ></i>
            </div>
         
            
            
            <div class="remember-forgot">
                <label><input type="checkbox">Remember Me</label>
                <a href="index.php?content=forgotPassword">Forgot Password?</a>
            </div>

            <button type="submit" id="loginButton" class="logInButton" value="Log In">Sign Up</button>
            

            <div class="register-link">
                <p> Already have an account? <a href="index.php?content=Login">Login</a></p>
                
            </div>
                

            

        </form>
      
    </div>



    