
<?php
include('library.php');
$dbh = get_database_connection();




$username = mysqli_real_escape_string($dbh, $username);
$email = mysqli_real_escape_string($dbh, $email);
$password = mysqli_real_escape_string($dbh, $password);

$sql = <<<SQL
SELECT user_username, user_password,user_id
FROM users
WHERE user_username = '{$username}'
AND user_password = '{$password}'
AND user_email = '{$email}'
SQL;

$result = mysqli_query($dbh, $sql);

$count = mysqli_num_rows($result);
if ($count == 1)
{
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    session_start();

    $_SESSION['userId'] = $row['user_id'];
    $_SESSION['authenticated'] = true;

    session_write_close();

    header('Location: index.php?content=list');
    
}
else
{
    header('Location: index.php?content=login');
}
