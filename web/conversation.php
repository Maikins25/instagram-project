<?php

include('library.php');


$conn = get_database_connection();



// $userId = $user;
$recipient_Id = isset($_GET['recId']) ? mysqli_real_escape_string($conn, $_GET['recId']) : '';










$sql = <<<SQL
    SELECT * 
    FROM directMessages
    WHERE (message_sender = $user AND message_recipient = $recipient_Id)
    OR (message_sender = $recipient_Id AND message_recipient = $user)
    ORDER BY message_time;

SQL;

$messages = mysqli_query($conn, $sql);
// echo'RecId: ' . $recipient_Id . ' UserId: ' . $user;

// echo'<h1>Got the Convo<h1>';

// Check if the query was successful


    if($messages){
        while ($row = $messages->fetch_assoc()) {

            if($row['message_sender'] == $user){
                
                echo'<div class="userMessageBlock" data-message-id="' . $row['message_id'] . '">';

                    echo'<div class="userMessageWrapper">';
                        echo'<h5 class="userTimeStamp">' . $row['message_time'] . '</h5>';
                        // echo'<br>';
                        echo '<h5 class="userMessage">' . $row['message_text']. '</h5>';
                    echo'</div>';

                    
                echo'</div>';

            }

            if($row['message_sender'] == $recipient_Id){
                echo'<div class="otherMessageBlock" data-message-id="' . $row['message_id'] . '">';

                    echo'<div class="otherMessageWrapper">';
                        echo'<h5 class="otherTimeStamp">' . $row['message_time'] . '</h5>';
                        // echo'<br>';
                        echo '<h5 class="otherMessage">' . $row['message_text']. '</h5>';
                    echo'</div>';

                echo'</div>';
            }

        }
    }



    

    
   












    


$conn->close();
// header('Location: index.php?content=settings');