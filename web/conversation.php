<?php

include('library.php');


$conn = get_database_connection();


$recipient_Id = mysqli_real_escape_string($conn, $recId);






$sql = <<<SQL
Select * 
From directMessages
where message_sender = $user
and message_recipient = $recipient_Id
SQL;

$result = mysqli_query($conn, $sql);


echo'<h1>Got the Convo<h1>';

// Check if the query was successful
if ($result) {
    while ($row = $result->fetch_assoc()) {
       echo 'Message Sender:' . $row['message_sender'];
       echo 'Message Recipient' . $row['message_recipient'];
    }
} else {
    // Handle query failure
    echo '<h1>Error: Could Not Load Conversation</h1>';
}


    


$conn->close();
// header('Location: index.php?content=settings');