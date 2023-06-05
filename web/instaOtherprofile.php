

<?php

if(isset($user)){

// echo $user;
$conn = get_database_connection();

$sql = <<<SQL
SELECT *
FROM users 
where user_id = $userId
SQL;


$result = mysqli_query($conn, $sql);


if($row = $result->fetch_assoc()){
    
    // echo $row['user_profile_created'];

$sql = <<<SQL
    select *
    from users
    where user_id = $userId
   
  
SQL;






$result = mysqli_query($conn, $sql);


while($row = $result->fetch_assoc()){
    echo '<div class="profilePicture">';
 
    echo '<img class="profilePictureImg" src="' . $image_path .$userId . '.png">';
    
    echo '</div>';
    echo '<div class="profileBio">';
    echo $row['user_profile_bio'];
    echo '<br>';
    echo '</div>';
}





$image_path = "profilePics/";


$sql = <<<SQL
   select follow_followed_user_id, user_username, user_id
    from users
    join follow on follow_followed_user_id = user_id
    where follow_user_id = $userId
;

  
SQL;



$result = mysqli_query($conn, $sql);
echo '<div class="following">';
echo '<h3>Following</h3>';
echo '</div>';
echo '<div class="names">';
while($row = $result->fetch_assoc()){
   
    echo '<a href="index.php?content=Otherprofile&userId=' . $row['user_id'] . '"><img class="profilePic" src="' . $image_path . $row['user_id'] . '.png"></a>';
    echo $row['user_username'];
    echo '<br>';

}
echo '</div>';




$sql = <<<SQL
   select follow_user_id, user_username,user_id
    from users
    join follow on follow_user_id = user_id
    where follow_followed_user_id = $userId
;

  
SQL;


$result = mysqli_query($conn, $sql);
echo '<div class="followedBy">';
echo '<h3>Followed By</h3>';
echo '</div>';
echo '<div class="names">';
while($row = $result->fetch_assoc()){
    
   
    echo '<a href="index.php?content=Otherprofile&userId=' . $row['user_id'] . '"><img class="profilePic" src="' . $image_path . $row['user_id'] . '.png"></a>';
    echo $row['user_username'];
    echo '<br>';
}
echo '</div>';

        }
    }
    
