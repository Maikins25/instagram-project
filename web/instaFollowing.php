<script>


    function follow(user_id){
        var settings = {
            'async': true,
            'url': 'follow.php?followed_user_id=' + user_id,
            'method': 'POST',
            'headers': {
                'Cache-Control': 'no-cache'
            }
        };
        console.log(user_id);
        console.log(settings);
        $.ajax(settings).done(function(response) {
            // window.location.replace('index.php?content=Feed');
            $('#follow' + user_id).html('following');
           
        }).fail(function() {
            alert('didnt work');
        });
        
    }

</script>


<?php



$sql = <<<SQL
SELECT user_username, user_id, follow_followed_user_id
FROM users
left outer join follow on follow_user_id = user_id
where user_id = $user
and user_id != follow_followed_user_id


SQL;

$conn = get_database_connection();

$result = mysqli_query($conn, $sql);


while ($row = $result->fetch_assoc())
{
   
       echo '<h5>' . $row['user_username'] . '<button id="follow' . $row['user_id'] . '" onclick="follow(' . $row['user_id'] . ')"> Follow</button>' . '</h5>' ;

   
    

}










