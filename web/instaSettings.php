<script>

function isElementVisible(element) {
    return element && element.offsetHeight > 0;
}

function toggleDropdown(event, postId) {
    const postDiv = event.target.closest('.post');
    const dropdown = postDiv.querySelector('#dropdown' + postId);
    const isVisible = dropdown.style.display === 'block';
    
    dropdown.style.display = isVisible ? 'none' : 'block';
}

function deletePost(postId) {
    if (confirm('Are you sure you want to delete this post?')) {
        location.href = 'deletePost.php?postId=' + postId;
    }
}

function directMessages() {
    location.href = 'directMessages.php';
}


function toggleComments(event, postId) {
    const postDiv = event.target.closest('.post');
    const commentListDiv = postDiv.querySelector('.commentList');

    if (isElementVisible(commentListDiv)) {
        hideCommentButton(postId);
        hideCommentBox(postDiv); 
        hideCommentList(postDiv);
    } else {
        showCommentButton(postId);
        showCommentBox(postDiv);
        showCommentList(postDiv);
    }
}

function showOptions(event) {
    const postDiv = event.target.closest('.post');
    const optionsDiv = postDiv.querySelector('.comment-options');
    
    // Toggle comment options
    const isVisible = optionsDiv.style.display === 'block';
    optionsDiv.style.display = isVisible ? 'none' : 'block'; 

    // Hide comment box if options are shown
    if (!isVisible) {
        const commentBoxDiv = postDiv.querySelector('.comment-box');
        commentBoxDiv.style.display = 'none';
    }
}

function showCommentList(postDiv) {
    const commentListDiv = postDiv.querySelector('.commentList');
    commentListDiv.style.display = 'block';
}

function showCommentBox(postDiv) {
    const commentBoxDiv = postDiv.querySelector('.comment-box');
    commentBoxDiv.style.display = 'block';
}

function hideCommentBox(postDiv) {
    const commentBoxDiv = postDiv.querySelector('.comment-box');
    if (commentBoxDiv) commentBoxDiv.style.display = 'none';
}

function hideCommentList(postDiv) {
    const commentListDiv = postDiv.querySelector('.commentList');
    if (commentListDiv) commentListDiv.style.display = 'none';
}

function hideCommentButton(postId) {
    const commentButton = document.getElementById('commentButton' + postId);
    if (commentButton) commentButton.style.display = 'none';
}

function showCommentButton(postId) {
    const commentButton = document.getElementById('commentButton' + postId);
    if (commentButton) commentButton.style.display = 'block';
}

function submitComment(postId) {
    const commentInput = document.getElementById('commentInput' + postId);
    const comment = commentInput.value;
    
    if (comment != '') {
        location.href = 'uploadCrumble.php?id=' + postId + '&crumb=' + comment;
    }    
}

function crumble(postId) {
    let textArea = document.getElementById(postId);
    if (textArea.value != '') {
        location.href = 'uploadCrumble.php?id=' + postId + '&crumb=' + textArea.value;
    }
}

function makeLikedPost(postId) {
    const likeButton = document.getElementById("likeButton" + postId);
    const likedButton = document.getElementById("likedButton" + postId);
    console.log("in makeLikedPost function with id: " + postId);


    if (likedButton && likeButton) {
        likedButton.style.display = 'block';
        likeButton.style.display = 'none';
    }
}

function makeLikedImage(event) {
    const postDiv = event.target.closest('.post');
    const likedDiv = postDiv.querySelector('.liked');
    const likeDiv = postDiv.querySelector('.like');
    
    if (likedDiv && likeDiv) {
        likedDiv.style.display = 'block';
        likeDiv.style.display = 'none';
    }
}

function like(postId, event, isLiked) {
    if (isLiked) {
        prompt("image is already liked");
    } else {
        makeLikedImage(event);
        location.href = 'uploadLike.php?postId=' + postId;
    }
}

// above are feed scripts
//below are profile Scripts


function signOut(){
    
    location.href = 'signOut.php?';
}

