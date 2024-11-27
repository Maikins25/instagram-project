
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
include('library.php');
$conn = get_database_connection();


$group_Id = isset($_GET['groupId']) ? (int)$_GET['groupId'] : 0;
$image_path = "profilePics/";



$gcPeopleSql = <<<SQL
SELECT user_username, user_profile_picture_name, user_id
from `groups`join group_members on group_id = member_group_id
join users on user_id = member_user_id
where group_id = $group_Id;
SQL;



$gcPeopleResult = mysqli_query($conn, $gcPeopleSql);

echo'<button class="xButton" onclick="togglePeopleList()">x</button>';
echo'<h1 style="text-align:center;">Group Members<h1>';


while ($row = $gcPeopleResult->fetch_assoc())
        {
                
                echo'<div class="gcPerson">';

                echo '<h5><a href="index.php?content=Otherprofile&user_id=' . $row['user_id'] . '">';
                echo '<a href="index.php?content=Otherprofile&userId=' . $row['user_id'] . '"><img class="profilePic" src="' . $image_path . $row['user_id'] . '.png"></a>';
                echo $row['user_username'];
                
    
      
    
                // echo'</div>';
                echo'</div>';
                echo'</h5>' ;
                
    
    
               
           
            
        
        }
