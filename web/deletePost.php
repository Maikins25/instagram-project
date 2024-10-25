



<?php
include('library.php');
extract($_REQUEST);


$conn = get_database_connection();

$post = <<<SQL
    DELETE FROM post WHERE post_id = $postId;
    
SQL;


mysqli_query($conn, $post);

$comments = <<<SQL
    DELETE FROM comments WHERE comment_post_id = $postId;
    
SQL;


mysqli_query($conn, $comments);

$likes = <<<SQL
    DELETE FROM likes WHERE like_post_id = $postId;
    
SQL;


mysqli_query($conn, $likes);
    


$conn->close();
header('Location: index.php?content=Settings');   


    
