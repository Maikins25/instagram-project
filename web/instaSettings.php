<script>
function signOut(){
    
    location.href = 'signOut.php?';
}
</script>

<?php

if(isset($user)){

// echo $user;
$conn = get_database_connection();

$sql = <<<SQL
SELECT *
FROM users 
where user_id = $user
SQL;


$result = mysqli_query($conn, $sql);


if($row = $result->fetch_assoc()){
    
    // echo $row['user_profile_created'];

        if($row['user_profile_created'] == 0){
            echo '<div class="createProfilePic">';
            echo '<form action="update.php" method="POST" enctype="multipart/form-data">';
            echo '<label for="profilePicture">Select a Profile Picture:</label>';
            echo '<input type="file" id="profilePicture" name="profilePicture">';
            echo '</div>';
            
            echo '<br>';
            echo '<div class="createProfileBio">';
            echo '<label for="Bio">About you</label>';
            echo '<input type="text" id="Bio" name="Bio">';
            
            
            
            echo '<button type="submit" class="btn btn-primary">Save</button>';
            echo '</div>';
            
            echo '</form>';
            
        }else{

            $image_path = "profilePics/";



$sql = <<<SQL
    select *
    from users
    where user_id = $user
   
  
SQL;






$result = mysqli_query($conn, $sql);


while($row = $result->fetch_assoc()){
    echo '<div class="yourProfile">';
    echo '<h1>Your profile</h1>';
    echo '<br>';
    echo '<img class="userProfilePic" src="' . $image_path .$user . '.png">';
    echo '<br>';
    echo $row['user_profile_bio'];
    echo '<br>';
    echo '</div>';
    
}







$sql = <<<SQL
   select follow_followed_user_id, user_username,user_id
    from users
    join follow on follow_followed_user_id = user_id
    where follow_user_id = $user
;

  
SQL;



$result = mysqli_query($conn, $sql);
echo '<br>';
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
    where follow_followed_user_id = $user
;

  
SQL;



$result = mysqli_query($conn, $sql);
echo '<br>';
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
    echo '<div class="signOutProfile">';
    echo '<button onclick="signOut()">Sign Out</button>';
    echo '</div>';
}else{
    echo '<h1>Log In or Sign Up to See Your Profile</h1>';
}










