<?php

include('library.php');


$conn = get_database_connection();


$recipient_Id = mysqli_real_escape_string($conn, $recipient_Id);
$message = mysqli_real_escape_string($conn, $message);




extract($_REQUEST);


$conn = get_database_connection();

$sql = <<<SQL
    INSERT INTO directMessages(message_sender, message_text, message_recipient) VALUES ($user, $message, $recipient_Id)

SQL;


mysqli_query($conn, $sql);
    


$conn->close();
// header('Location: index.php?content=directMessages');   





    


$conn->close();
// header('Location: index.php?content=settings');