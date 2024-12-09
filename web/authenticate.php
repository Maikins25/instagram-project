<?php
include('library.php');
$conn = get_database_connection();

$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

// Check user credentials
$sql = <<<SQL
SELECT user_username, user_password, user_id
FROM users
WHERE (user_username = '$username' OR user_email = '$username')
AND user_password = '$password';
SQL;

$result = mysqli_query($conn, $sql);
$remember = isset($_POST['remember']) ? true : false;

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $userId = $user['user_id'];

    // Generate a unique token for "remember me"
    if ($remember) {
        $token = bin2hex(random_bytes(32)); // Secure random token
        $expiresAt = date('Y-m-d H:i:s', strtotime('+30 days')); // Cookie expires in 30 days
        $type = 'cookie'; // Token type

        // Delete any existing tokens for the user and type
        $deleteTokenSql = <<<SQL
            DELETE FROM user_tokens
            WHERE user_id = $userId AND token_type = '$type';
            SQL;
        $conn->query($deleteTokenSql);

        // Insert the new token
        $insertTokenSql = <<<SQL
            INSERT INTO user_tokens (user_id, token, expires_at)
            VALUES ('$userId', '$token', '$expiresAt');
        SQL;

        if ($conn->query($insertTokenSql)) {
            // Set the cookie on the user's browser
            setcookie('remember_me', $token, time() + (30 * 24 * 60 * 60), "/", "", false, false); // Secure and HttpOnly
        } else {
            die("Error inserting token: " . $conn->error);
        }
    }

    // Set session and redirect
    $_SESSION['userId'] = $userId;
    $_SESSION['authenticated'] = true;
    session_write_close();
    header('Location: index.php?content=feed');
} else {
    echo'';
    // header('Location: index.php?content=login&loggedIn=failed');
}
