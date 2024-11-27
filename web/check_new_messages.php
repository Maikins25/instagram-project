<?php
// header('Content-Type: application/json');

include('library.php');

$conn = get_database_connection();

$recipientId = isset($_GET['recId']) ? (int)$_GET['recId'] : 0;
$lastMessageId = isset($_GET['lastMessageId']) && !empty($_GET['lastMessageId']) ? (int)$_GET['lastMessageId'] : 0;
$userId = $user; // Assuming $user is already defined as the current user's ID
$convoType = isset($_GET['convoType']) ? $_GET['convoType'] : '';



if($convoType == "direct"){

    if ($recipientId === 0 || $userId === 0) {
        echo json_encode(['newMessages' => false]);
        exit;
    }
    



    $dsql = <<<SQL
    SELECT COUNT(*) as newMessages
    FROM directMessages
    WHERE 
        (message_sender = $recipientId AND message_recipient = $userId)
        AND message_id > $lastMessageId
        AND message_type = 'D'
    SQL;
    
    // Only add the condition if lastMessageId is greater than 0
    
    
    
    $result = mysqli_query($conn, $dsql);
    
    
    if ($result) {
        $row = $result->fetch_assoc();
        echo json_encode(['newMessages' => (int)$row['newMessages']]); // Send JSON as integer value
    } else {
        echo json_encode(['newMessages' => 0]);
    }

}else{
  
    if ($recipientId === 0 || $userId === 0) {
        echo json_encode(['newMessages' => false]);
        exit;
    }
    



    $gsql = <<<SQL
    SELECT COUNT(*) as newMessages
    FROM directMessages
    join users on user_id = message_sender
    WHERE (message_type = 'G' AND message_recipient = $recipientId)
    AND message_id > $lastMessageId



    SQL;
    
    // Only add the condition if lastMessageId is greater than 0
    
    


    $result = mysqli_query($conn, $gsql);
    
    
    if ($result) {
        $row = $result->fetch_assoc();
        echo json_encode(['newMessages' => (int)$row['newMessages']]); // Send JSON as integer value
    } else {
        echo json_encode(['newMessages' => 0]);
    }

}

// Ensure recipientId and userId are set correctly


$conn->close();
