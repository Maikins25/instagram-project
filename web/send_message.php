<?php

include('library.php');
if(isset($_SESSION['userId'])){

    $user =  $_SESSION['userId'];
}
echo $recipient_Id;

$conn = get_database_connection();


$recipient_Id = isset($recipient_Id) ? mysqli_real_escape_string($conn, $recipient_Id): '';
$message = isset($message) ? mysqli_real_escape_string($conn,$message) : '';
$message_type = isset($message_type) ? mysqli_real_escape_string($conn,$message_type) : '';

if (!$user) {
    echo "Error: Missing user data.";
    
}
if (!$message) {
    echo "Error: Missing message data.";
    
}
if (!$recipient_Id) {
    echo "Error: Missing recipient.";
    
}




$sql = <<<SQL
    INSERT INTO directMessages(message_sender, message_text, message_recipient, message_type) VALUES ($user, '$message', $recipient_Id, '$message_type')

SQL;

echo $sql;

mysqli_query($conn, $sql);
    


$conn->close();

// header('Location: index.php?content=directMessages');   





    


// header('Location: index.php?content=settings');