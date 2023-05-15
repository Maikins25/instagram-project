<?php
include('library.php');

$conn = get_database_connection();


$sql = <<<SQL
INSERT INTO users (user_username, user_password, user_email) VALUES ('$register_username','$register_password', '$register_email')

SQL;


$conn->query($sql);



$conn->close();

header('Location: index.php?content=login');