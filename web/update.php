<?php

include('library.php');


$conn = get_database_connection();

$imagename = $_FILES['profilePicture']['name'];

$imagetemp = $_FILES['profilePicture']['tmp_name'];

//The path you wish to upload the image to
$imagePath = "/profilePics/";


$bio = mysqli_real_escape_string($conn, $Bio);




if(move_uploaded_file($imagetemp, get_absolute_path('profilePics/') . $user . '.png')) {
    //TODO - Use the proper file type when the image is put into the images folder
    echo "Sussecfully uploaded your image."; 
    
}



$sql = <<<SQL
update users 
set user_profile_bio = '$bio', user_profile_picture_name = '$user.png', user_profile_created = 1
where user_id = $user

SQL;
echo $sql;

mysqli_query($conn, $sql);
    


$conn->close();
