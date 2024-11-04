<script>
let currentRecipientId = null;


function submitMessage(recipientId) {
    // Get the message from the textarea
    const message = document.getElementById('messageInput').value;
    
    $.ajax({
        url: 'send_message.php', // PHP script to handle message sending
        type: 'POST',
        data: { 
            recipientId: recipientId, // Pass the recipient ID
            message: message // Pass the message content
        },
        success: function(response) {
            // Optionally, clear the input or update the conversation
            $('#messageInput').val('');
            loadData(recipientId, userId); // Reload conversation
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}







function loadData(recipientId, userId) {
    currentRecipientId = recipientId; // Set the global recipient ID

    $.ajax({
        url: 'conversation.php',
        type: 'GET',
        data: { 
            recId: recipientId,
            userId: userId
        },
        success: function(response) {
            $('#conversation').html(response); // Display conversation
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}





</script>

<?php


if(isset($user)){

    // echo $user;
    $conn = get_database_connection();


    $sql = <<<SQL
    SELECT u.user_id, u.user_username
    FROM follow f1
    JOIN follow f2 
    ON f1.follow_followed_user_id = f2.follow_user_id 
    AND f1.follow_user_id = f2.follow_followed_user_id
    JOIN users u 
    ON u.user_id = f1.follow_followed_user_id
    WHERE f1.follow_user_id = $user;
    SQL;

    $result = mysqli_query($conn, $sql);
    $image_path = "profilePics/";
    $currentRecipient = "";

    echo'<div class="leftFriends">';

        while($row = $result->fetch_assoc()){
            // echo '<a href="index.php?content=Otherprofile&userId=' . $row['user_id'] . '"><img class="profilePic" src="' . $image_path . $row['user_id'] . '.png"></a>';
            echo'<div class="followingName">';
            echo '<button onclick="loadData('. $row['user_id'] .',' . $user.')"><img class="profilePic" src="' . $image_path . $row['user_id'] . '.png">';
            echo '&nbsp'. $row['user_username'];
            echo '<br>';
            echo'</div>';
            
        }

    echo'</div>';




    echo'<div class="right-side">';
        
        echo'<div id="conversation" class="conversation">';

        
        echo'</div>';
    


        //comment input
        echo '<div class="dmTextArea">';
        echo '<textarea id="messageInput" class="message-text-area-styles" placeholder="Write your message..."></textarea>';
        echo '<button class="dm-submit-button" onclick="submitMessage(currentRecipientId)"><img class="messageSendButton" src="images/send.png"></button>';
        echo '</div>';
   
    
    echo'</div>';
    

}