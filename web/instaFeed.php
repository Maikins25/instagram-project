
<script>
function crumble(postId){

    console.log('ran');
    let textArea = document.getElementById(postId);
    if(textArea.value != ''){
        location.href = 'uploadCrumble.php?id=' + postId + '&crumb=' + textArea.value;

    }    

}
</script>



<table class='table table-bordered table-hover'>
    <thead>
        <tr class="table-dark">
            <th></th>
           
            
        </tr>
    </thead>
    <tbody class="table-group-divider">

<?php

$conn = get_database_connection();

$sql = <<<SQL
SELECT post_id, post_caption, up.user_username as postUser,comment_words, uc.user_username as commentUser
FROM post 
JOIN users up ON up.user_id = post_user_id
left outer Join (comments 

join users uc on comment_commenter = uc.user_id) on comment_post_id = post_id
SQL;


$result = mysqli_query($conn, $sql);


$image_path = "images/";
$i = 0;
$lastPostId = 0;
while ($row = $result->fetch_assoc())
{
    if($lastPostId != $row['post_id']){
        if($lastPostId != 0){
            echo '</div>';

        }
        echo '<div class="post">';
    
        echo '<div class="image">';
        echo '<img src="' . $image_path . $row['post_id'] . '.png">';
        echo '</div>';
    
        echo '<h5>' . $row['post_caption'] . '</h5>';
        echo '<h5> Posted by @' . $row['postUser'] . '</h5>';
        
        echo '<div class="center">';
        echo '<button onclick="crumble(' . $row['post_id'] . ')">Leave a crumb</button>';
        echo '<textArea id="'. $row['post_id'].'"></textArea>';
        echo '</div>';

    }
  

    echo '<div>';
    echo $row['comment_words'] . '-' . $row['commentUser'];
    echo '</div>';

    $lastPostId = $row['post_id'];
}

echo '</div>';
?>





