<h1> This is the save page</h1>

<?php

/*************************************************************************************************
 * save.php
 *
 * Page to save a single application. This page expects the following request paramaters to
 * be set:
 *
 * - appId (this value will be empty if saving a new record)
 * - cusId (this value will be empty if saving a new record)
 * - date
 * - firstName
 * - lastName
 * - phone
 * - email
 * - parkAreas - this is an array of IDs for park_area records
 *************************************************************************************************/


include('library.php');


$conn = get_database_connection();

$imagename = $_FILES['image']['name'];

$imagetemp = $_FILES['image']['tmp_name'];

//The path you wish to upload the image to
$imagePath = "/images/";
    


session_start();
$user =  $_SESSION['userId'];




$sql = <<<SQL
    INSERT INTO Post (post_name, post_user_id) VALUES ('$imagename', $user)
  
SQL;
echo $sql;

$conn->query($sql);
    

    
if(move_uploaded_file($imagetemp, get_absolute_path('images/') . $conn->insert_id . '.png')) {
    //TODO - Use the proper file type when the image is put into the images folder
    echo "Sussecfully uploaded your image.";
}

    


$conn->close();

header('Location: index.php?content=list');