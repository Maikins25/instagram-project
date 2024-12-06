<?php


var_dump($_POST['user_id']);

include('library.php');
$conn = get_database_connection();

$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);

echo'<h1>ID: </h1>' . $user_id;

$sql = <<<SQL
update users
set user_password = '$newPassword'
where user_id = $user_id;

SQL;
echo $sql;

mysqli_query($conn, $sql);
    


$conn->close();
header('Location: index.php?content=Login');