function editProfile(){

    const editProfile = document.getElementById("editProfile");
    const bioText = document.getElementById("bioText");

    if(isElementVisible(bioText)){
        bioText.style.display = "none";
    }else{
        bioText.style.display = "block";
    }


    if (isElementVisible(editProfile)) {
        editProfile.style.display = "none";
  
    } else {
        editProfile.style.display = "block";
        
    }
}


function displayFollowing(){
    const following = document.getElementById("following");
    const follwingNames = document.getElementById("followingNames");

    const div = document.getElementById("bigFollowingDiv")

    div.style.display = "block";
    following.style.display = "block";
    followingNames.style.display = "block";
}

function displayFollowedBy(){
    const followedBy = document.getElementById("followedBy");
    const followedByNames = document.getElementById("followedByNames");
    const div = document.getElementById("bigFollowedByDiv")

    div.style.display = "block";
    followedBy.style.display = "block";
    followedByNames.style.display = "block";
}

function hideFollowing(){
    const following = document.getElementById("following");
    const follwingNames = document.getElementById("followingNames");
    const div = document.getElementById("bigFollowingDiv")


    div.style.display = "none";
    following.style.display = "none";
    followingNames.style.display = "none";
}

function hideFollowedBy(){
    const followedBy = document.getElementById("followedBy");
    const followedByNames = document.getElementById("followedByNames");
    const div = document.getElementById("bigFollowedByDiv")

    div.style.display = "none";
    followedBy.style.display = "none";
    followedByNames.style.display = "none";
}


function isElementVisible(element) {
    return element && element.offsetHeight > 0;
}

function toggleFollowedBy(){
    console.log("in toggleFollowedBy")
    
    const following = document.getElementById("followedBy");

    console.log("past1")

    if (isElementVisible(following)) {
        console.log("ElementIsVisible")
        hideFollowedBy()
    } else {
        console.log("ElementNotVisible")
        displayFollowedBy()
    }
}



