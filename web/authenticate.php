
<?php
include('library.php');
$conn = get_database_connection();




$username = mysqli_real_escape_string($conn, $username);

$password = mysqli_real_escape_string($conn, $password);

$sql = <<<SQL
SELECT user_username, user_password,user_id
FROM users
WHERE user_username = '$username' OR user_email = '$username'
AND user_password = '$password'

SQL;

$result = mysqli_query($conn, $sql);



$cookieSql = <<<SQL
SELECT user_username, user_password,user_id
FROM users
WHERE user_username = '$username' OR user_email = '$username'
AND user_password = '$password'

SQL;

$cookieResult = mysqli_query($conn, $cookieSql);



if ($result->num_rows > 0) {
    $user = $cookieResult->fetch_assoc();
    $userId = $user['user_id'];


    // Generate a unique token
    $token = bin2hex(random_bytes(32)); // Secure random token

    // Save token in the database
    $expiresAt = date('Y-m-d H:i:s', strtotime('+30 days')); // Cookie expires in 30 days
    $insertTokenSql = "INSERT INTO user_tokens (user_id, token, expires_at) VALUES ('$userId', '$token', '$expiresAt')";
    $conn->query($insertTokenSql);

    // Set the cookie on the user's browser
    setcookie('remember_me', $token, time() + (30 * 24 * 60 * 60), "/", "", false, false); // Secure and HttpOnly

    $count = mysqli_num_rows($cookieResult);
    echo $count;
    
    if ($count > 0)
    {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
       
    
        $_SESSION['userId'] = $row['user_id'];
        $_SESSION['authenticated'] = true;
    
        session_write_close();
    
        header('Location: index.php?content=feed');
        
    }
    else
    {
        echo'<h1>in else statement</h1>';
    
        header('Location: index.php?content=login&loggedIn=failed');
    }
}else{
    header('Location: index.php?content=login&loggedIn=failed');

}








