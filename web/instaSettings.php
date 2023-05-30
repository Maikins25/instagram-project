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
            echo '<form action="update.php" method="POST" enctype="multipart/form-data">';
            echo '<label for="profilePicture">Select a Profile Picture:</label>';
            echo '<input type="file" id="profilePicture" name="profilePicture">';

            echo '<br>';

            echo '<label for="Bio">About you</label>';
            echo '<input type="text" id="Bio" name="Bio">';


                
            
            echo '<button type="submit" class="btn btn-primary">Save</button>';

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

        }
    }
}









