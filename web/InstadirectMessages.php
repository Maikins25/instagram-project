<script>
let currentRecipientId = null;
let gloablGroupId = null;

let lastMessageId = null; // Track the last message ID seen
let inGroupChats = false;


function toggleOverflow(){
    const body = document.getElementById('body');
    console.log("in toggleOverflow and got body element");

    if(body.style.overflow == 'hidden'){
        body.style.overflow = 'block';
    }else{
        body.style.overflow = 'hidden';

    }
}

function createGc(){
    const body = document.getElementById('gcCreator');

    if(body.style.display == 'none'){
        body.style.display = 'block';
    }else{
        body.style.display = 'none';

    }
    console.log("ran");

}

function activateDirectMessages(){
    var dms = document.getElementById('dms');
    var gcs = document.getElementById('gcs');
    inGroupChats = false;

    dms.style.display = "block";
    gcs.style.display = "none";

}


function activateGroupChats(){
    var dms = document.getElementById('dms');
    var gcs = document.getElementById('gcs');

    dms.style.display = "none";
    gcs.style.display = "block";
    

}

function submitMessage(recipientId) {
    const message = document.getElementById('messageInput').value;
    let type = 'D';

    if(inGroupChats){
        type = 'G';
        console.log("type:group");
        recipientId = globalGroupId;
    }else{
        console.log("type:direct");
    }
    
    $.ajax({
        url: 'send_message.php',
        type: 'POST',
        data: { 
            recipient_Id: recipientId,
            message: message,
            message_type:type
        },
         // Important to parse JSON response
        success: function(response) {
            $('#messageInput').val('');

            if(inGroupChats){
                loadGroup(recipientId); // Reload conversation
            }
            else{
                loadData(recipientId)
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}


function loadGroup(group) {
    // currentRecipientId = recipientId;
    inGroupChats = true;
    globalGroupId = group;

    $.ajax({
    url: 'groupChat.php',
    type: 'GET',
    data: { 
        groupId: group
    },
    success: function(response) {
        $('#conversation').html(response); // Display conversation
        const messages = document.querySelectorAll('#conversation .userMessageBlock, #conversation .otherMessageBlock');
        if (messages.length > 0) {
            console.log(messages);
            lastMessageId = messages[messages.length - 1].getAttribute('data-message-id');


            // const lastMessage = messages[messages.length - 1];
            // lastMessageId = lastMessage.getAttribute('data-message-id');
        }
        scrollToBottom();
    },
    error: function(xhr, status, error) {
        console.error('Error:', error);
    }
});

}
document.addEventListener("DOMContentLoaded", function () {
        const messageInput = document.getElementById("messageInput");

        if (messageInput) {
            // Listen for keydown events in the textarea
            messageInput.addEventListener("keydown", function (event) {
                if (event.key === "Enter" && !event.shiftKey) {
                    event.preventDefault(); // Prevent a new line
                    submitMessage(currentRecipientId); // Call your submitMessage function
                }
            });
        } else {
            console.error("Textarea with ID 'messageInput' not found.");
        }
    });



function loadPeopleList(group){
    $.ajax({
    url: 'groupMembers.php',
    type: 'GET',
    data: { 
        groupId: group
    },
    success: function(response) {
        $('#gcPeopleList').html(response); // Display conversation
    },
    error: function(xhr, status, error) {
        console.error('Error:', error);
    }
    });
}


function togglePeopleList(group_id){
    const body = document.getElementById('gcPeopleList');
    // console.log("in toggleOverflow and got body element");

    if(body.style.display == 'none'){
        body.style.display= 'block';

        loadPeopleList(group_id)

    }else{
        body.style.display = 'none';

    }
}




function loadData(recipientId) {
    currentRecipientId = recipientId;

    $.ajax({
    url: 'conversation.php',
    type: 'GET',
    data: { 
        recId: recipientId
    },
    success: function(response) {
        $('#conversation').html(response); // Display conversation
        const messages = document.querySelectorAll('#conversation .userMessageBlock, #conversation .otherMessageBlock');
        if (messages.length > 0) {
            console.log(messages);
            lastMessageId = messages[messages.length - 1].getAttribute('data-message-id');


            // const lastMessage = messages[messages.length - 1];
            // lastMessageId = lastMessage.getAttribute('data-message-id');
        }
        scrollToBottom();
    },
    error: function(xhr, status, error) {
        console.error('Error:', error);
    }
});

}


function scrollToBottom() {
    const conversationDiv = document.getElementById('conversation');
    conversationDiv.scrollTop = conversationDiv.scrollHeight;
}

// Function to update the last seen message ID
function updateLastMessageId() {
    const messages = document.querySelectorAll('#conversation .userMessage, #conversation .otherMessage');
    
    if (messages.length > 0) {
        lastMessageId = messages[messages.length - 1].getAttribute('data-message-id');
        console.log("Updated Id: " + lastMessageId);
    }
}

// Function to check for new messages every 3 seconds
setInterval(function() {
    let conversationType = null;

    if(!inGroupChats){
        conversationType = "direct";
    }else{
        conversationType="group";
    }


    let recipient = null;

    if(inGroupChats){
        recipient = globalGroupId;
    }else{
        recipient = currentRecipientId
    }

    console.log("Last Message Id: " + lastMessageId);
    if (currentRecipientId || (inGroupChats && globalGroupId)) { // Only check if a conversation is open
        $.ajax({
            url: 'check_new_messages.php', // PHP script to check for new messages
            type: 'GET',
            data: {
                recId:recipient,
                lastMessageId:lastMessageId,
                convoType:conversationType
            },
            dataType: 'json',
            success: function(response) {
                // console.log(response.newMessages);
                if (response.newMessages) {
                    if(inGroupChats){
                        loadGroup(globalGroupId);
                    }else{
                        loadData(currentRecipientId); // Reload conversation if there are new messages

                    }
                }
                
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
}, 3000); // Check every 3 seconds










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



   



    $gcSql = <<<SQL
    SELECT u.user_id, u.user_username
    FROM follow f1
    JOIN follow f2 
    ON f1.follow_followed_user_id = f2.follow_user_id 
    AND f1.follow_user_id = f2.follow_followed_user_id
    JOIN users u 
    ON u.user_id = f1.follow_followed_user_id
    WHERE f1.follow_user_id = $user;
    SQL;

    $gcResult = mysqli_query($conn, $gcSql);




    $groupSql = <<<SQL
        Select group_name, group_id
        from `groups`
        join group_members on member_group_id = group_id
        where member_user_id = $user;
        
    SQL;

    $groupResult = mysqli_query($conn, $groupSql);




    $image_path = "profilePics/";
    $currentRecipient = "";
    echo'<script>toggleOverflow()</script>';

    echo'<div class="leftFriends">';


        echo'<div class="tab">';
        echo'<button class="dms" onclick="activateDirectMessages()">Direct Messages</button>';
        echo'<button class="gcs" onclick="activateGroupChats()">Group Chats</button>';
        echo'</div>';



        
        
        
        
        echo'<div id="gcs" class="groupChats">';

        echo'<div style="display:none;" id="gcPeopleList" class="gcPeopleList">';
        



        echo'</div>';

            echo'<div class=centerButton>';
            echo'<button class="createGcButton" onclick="createGc()">Create New Group Chat</button>';
            echo'</div>';

            echo'<div style="display:none" id="gcCreator" class="gcCreator">';

            if ($result && mysqli_num_rows($gcResult) > 0) {
                echo '<form action="createGroupchat.php" method="POST">'; // Form starts
            
                echo '<h3>Select Users to Add to Group Chat:</h3>';
                echo '<ul>'; // List container

                echo '<input class="gcNameInput" type="text" placeholder="Enter name" name="groupName" > '; // Checkbox
            
                while ($row = mysqli_fetch_assoc($gcResult)) {
                    // Echo a checkbox for each user
                    echo '<li>';
                    echo '<label>';
                    echo '<input type="checkbox" name="selectedUsers[]" value="' . $row['user_id'] . '"> ';
                    echo htmlspecialchars($row['user_username']); // Username
                    echo '</label>';
                    echo '</li>';
                }
            
                echo '</ul>';
                echo '<button type="submit">Create Group Chat</button>'; // Submit button
                echo '</form>'; // Form ends
            } else {
                echo 'Make some friends to make a groupchat.';
            }

            echo'</div>';



            while($row = $groupResult->fetch_assoc()){
                // echo '<a href="index.php?content=Otherprofile&userId=' . $row['user_id'] . '"><img class="profilePic" src="' . $image_path . $row['user_id'] . '.png"></a>';

                echo'<div class="bigPersonButton">';
                    echo '<button class="groupPersonButton" onclick="loadGroup('. $row['group_id'] .')">';
                        echo '&nbsp'. $row['group_name'];
                    echo'</button>';

                    echo'<button class="gcPeopleButton" onclick="togglePeopleList('. $row['group_id'] .')"><img class="threeDotsImg" src="images/threeDots.png"></button>';

                echo'</div>';
            

                
            }
            
        echo'</div>';
   



        
        echo'<div id="dms" class="directMessages">';

        if ($result && mysqli_num_rows($result) > 0) {
            while($row = $result->fetch_assoc()){
                // echo '<a href="index.php?content=Otherprofile&userId=' . $row['user_id'] . '"><img class="profilePic" src="' . $image_path . $row['user_id'] . '.png"></a>';

                echo'<div class="bigPersonButton">';
                echo '<button class="personButton" onclick="loadData('. $row['user_id'] .',' . $user.')"><img class="profilePic" src="' . $image_path . $row['user_id'] . '.png">';
                echo '&nbsp'. $row['user_username'];
                echo '<br>';
                echo'</div>';
            }
                
        }else{
            echo'Make some friends so you can message them';
        }

        echo'</div>';



    echo'</div>';

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