
<script>
function changeBackground(){
    const body = document.getElementById('body');
    body.style.background = none;
}

function isElementVisible(element) {
    return element && element.offsetHeight > 0;
}

function toggleComments(event, postId) {
    const postDiv = event.target.closest('.post');
    const commentListDiv = postDiv.querySelector('.commentList');
    
    if (isElementVisible(commentListDiv)) {
        hideCommentButton(postId);
        hideCommentBox(postDiv); 
        hideCommentList(postDiv);
        console.log("In function");
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

</script>








<?php
echo '<script>changeBackground()</script>';
if(isset($user)){
$conn = get_database_connection();

$sql = <<<SQL
SELECT post_id, post_caption, up.user_username as postUser,comment_words, uc.user_username as commentUser, like_user_id, like_post_id
FROM post 
JOIN users up ON up.user_id = post_user_id
left outer join likes on like_post_id = post_id and like_user_id = $user
left outer Join (comments 
join users uc on comment_commenter = uc.user_id) on comment_post_id = post_id
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
        echo '<button class="threeDots" "><img class="threeDotsImg" src="images/threeDots.png"></img></button>';
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
            echo '<div class="realTextArea">';
            echo '<textarea id="commentInput' . $row['post_id'] . '" class="feed-text-area-styles" placeholder="Write your comment..."></textarea>';
            echo '<button class="submit-button" onclick="submitComment(' . $row['post_id'] . ')"><img class="sendButton" src="images/send.png"></button>';
            echo '</div>'; // Close realTextArea div
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
        echo'<h3>Please <a class="signUp" href="index.php?content=Login"> Log In </a>';
        echo'If you have an account, or ';
        echo'<a class="signUp" href="index.php?content=Register"> Sign Up</a> if you dont have one.</h3>';


    echo'</div>';
}

?>





