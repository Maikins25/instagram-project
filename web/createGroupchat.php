<?php

include('library.php');
if(isset($_SESSION['userId'])){

    $user =  $_SESSION['userId'];
}
$conn = get_database_connection();


$selectedUsers = $_POST['selectedUsers'];
$groupName = mysqli_real_escape_string($conn, $groupName);


$groups = <<<SQL
    INSERT INTO `groups`(group_name) VALUES ('$groupName')
SQL;

echo $groups;
mysqli_query($conn, $groups);
    
// echo'<h1>'. $selectedUsers[0] . $selectedUsers[1] .'</h1>';


$groupId = mysqli_insert_id($conn);

foreach ($selectedUsers as $userId) {
    $userId = mysqli_real_escape_string($conn, $userId);
    $sql = <<<SQL
        INSERT INTO `group_members` (member_group_id, member_user_id) VALUES ($groupId, $userId)
    SQL;

    mysqli_query($conn, $sql);
}

$userSql = <<<SQL
INSERT INTO `group_members` (member_group_id, member_user_id) VALUES ($groupId, $user)
SQL;

mysqli_query($conn, $userSql);

// echo $sql;
// mysqli_query($conn, $sql);


$conn->close();

header('Location: index.php?content=directMessages');





    


// header('Location: index.php?content=settings');