<?php

include('library.php');


$conn = get_database_connection();



// $userId = $user;
$group_Id = isset($_GET['groupId']) ? mysqli_real_escape_string($conn, $_GET['groupId']) : '';



$nameSql = <<<SQL
    SELECT group_name
    from `groups` where group_id = $group_Id
SQL;

$groupName = mysqli_query($conn, $nameSql);








$sql = <<<SQL
    SELECT * 
    FROM directMessages
    join users on user_id = message_sender
    WHERE (message_type = 'G' AND message_recipient = $group_Id)

    ORDER BY message_time;

SQL;

$messages = mysqli_query($conn, $sql);
// echo'RecId: ' . $recipient_Id . ' UserId: ' . $user;

// echo'<h1>Got the Convo<h1>';

// Check if the query was successful
while ($row = $groupName->fetch_assoc()) {
    echo'<div class="groupName">';
    echo'<h1>' . $row['group_name'] . '</h1>';
    echo'</div>';

}

    if($messages){
        while ($row = $messages->fetch_assoc()) {


            if($row['message_sender'] == $user){
                
                echo'<div class="userMessageBlock" data-message-id="' . $row['message_id'] . '">';

                    echo'<div class="userMessageWrapper">';
                    echo'<h5 class="userTimeStamp"> <img class="convoPfp"  src="profilePics/' . $row['user_profile_picture_name'] . '"> ' . $row['message_time'] . '</h5>';
                        // echo'<br>';
                        echo '<h5 class="userMessage">' . $row['message_text']. '</h5>';
                    echo'</div>';

                    
                echo'</div>';

            }else{
                echo'<div class="otherMessageBlock" data-message-id="' . $row['message_id'] . '">';

                    echo'<div class="otherMessageWrapper">';
                    echo'<h5 class="otherTimeStamp"><img class="convoPfp" src="profilePics/' . $row['user_profile_picture_name'] . '">  ' . $row['message_time'] . '</h5>';
                        // echo'<br>';
                        echo '<h5 class="otherMessage">' . $row['message_text']. '</h5>';
                    echo'</div>';

                echo'</div>';
            }


            





        }

    }else{
        echo'No Messages Here';
    }



    

    
   












    


$conn->close();
// header('Location: index.php?content=settings');