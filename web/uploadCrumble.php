<?php
include('library.php');
extract($_REQUEST);

if('$crumb' <> ''){
    $conn = get_database_connection();
    
    $sql = <<<SQL
        INSERT INTO comments(comment_post_id, comment_words, comment_commenter) VALUES ($id, '$crumb', $user)
    
    SQL;
    
    
    mysqli_query($conn, $sql);
        
    
    
    $conn->close();
    header('Location: index.php?content=feed');   
    
}

