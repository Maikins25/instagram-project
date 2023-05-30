<?php




$conn = get_database_connection();

$image_path = "profilePics/";



$sql = <<<SQL
    select *
    from users
    where user_id = $user
   
  
SQL;






$result = mysqli_query($conn, $sql);


while($row = $result->fetch_assoc()){
    echo 'Your profile';
    echo '<br>';
    echo '<img src="' . $image_path .$user . '.png">';
    echo '<br>';
    echo $row['user_profile_bio'];
    echo '<br>';
    
}







$sql = <<<SQL
   select follow_followed_user_id, user_username
    from users
    join follow on follow_followed_user_id = user_id
    where follow_user_id = $user
;

  
SQL;



$result = mysqli_query($conn, $sql);
echo '<br>';
echo '<h3>Following</h3>';
while($row = $result->fetch_assoc()){
    echo $row['user_username'];
    echo '<br>';
}




$sql = <<<SQL
   select follow_user_id, user_username
    from users
    join follow on follow_user_id = user_id
    where follow_followed_user_id = $user
;

  
SQL;



$result = mysqli_query($conn, $sql);
echo '<br>';
echo '<h3>Followed By</h3>';
while($row = $result->fetch_assoc()){
    echo $row['user_username'];
    echo '<br>';
}