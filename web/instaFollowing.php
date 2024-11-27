<script>
function isElementVisible(element) {
    return element && element.offsetHeight > 0;
}


function showPeopleList(){

    const list = document.getElementById("peopleList");
    const result = document.getElementById("results")
    result.style.display = "none";
    list.style.display = "block";
    

}

function removePeopleList(){
    const list = document.getElementById("peopleList");
    
    if(isElementVisible(list)){
        list.style.display = "none";
    }

}


function performSearch() {
    removePeopleList()

    console.log("past")
    const query = document.getElementById('searchText').value; // Get the query from the input field

    if (!query.trim()) {
        showPeopleList()
    }

    // Create a new XMLHttpRequest object
    const xhr = new XMLHttpRequest();

    // Open a GET request to the searchResults.php script with the query as a parameter
    xhr.open('GET', 'searchResults.php?query=' + encodeURIComponent(query), true);

    // Handle the request when the response is received
    
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Success! Update the results div with the server's response
            document.getElementById('results').innerHTML = xhr.responseText;
        } else {
            // If there was a server error, handle it
            document.getElementById('results').innerHTML = 'Error: Unable to fetch results.';
        }
    };

    // Handle any network errors
    xhr.onerror = function() {
        document.getElementById('results').innerHTML = 'Error: Network error.';
    };

    // Send the request
    
    xhr.send();


}




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
        $('#follow' + userId).html('Following');
        
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
    


echo '<div class="searchBar">';
echo '<input id="searchText" type="text" name="query" placeholder="Search..." class="search-input">'; // Text input
echo '<button type="button" onclick="performSearch()" class="search-button">Search</button>'; // Search button with JS function
echo '</div>';

// Section where the search results will be displayed
echo '<div id="results" class="search-results"></div>';







    echo'<div id="peopleList" class="peopleList">';
    while ($row = $result->fetch_assoc())
    {
            
            echo'<div class="person">';
            echo '<h5><a href="index.php?content=Otherprofile&user_id=' . $row['user_id'] . '">';
            echo '<a href="index.php?content=Otherprofile&userId=' . $row['user_id'] . '"><img class="profilePic" src="' . $image_path . $row['user_id'] . '.png"></a>';
            echo $row['user_username'];
            

            // echo'<div class="followButton">';
           

            if(isset ($row['follow_id'])){

                echo '</a><button class="followButton" id="follow' . $row['user_id'] . '">' ;
                
                echo 'Following';
    
            }else{
                echo '</a><button class="followButton" id="follow' ;
                echo  $row['user_id'] ;
                echo '" onclick="follow(' . $row['user_id'] . ')"> ';
                echo 'Follow';
            }
            echo '</button>';

            // echo'</div>';
            echo'</div>';
            echo'</h5>' ;
            


           
       
        
    
    }
    echo'</div>';

}else{
    echo'<div class="notLoggedIn">';
    echo'<h1>Not Logged In</h1>';
    
    echo'<h3>You can not view content on this page. </h3>';
    echo'<h3>Please <a class="signUp" href="index.php?content=Login"> Log In </a>';
    echo'If you have an account, or ';
    echo'<a class="signUp" href="index.php?content=Register"> Sign Up</a> if you dont have one.</h3>';
    
    
    echo'</div>';
}