function toggleFollowing(){
    console.log("in toggleFollowing")
    
    const following = document.getElementById("following");

    console.log("past1")

    if (isElementVisible(following)) {
        console.log("ElementIsVisible")
        hideFollowing()
    } else {
        console.log("ElementNotVisible")
        displayFollowing()
    }
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

        // if($row['user_profile_created'] == 0){
        //     echo '<div class="createProfilePic">';
        //     echo '<form action="update.php" method="POST" enctype="multipart/form-data">';
        //     echo '<label for="profilePicture">Select a Profile Picture:</label>';
        //     echo '<input type="file" id="profilePicture" name="profilePicture">';
        //     echo '</div>';
            
        //     echo '<br>';
        //     echo '<div class="createProfileBio">';
        //     echo '<label for="Bio">About you</label>';
        //     echo '<input type="text" id="Bio" name="Bio">';
            
            
            
        //     echo '<button type="submit" class="btn btn-primary">Save</button>';
        //     echo '</div>';
            
        //     echo '</form>';
            
        // }else{
if(isset($user)){


        
            $image_path = "profilePics/";



$sql = <<<SQL
    select *
    from users
    where user_id = $user
   
  
SQL;






$result = mysqli_query($conn, $sql);


while($row = $result->fetch_assoc()){

    echo '<div class="signOutProfile">';
    echo '<button class="signOutButton" onclick="signOut()">Sign Out</button>';
   

    
    echo '<button class="signOutButton" onclick="editProfile()">Edit Profile</button>';
    echo '<a href="index.php?content=directMessages" class="signOutButton">Direct Messages</a>';

    echo '</div>';

    echo '<div class="yourProfile">';


        echo '<h1 style="margin-top:20px";>Your profile</h1>';

        echo'<div class="userProfile">';
        echo'<h2 style="font-size:20px;margin-top:20px;">@' . $row['user_username'] . '</h2>';

        echo '<img class="userProfilePic" src="' . $image_path . $user . '.png">';
    
        echo'<br>';

    echo'<div id="bioText" class="bioText">';
    echo $row['user_profile_bio'];
    echo'</div>';


    
    //edit profile picture
    echo'<div id="editProfile" class="editProfile">';
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
echo'</div>';


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



echo'<div class="followingButtons">';
    echo'<button onclick="toggleFollowing()" id="followingButton" class="followingButton">Following</button>';

    echo'<button onclick="toggleFollowedBy()" class="followedByButton"> Followed By </button>';
echo'</div>';

echo '<h1 style="margin-top:50px;">Your Posts</h1>';














echo '<br>';

echo '<div id="following" class="following">';
echo '<h3>Following</h3>';
echo '</div>';

echo'<div id="bigFollowingDiv" class="bigFollowingDiv">';


    echo '<div id="followingNames" class="followingNames">';
        while($row = $result->fetch_assoc()){
            echo'<div class="followingName">';
            echo '<a href="index.php?content=Otherprofile&userId=' . $row['user_id'] . '"><img class="profilePic" src="' . $image_path . $row['user_id'] . '.png"></a>';
            echo '&nbsp'. $row['user_username'];
            echo '<br>';
            echo'</div>';
            
        }
    echo '</div>';

echo'</div>';





$sql = <<<SQL
   select follow_user_id, user_username,user_id
    from users
    join follow on follow_user_id = user_id
    where follow_followed_user_id = $user
;

  
SQL;
$result = mysqli_query($conn, $sql);


    echo '<br>';

    echo '<div id="followedBy" class="followedBy">';
    echo '<h3>Followed By</h3>';
    echo '</div>';

    echo '<div id="bigFollowedByDiv" class=bigFollowedByDiv>';


        echo '<div id="followedByNames" class="followedByNames">';
        while($row = $result->fetch_assoc()){
            echo'<div class="followingName">';
            echo '<a  href="index.php?content=Otherprofile&userId=' . $row['user_id'] . '"><img class="profilePic" src="' . $image_path . $row['user_id'] . '.png"></a>';
            echo $row['user_username'];
            echo'</div>';
            echo '<br>';
            
        }




    echo '</div>';

    }
}
// Users Posts



if(isset($user)){
$conn = get_database_connection();

$sql = <<<SQL
SELECT post_id, post_caption, up.user_username as postUser,comment_words, uc.user_username as commentUser, like_user_id, like_post_id
FROM post 
JOIN users up ON up.user_id = post_user_id
left outer join likes on like_post_id = post_id and like_user_id = $user
left outer Join (comments 
join users uc on comment_commenter = uc.user_id) on comment_post_id = post_id
where post_user_id = $user
SQL;


$result = mysqli_query($conn, $sql);



//Comment query
$commentSql = <<<SQL
SELECT comment_post_id, comment_words, uc.user_username as commentUser
FROM comments 
JOIN users uc ON comment_commenter = uc.user_id
ORDER BY comment_post_id
SQL;

$commentResult = mysqli_query($conn, $commentSql);









$image_path = "images/";
$i = 0;
$lastPostId = 0;

//puts all comments in a list for use later
$comments = [];
while ($commentRow = $commentResult->fetch_assoc()) {
    $comments[$commentRow['comment_post_id']][] = $commentRow;
}




while ($row = $result->fetch_assoc())
{

   
    if($lastPostId != $row['post_id']){

        if($lastPostId != 0){
            echo '</div>';
            
        }
        
        echo '</div>';
        echo '<div class="post" id="' . $row['post_id'] .'">';
        echo '<h5>@' . $row['postUser'] . '</h5>';
    
        echo '<div class="image">';
        echo '<img class="postImg" src="' . $image_path . $row['post_id'] . '.png">';
        
        echo '</div>';


        $liked = false;
        if($user == $row['like_user_id'] and $row['post_id'] == $row['like_post_id']){
            $liked = true;
        }

        
        echo '<hr>';
        echo'<div class="captionDiv">';
        echo '<h5>@' . $row['postUser'].': '. $row['post_caption'] . '</h5>';
        echo'</div>';
        echo'<div class="postButtons">';
        echo'<button  id="likeButton' . $row['post_id'] . '" class="likeButton" onclick="like(' . $row['post_id'] .',event,' .$liked.')"> <img class="like" src="images/like2.png"></button>';


        echo '<button style="border:none; outline:none; background:transparent; display:none;" id="likedButton' . $row['post_id'] . '">
                <img class="liked" src="images/liked2.png">
              </button>';

        echo '<button class="commentButton" onclick="toggleComments(event,'. $row['post_id'] .');"><img class="comment-thing" src="images/comment-logo.png"></button>';


        // Three dots button to trigger the dropdown
        echo '<button class="threeDots" onclick="toggleDropdown(event, ' . $row['post_id'] . ');">';
        echo '<img class="threeDotsImg" src="images/threeDots.png">';
        echo '</button>';

        // Dropdown container (hidden by default)
        echo '<div id="dropdown' . $row['post_id'] . '" class="dropdown-menu" style="display: none;">';
        echo '<button class="dropdown-item" onclick="deletePost(' . $row['post_id'] . ');">Delete</button>';
        echo '</div>';

        echo'</div>';
        if($liked == true){
            
            echo '<script>makeLikedPost(' . $row['post_id'] . ');</script>';
        }
 


//Comment Container that is displayed when you click comment button
        if (isset($comments[$row['post_id']])) {

            


            echo '<div class="commentContainer">'; // Parent container
            echo '<div class="commentList">';
            echo '<div class="comment">' ;

            foreach ($comments[$row['post_id']] as $comment) {
                echo '<div>';
                echo '<h5>@' . $comment['commentUser']. '</h5>';
                echo'</div>';
                echo'<p>' . '&nbsp;' . '&nbsp;' .  '&nbsp;' . '&nbsp;'  . '&nbsp;' .  $comment['comment_words'] . '</p>';
                echo'<br>';
            }
                
        }else{

            echo '<div class="commentContainer">'; // Parent container
            echo '<div class="commentList">';
            echo '<div class="comment">' ;
            echo '<h5>Be the first to comment</h5>';
            
         }
            
            
            echo'</div>';

            echo '</div>'; // Close commentList div

            echo '<div class="comment-box" >'; // Hide initially
            echo'<br>';
            // echo '<div class="realTextArea">';
            echo '<textarea id="commentInput' . $row['post_id'] . '" class="text-area-styles" placeholder="Write your comment..."></textarea>';
            echo '<button class="submit-button" onclick="submitComment(' . $row['post_id'] . ')"><img class="sendButton" src="images/send.png"></button>';
            // echo '</div>'; // Close realTextArea div
            echo '</div>'; // Close comment-box div
        
        echo '</div>';
    }

    


   
    
    echo '</div>';
    
    
    $lastPostId = $row['post_id'];
}
// echo '<button onclick="crumble(' . $row['post_id'] . ')">Leave a crumb</button>';

echo '</div>';
}else{
    echo'<div class="notLoggedIn">';
    echo'<h1>Not Logged In</h1>';
    
    echo'<h3>You can not view content on this page. </h3>';
    echo'<h3>Please <a class="signUp" href="index.php?content=Register"> Log In </a>';
    echo'If you have an account, or ';
    echo'<a class="signUp" href="index.php?content=Register"> Sign Up</a> if you dont have one.</h3>';
    
    
    echo'</div>';
  
}












echo '</div>';  


// $conn = get_database_connection();

// $sql = <<<SQL
// SELECT post_id, post_caption, up.user_username as postUser,comment_words, uc.user_username as commentUser, like_user_id, like_post_id
// FROM post 
// JOIN users up ON up.user_id = post_user_id
// left outer join likes on like_post_id = post_id and like_user_id = $user
// left outer Join (comments 
// join users uc on comment_commenter = uc.user_id) on comment_post_id = post_id
// SQL;


// $result = mysqli_query($conn, $sql);







}else{
    echo'<div class="notLoggedIn">';
    echo'<h1>Not Logged In</h1>';
    
    echo'<h3>You can not view content on this page. </h3>';
    echo'<h3>Please <a class="signUp" href="index.php?content=Login"> Log In </a>';
    echo'If you have an account, or ';
    echo'<a class="signUp" href="index.php?content=Register"> Sign Up</a> if you dont have one.</h3>';
    
    
    echo'</div>';
  
}










