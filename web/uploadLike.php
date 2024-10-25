<?php
include('library.php');
extract($_REQUEST);

if('$crumb' <> ''){
    $conn = get_database_connection();
    
    $sql = <<<SQL
        INSERT INTO likes(like_user_id, like_post_id) VALUES ($user, $postId)
    
    SQL;
    
    
    mysqli_query($conn, $sql);
        
    
    
    $conn->close();
    header('Location: index.php?content=feed');   
    
}else{
    
}
