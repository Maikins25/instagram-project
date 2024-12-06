<?php

$conn = get_database_connection();

if(isset($status)){
    $status = $status;
}else{
    $status = 'none';
}



?>

<div class="wrapper">
        <form class="forgotForm" method="POST" action="sendEmail.php">
            <h1 class="font">Forgot Password</h1>
            <h4 style="text-align:center;color:white;font-size:14px;">Enter your email and then follow the instructions in the email to access your account</h4>

            <?php
            // echo'<h1>'. $status . '</h1>';
            if($status == 'sent'){
                echo'<h1 style="color:lightgreen;font-size:18px;">Rest Email Sent </h1>';
            }else if($status == 'invalid'){
                echo'<h1 style="color:red;font-size:18px;">Invalid Link</h1>';

            }else if($status == 'badEmail'){
                echo'<h1 style="color:red;font-size:18px;">Email Not Associated With An Account</h1>';

            }
            ?>

            <div class="input-box">
                <input type="text" name="userEmail" placeholder="Email"  required />
                <i class='bx bxs-envelope' ></i>
            </div>
     
            <button type="submit" id="loginButton" class="logInButton" value="Log In" onclick="login()">Send Email</button>
            


            <div class="register-link">
                <p> Already have an account? <a href="index.php?content=Login">Login</a></p>
                
            </div>
                

            

        </form>
      
    </div>