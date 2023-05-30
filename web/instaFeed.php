<script>
function crumble(postId){
console.log('ran');
let textArea = document.getElementById(postId);
location.href = 'uploadCrumble.php?id=' + postId + '&crumble=' + textArea.value;

}
</script>


<h1> Here is the instagraham feed </h1>

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
SELECT post_id, post_caption, user_username
FROM post 
JOIN users ON user_id = post_user_id
SQL;


$result = mysqli_query($conn, $sql);


$image_path = "images/";
$i = 0;
while ($row = $result->fetch_assoc())
{
    $i = $i + 1;
    echo '<div class="post">';

    echo '<div class="center">';
    echo '<img src="' . $image_path . $row['post_id'] . '.png">';
    echo '</div>';

    echo '<h5>' . $row['post_caption'] . '</h5>';
    echo '<h5> Posted by @' . $row['user_username'] . '</h5>';
    echo '</div>';
    echo '<div class="center">';
    echo '<button onclick="crumble(' . $row['post_id'] . ')">Leave a crumble</button>';
    echo '<textArea id="'. $i .'"></textArea>';
    echo '</div>';

    
}



