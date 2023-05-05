<?php
include('library.php');


$conn = get_database_connection();


$sql = <<<SQL
   INSERT INTO follow (follow_user_id, follow_followed_user_id) VALUES ( $user , $followed_user_id);

SQL;

mysqli_query($conn, $sql);
