<script>


    function follow(userId){
        var settings = {
            'async': true,
            'url': 'follow.php?followed_user_id=' + userId,
            'method': 'POST',
            'headers': {
                'Cache-Control': 'no-cache'
            }
        };
        console.log(userId);
        console.log(settings);
        $.ajax(settings).done(function(response) {
            // window.location.replace('index.php?content=Feed');
            $('#follow' + userId).html('following');
           
        }).fail(function() {
            alert('didnt work');
        });
        
    }

</script>


<?php
if(isset($user)){
    $sql = <<<SQL
    SELECT user_username, user_id, follow_id
    FROM users
    left outer join follow on follow_user_id = $user and follow_followed_user_id = user_id
    
    where user_id <> $user
    
    SQL;
    
    $conn = get_database_connection();
    
    $result = mysqli_query($conn, $sql);
    
    
    while ($row = $result->fetch_assoc())
    {
            echo '<div class="username">';
            echo '</div>';
            echo '<h5><a href="index.php?content=Otherprofile&user_id=' . $row['user_id'] . '">';
            echo '<a href="index.php?content=Otherprofile&userId=' . $row['user_id'] . '"><img class="profilePic" src="' . $image_path . $row['user_id'] . '.png"></a>';
            echo $row['user_username'];
            
            echo '</a><button id="follow' ;
            echo  $row['user_id'] ;
            echo '" onclick="follow(' . $row['user_id'] . ')"> ';
            if(isset ($row['follow_id'])){
                echo 'Following';
    
            }else{
                echo 'Follow';
            }
            echo '</button>' . '</h5>' ;
           
       
        
    
    }

}else{
    echo '<h1>Log in or Sign up to See Your Friends</h1>';
}











