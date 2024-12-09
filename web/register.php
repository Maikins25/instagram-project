<?php
include('library.php');

$conn = get_database_connection();




$sql = <<<SQL
INSERT INTO users (user_username, user_password, user_email) VALUES ('$register_username','$register_password', '$register_email')

SQL;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {

    $conn->query($sql);
    
    header('Location: index.php?content=login&register=success&login=true');
    exit();
} catch (mysqli_sql_exception $e) {
    echo $e;
    header('Location: index.php?content=register&register=failed');
    exit();
}


$conn->close();
