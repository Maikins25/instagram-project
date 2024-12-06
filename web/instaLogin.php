<?php


$conn = get_database_connection();
/*************************************************************************************************
 * login.php
 *
 * Copyright 2017-2022
 *
 * Login page content. This page is intended to be included in index.php.
 *************************************************************************************************/
// include('library.php');

if(isset($register)){
    $signedUp = $register;
}else{
    $signedUp = "none";
}


if(isset($loggedIn)){
    $isLoggedIn = $loggedIn;
}else{
    $isLoggedIn = "none";
}



if (isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];

    // Verify the token in the database
    $sql = "SELECT user_id FROM user_tokens WHERE token = '$token' AND expires_at > NOW()";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {

        if(mysqli_num_rows($result) > 0){
            session_start();
        
            $_SESSION['userId'] = $row['user_id'];
            $_SESSION['authenticated'] = true;
        
            session_write_close();
        
            header('Location: index.php?content=feed');
        }
    
    }


}


?>










<div class="wrapper">
        <form class="loginForm" action="authenticate.php">
            <h1 class="font">Login</h1>



            <?php
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

                if($isLoggedIn == "failed"){
                    echo'<h1 style="
                    margin-top=20px;
                    font-size:15px;
                    color:red;
                    ">Log In failed</h1>';
                }


            ?>
            
        


            <div class="input-box">
                <input type="text" name="username" placeholder="Username or Email"  required />
                <i class='bx bxs-user'></i>
            </div>
     


            <div class="input-box">               
                <input type="password"  id="password" name="password" placeholder="Password" required />
                <i class='bx bxs-lock-alt'></i>
            </div>

         
            
            
            <div class="remember-forgot">
                <label><input type="checkbox">Remember Me</label>
                <a href="index.php?content=forgotPassword">Forgot Password?</a>
            </div>

            <button type="submit" id="loginButton" class="logInButton" value="Log In" onclick="login()">Login</button>
            

            <div class="register-link">
                <p> Don't have an account? <a href="index.php?content=register">Sign Up</a></p>
                
            </div>
                

            

        </form>
      
    </div>


<script>









// function login() {
//     if ($('#email').val() == '') {
//         showAlert('danger', 'Email Required!', 'Enter your email address and try again.');
//     } else if ($('#password').val() == '') {
//         showAlert('danger', 'Password Required!', 'Enter your password and try again.');
//     } else {
//         var settings = {
//             'async': true,
//             'url': 'api/authenticate.php?email=' + $('#email').val() + '&password=' + $('#password').val(),
//             'method': 'POST',
//             'headers': {
//                 'Cache-Control': 'no-cache'
//             }
//         };

//         $('#loginButton').prop('disabled', true);

//         $.ajax(settings).done(function(response) {
//             window.location.replace('index.php?content=menu');
//         }).fail(function() {
//             showAlert('danger', 'Invalid Login!', 'Check your email address and password and try again.');
//         }).always(function() {
//             $('#loginButton').prop('disabled', false);
//         });
//     }
// }



</script>