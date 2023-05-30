<?php
include('library.php');
extract($_REQUEST);


$conn = get_database_connection();

$sql = <<<SQL
    INSERT INTO comments(comment_post_id, comment_words) VALUES ($id, '$crumble')

SQL;


mysqli_query($conn, $sql);
    


$conn->close();

