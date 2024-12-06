<?php


$conn = get_database_connection();

$userSql = <<<SQL
    select COUNT(*) as validTokens, user_id
    from user_tokens
    where token = '$token'
    group by user_id;
SQL;

$userResult = mysqli_query($conn, $userSql);






$row = $userResult->fetch_assoc();

if($row['validTokens'] < 1){
    header('Location: index.php?content=forgotPassword&status=invalid');
}else{

    $user_id = $row['user_id'];
}






?>

<div class="wrapper">
        <form class="forgotForm" method="POST" action="newPassword.php">
            <h1 class="font">Reset Password</h1>

            
        


            <div class="input-box">
                <input type="text" name="newPassword" placeholder="Enter new password"  required />
                <i class='bx bxs-envelope' ></i>
            </div>

            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>" />

     
            <button type="submit" id="loginButton" class="logInButton" value="Log In" >Change Password</button>
            



            <div class="register-link">
                <p> Already have an account? <a href="index.php?content=Login">Login</a></p>
                
            </div>
                

            

        </form>
      
    </div>

